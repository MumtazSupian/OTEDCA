<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminStockSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'adminstock@admin.com',
            ],
            [
                'name' => 'Admin Stock',
                'password' => bcrypt('AdminStock123!'),
                'branch' => 'stock', 
                'is_admin' => false,
                'is_admin_stock' => true, 
            ]
        );
    }
}