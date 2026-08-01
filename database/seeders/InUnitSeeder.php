<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class InUnitSeeder extends Seeder
{
    public function run()
    {
        // ==========================================
        // 1. KEMBALIKAN ADMIN PIUTANG SEPERTI SEMULA
        // ==========================================
        $admJatiasih = User::where('branch', 'jatiasih')->first();
        if ($admJatiasih) {
            $admJatiasih->is_admin_stock = false; // Cabut akses In Unit
            $admJatiasih->save();
        }

        $admCinere = User::where('branch', 'cinere')->first();
        if ($admCinere) {
            $admCinere->is_admin_stock = false; // Cabut akses In Unit
            $admCinere->save();
        }


        // ==========================================
        // 2. BUAT AKUN BARU KHUSUS IN UNIT
        // ==========================================
        
        // Akun IN UNIT Jatiasih
        $inUnitJatiasih = User::where('email', 'inunit.jatiasih@suzuki.com')->first();
        if (!$inUnitJatiasih) {
            $inUnitJatiasih = new User();
            $inUnitJatiasih->email = 'inunit.jatiasih@suzuki.com';
        }
        $inUnitJatiasih->name = 'In Unit Jatiasih';
        $inUnitJatiasih->password = bcrypt('Jatiasih123!');
        $inUnitJatiasih->branch = 'inunit_jatiasih'; // Kunci Rahasia
        $inUnitJatiasih->is_admin = false;
        $inUnitJatiasih->is_admin_stock = true; // Supaya masuk ke menu IN UNIT
        $inUnitJatiasih->save();
        
        // Akun IN UNIT Cinere
        $inUnitCinere = User::where('email', 'inunit.cinere@suzuki.com')->first();
        if (!$inUnitCinere) {
            $inUnitCinere = new User();
            $inUnitCinere->email = 'inunit.cinere@suzuki.com';
        }
        $inUnitCinere->name = 'In Unit Cinere';
        $inUnitCinere->password = bcrypt('Cinere123!');
        $inUnitCinere->branch = 'inunit_cinere'; // Kunci Rahasia
        $inUnitCinere->is_admin = false;
        $inUnitCinere->is_admin_stock = true; // Supaya masuk ke menu IN UNIT
        $inUnitCinere->save();
    }
}
