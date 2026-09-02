<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SyncDmsUsers extends Command
{
    protected $signature = 'dms:sync-users';
    protected $description = 'Sinkronisasi user dari database DMS ke database lokal';

    const BRANCH_MAP = [
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
            // 1. Get all active users from sysUser
            $dmsUsers = DB::connection('dms')->select("
                SELECT 
                    UserId, 
                    Password, 
                    FullName, 
                    BranchCode
                FROM sysUser 
                WHERE IsActive = 1
                AND UserId IS NOT NULL
            ");

            // 2. Get all positions from HrEmployee
            $hrEmployees = DB::connection('dms')->select("
                SELECT 
                    RelatedUser, 
                    Position
                FROM HrEmployee 
                WHERE RelatedUser IS NOT NULL
            ");

            // 3. Map positions by RelatedUser
            $positions = [];
            foreach ($hrEmployees as $emp) {
                $positions[strtolower(trim($emp->RelatedUser))] = trim($emp->Position);
            }

            $count = 0;

            foreach ($dmsUsers as $dmsUser) {
                $userId = trim($dmsUser->UserId);
                $lowerUserId = strtolower($userId);
                
                $cabang = self::BRANCH_MAP[trim($dmsUser->BranchCode)] ?? null;
                $position = $positions[$lowerUserId] ?? '';

                $role = null;
                if (strtoupper($userId) === 'DCAHOUNIT' || str_contains($lowerUserId, 'hounit')) {
                    $role = 'ho_unit';
                } elseif (in_array(strtoupper($position), ['BM', 'SH'])) {
                    $role = 'bm_sh';
                } elseif (strtoupper($position) === 'FD' || str_contains($lowerUserId, 'adh')) {
                    $role = 'adh';
                } elseif (strtoupper($position) === 'GM' || in_array(strtoupper($userId), ['DCASR', 'IT', 'HERUIT', 'MUMTAZIT', 'RIZKYIT'])) {
                    $role = 'om';
                }

                $email = $lowerUserId;
                $user = User::where('email', $email)->first();

                if (!$user) {
                    $user = new User();
                    $user->email = $email;
                }

                $user->name = trim($dmsUser->FullName) ?: $userId;
                $user->password = trim($dmsUser->Password);
                $user->cabang = $cabang;

                if ($role === 'om') {
                    $user->is_admin = 1;
                    $user->is_admin_stock = 1;
                    $user->role = 'om';
                } elseif ($role === 'bm_sh') {
                    $user->is_admin = 0;
                    $user->is_admin_stock = 0;
                    $user->role = 'bm_sh';
                } elseif ($role === 'adh') {
                    $user->is_admin = 0;
                    $user->is_admin_stock = 0;
                    $user->role = 'adh';
                } elseif ($role === 'ho_unit') {
                    $user->is_admin = 0;
                    $user->is_admin_stock = 1;
                    $user->role = 'ho_unit';
                }

                $user->branch = $cabang;
                $user->save();
                $count++;
            }

            $this->info("Berhasil sinkronisasi {$count} user dari DMS!");

        } catch (\Exception $e) {
            $this->error('Gagal sinkronisasi: ' . $e->getMessage());
        }
    }
}
