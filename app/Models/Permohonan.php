<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
use HasFactory;

    // 1. Mengunci nama tabel agar tidak mencari "permohonans"
    protected $table = 'permohonan'; 

    // 2. Mengizinkan semua kolom diisi secara massal
    protected $guarded = []; 

    // 3. Otomatis mengubah format JSON di database menjadi array saat dibaca di PHP
    protected $casts = [
        'data_spesifik' => 'array',
    ];
}