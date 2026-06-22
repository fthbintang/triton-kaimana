<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKuasa extends Model
{
    use HasFactory;

    protected $table = 'surat_kuasa';
    protected $guarded = ['id'];

    // Relasi: Satu surat kuasa mempunyai banyak pemberi kuasa (ahli waris)
    public function pemberiKuasa()
    {
        return $this->hasMany(PemberiKuasa::class, 'surat_kuasa_id');
    }

    // Relasi: Satu surat kuasa mempunyai banyak penerima kuasa
    public function penerimaKuasa()
    {
        return $this->hasMany(PenerimaKuasa::class, 'surat_kuasa_id');
    }
}