<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeder admin terlebih dahulu
        $this->call([
            AdminUserSeeder::class,
            AdminStockSeeder::class,
            InUnitSeeder::class,
        ]);

        $keep = [
            'admin@admin.com',
            'adminstock@admin.com',
            'AdminArStock@gmail.com',
            'admsvc.cwi.dca@gmail.com',
            'admsvc.cjr.dca@gmail.com',
            'admsvc.cnr.dca@gmail.com',
            'admsvc.jts.dca@gmail.com',
            'admbp.dcajts@gmail.com',
            'inunit.jatiasih@suzuki.com',
            'inunit.cinere@suzuki.com',
        ];

        // Pastikan akun Admin Stock tetap ada meski data user lain dibersihkan
        User::updateOrCreate(
            ['email' => 'adminstock@admin.com'],
            [
                'name' => 'Admin Stock',
                'password' => bcrypt('AdminStock123!'),
                'branch' => 'stock',
                'is_admin' => false,
                'is_admin_stock' => true,
            ]
        );

        // Hapus user lain yang tidak ada dalam daftar
        DB::table('users')->whereNotIn('email', $keep)->delete();

        // Data user cabang
        $users = [
            [
                'branch' => 'admin',
                'email' => 'AdminArStock@gmail.com',
                'name' => 'Admin AR Stock',
                'password' => 'AdminArStock123!',
                'is_admin' => true,
                'is_admin_stock' => true,
            ],
            [
                'branch' => 'ciawi',
                'email' => 'admsvc.cwi.dca@gmail.com',
                'name' => 'Ciawi',
                'password' => 'Ciawi12346789!',
            ],
            [
                'branch' => 'cianjur',
                'email' => 'admsvc.cjr.dca@gmail.com',
                'name' => 'Cianjur',
                'password' => 'Cianjur12346789!',
            ],
            [
                'branch' => 'cinere',
                'email' => 'admsvc.cnr.dca@gmail.com',
                'name' => 'Cinere',
                'password' => 'Cinere123!',
            ],
            [
                'branch' => 'jatiasih',
                'email' => 'admsvc.jts.dca@gmail.com',
                'name' => 'Jatiasih',
                'password' => 'Jatiasih123!',
            ],
            [
                'branch' => 'bp',
                'email' => 'admbp.dcajts@gmail.com',
                'name' => 'BP',
                'password' => 'BP123!',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                [
                    'email' => $u['email'],
                ],
                [
                    'name' => $u['name'],
                    'password' => bcrypt($u['password']),
                    'branch' => $u['branch'],
                    'is_admin' => $u['is_admin'] ?? false,
                    'is_admin_stock' => $u['is_admin_stock'] ?? false,
                ]
            );
        }
    }
}
