<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara manual agar rapi
    protected $table = 'perusahaan';

    // Mengizinkan kolom ini diisi data dari form
    protected $fillable = [
        'nama',
        'deskripsi',
        'overdue',
    ];
}