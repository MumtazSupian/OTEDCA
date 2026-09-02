<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;

class MigrateLeadsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leads:migrate {old_db_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate leads from old database branch tables to the new leads table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oldDbName = $this->argument('old_db_name');
        $newDbName = DB::connection()->getDatabaseName();

        $this->info("Starting migration from database '$oldDbName' to '$newDbName'...");

        try {
            $pdo = DB::connection()->getPdo();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Non-strict mode for dates
            $pdo->exec("SET sql_mode = ''");

            // Backup first (just in case)
            $this->info("Backing up current leads table...");
            $pdo->exec("CREATE TABLE IF NOT EXISTS leads_backup LIKE leads");
            $pdo->exec("TRUNCATE TABLE leads_backup");
            $pdo->exec("INSERT INTO leads_backup SELECT * FROM leads");

            // Truncate current leads, spv_leads, sales_leads
            $this->info("Truncating leads, spv_leads, and sales_leads tables for fresh insert...");
            $pdo->exec("SET FOREIGN_KEY_CHECKS=0;");
            $pdo->exec("TRUNCATE TABLE leads");
            $pdo->exec("TRUNCATE TABLE spv_leads");
            $pdo->exec("TRUNCATE TABLE sales_leads");
            $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");

            $cabangs = [
                'cianjur' => 'cjr',
                'ciawi' => 'cwi',
                'cinere' => 'cnr',
                'jatiasih' => 'jts'
            ];
            $total = 0;

            foreach ($cabangs as $cabang => $prefix) {
                $this->info("Migrating SPV, Sales, and Leads data for branch: $cabang...");
                
                // 1. Migrate SPV
                $spvMap = [];
                $oldSpvs = $pdo->query("SELECT spv_id, spv, description FROM `$oldDbName`.`{$prefix}_spv`")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($oldSpvs as $spv) {
                    $stmt = $pdo->prepare("INSERT INTO `$newDbName`.spv_leads (nama, deskripsi, cabang, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
                    $stmt->execute([$spv['spv'], $spv['description'], $cabang]);
                    $spvMap[$spv['spv_id']] = $pdo->lastInsertId();
                }

                // 2. Migrate Sales
                $salesMap = [];
                $oldSales = $pdo->query("SELECT sls_id, sales, description FROM `$oldDbName`.`{$prefix}_sls`")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($oldSales as $sales) {
                    $stmt = $pdo->prepare("INSERT INTO `$newDbName`.sales_leads (nama, deskripsi, cabang, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
                    $stmt->execute([$sales['sales'], $sales['description'], $cabang]);
                    $salesMap[strtolower(trim($sales['sales']))] = $pdo->lastInsertId();
                }

                // ID Mappings between Old and New Database
                $statusMap = [
                    1 => 3, // UNFOLLOW UP
                    2 => 2, // FOLLOW UP
                    3 => 4, // PROSPEK
                    4 => 5, // HOT PROSPEK
                    5 => 6, // SPK
                    6 => 7, // LOST
                    7 => 9, // DO
                    8 => null, // FPJ SPAREPART
                    9 => null, // SPK SERVIS
                    10 => 8 // NO REPORT
                ];

                $sumberMap = [
                    1 => 1, // WEB -> Google Ads
                    2 => 2, // WEB ORGANIK -> Web Official Dealer
                    3 => 3, // FB/IG OFFICIAL -> FB/IG Official
                    4 => 4, // FB/IG CABANG -> FB/IG Cabang
                    5 => 5, // GMB -> GMB
                ];

                $unitMap = [
                    4 => 1, // XL7
                    7 => 2, // ERTIGA
                    8 => 3, // GRAND VITARA
                    9 => 4, // APV
                    10 => 5, // NEW CARRY
                    11 => 6, // S-PRESSO
                    12 => 7, // NEW BALENO
                    13 => 8, // JIMNY
                    21 => 9, // OTHER
                    22 => null, // IGNIS
                    23 => null, // NO REPORT (Unit)
                    24 => 10 // FRONX
                ];

                // 3. Migrate Leads
                $oldLeads = $pdo->query("SELECT * FROM `$oldDbName`.$cabang")->fetchAll(PDO::FETCH_ASSOC);
                $insertLeadStmt = $pdo->prepare("
                    INSERT INTO `$newDbName`.leads (
                        no_hp, nama, alamat, tanggal, cabang, 
                        sumber_id, unit_id, status_id, respon_id, spv_id, sales_id,
                        created_at, updated_at, update_1, update_2, update_3, bukti_screenshot
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                
                $count = 0;
                foreach ($oldLeads as $lead) {
                    $tanggal = ($lead['tgl_in'] == '0000-00-00') ? '1970-01-01' : $lead['tgl_in'];
                    $created = ($lead['created'] == '0000-00-00 00:00:00' || !$lead['created']) ? null : $lead['created'];
                    $updated = ($lead['updated'] == '0000-00-00 00:00:00' || !$lead['updated']) ? null : $lead['updated'];
                    
                    $newSpvId = $spvMap[$lead['spv_id']] ?? null;
                    $salesKey = strtolower(trim($lead['sales'] ?? ''));
                    $newSalesId = $salesMap[$salesKey] ?? null;

                    $mappedStatusId = $statusMap[$lead['status_id']] ?? null;
                    // IF old DB had status_id = 0, we treat it as NO REPORT (8) if that's what was expected.
                    if (empty($lead['status_id'])) $mappedStatusId = 8;
                    
                    $mappedSumberId = $sumberMap[$lead['sumber_id']] ?? null;
                    $mappedUnitId = $unitMap[$lead['unit_id']] ?? null;

                    $insertLeadStmt->execute([
                        $lead['hp'],
                        $lead['nama'],
                        $lead['alamat'],
                        $tanggal,
                        $cabang,
                        $mappedSumberId,
                        $mappedUnitId,
                        $mappedStatusId,
                        $lead['respon_id'],
                        $newSpvId,
                        $newSalesId,
                        $created,
                        $updated,
                        $lead['update_1'],
                        $lead['update_2'],
                        $lead['update_3'],
                        $lead['image']
                    ]);
                    $count++;
                }
                $total += $count;
                
                $this->line(" - Inserted $count leads for $cabang");
            }

            $this->info("Success! A total of $total leads have been migrated safely.");

        } catch (\Exception $e) {
            $this->error("Migration failed: " . $e->getMessage());
            
            // Restore from backup
            $this->info("Restoring from backup...");
            $pdo->exec("SET FOREIGN_KEY_CHECKS=0;");
            $pdo->exec("TRUNCATE TABLE leads");
            $pdo->exec("INSERT INTO leads SELECT * FROM leads_backup");
            $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");
            $this->info("Restore complete.");
        }
    }
}
