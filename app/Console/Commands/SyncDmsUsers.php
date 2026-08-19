<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SyncDmsUsers extends Command
{
    protected $signature = 'dms:sync-users';
    protected $description = 'Sync users from DMS sysUser and HrEmployee into local users table';

    private const BRANCH_MAP = [
        '641940101' => 'ciawi',
        '641940102' => 'cianjur',
        '641940103' => 'cinere',
        '641940104' => 'jatiasih',
        '641940105' => 'bp',
        '641940106' => 'cipanas',
    ];

    public function handle()
    {
        $this->info('Mulai sinkronisasi data user dari DMS...');

        try {
            $dmsUsers = DB::connection('dms')->select("
                SELECT 
                    u.UserId, 
                    u.Password, 
                    u.FullName, 
                    u.BranchCode, 
                    e.Position 
                FROM sysUser u 
                LEFT JOIN HrEmployee e ON u.UserId = e.RelatedUser 
                WHERE e.PersonnelStatus = 1
                AND u.UserId IS NOT NULL
            ");

            $count = 0;

            foreach ($dmsUsers as $dmsUser) {
                $cabang = self::BRANCH_MAP[trim($dmsUser->BranchCode)] ?? null;

                $role = null;
                $position = trim($dmsUser->Position ?? '');
                $userId = trim($dmsUser->UserId);

                if (strtoupper($userId) === 'DCAHOUNIT') {
                    $role = 'ho_unit';
                } elseif (in_array(strtoupper($position), ['BM', 'SH'])) {
                    $role = 'bm_sh';
                } elseif (strtoupper($position) === 'FD') {
                    $role = 'adh';
                } elseif (strtoupper($position) === 'GM') {
                    $role = 'om';
                }

                $email = strtolower($userId);
                $user = User::where('email', $email)->first();

                if (!$user) {
                    $user = new User();
                    $user->email = $email;
                }

                $user->name = trim($dmsUser->FullName) ?: $userId;
                $user->password = trim($dmsUser->Password);
                $user->cabang = $cabang;
                $user->branch = $cabang;
                $user->role = $role;

                if ($role === 'om') {
                    $user->is_admin = true;
                    $user->is_admin_stock = true;
                }

                $user->save();
                $count++;
            }

            $this->info("Berhasil sinkronisasi $count user dari DMS.");

        } catch (\Exception $e) {
            $this->error('Gagal sinkronisasi: ' . $e->getMessage());
        }
    }
}

