<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            // Branch Manager
            [
                'name' => 'Ade',
                'email' => 'ade@dca.com',
                'password' => Hash::make('adedca123'),
                'role' => 'BM',
                'cabang' => 'Cipanas',
            ],
            [
                'name' => 'Afri',
                'email' => 'afri@dca.com',
                'password' => Hash::make('afridca123'),
                'role' => 'BM',
                'cabang' => 'Cianjur',
            ],
            [
                'name' => 'Bagja',
                'email' => 'bagja@dca.com',
                'password' => Hash::make('bagjadca123'),
                'role' => 'BM',
                'cabang' => 'Cinere',
            ],
            [
                'name' => 'Ronald',
                'email' => 'ronald@dca.com',
                'password' => Hash::make('ronalddca123'),
                'role' => 'BM',
                'cabang' => 'Ciawi',
            ],
            [
                'name' => 'Aria',
                'email' => 'aria@dca.com',
                'password' => Hash::make('ariadca123'),
                'role' => 'BM',
                'cabang' => 'Jatiasih',
            ],

            // Operation Manager
            [
                'name' => 'OM DCA',
                'email' => 'om@dca.com',
                'password' => Hash::make('omdca123'),
                'role' => 'OM',
                'cabang' => 'HO',
            ],

            // Admin
            [
                'name' => 'Admin DCA',
                'email' => 'admin@dca.com',
                'password' => Hash::make('admindca123'),
                'role' => 'Admin',
                'cabang' => 'HO',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
