<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKuasa extends Model
{
    use HasFactory;

    protected $table = 'surat_kuasa';
    protected $guarded = ['id'];

    public function pemberiKuasa()
    {
        return $this->hasMany(PemberiKuasa::class, 'surat_kuasa_id');
    }

    public function penerimaKuasa()
    {
        return $this->hasMany(PenerimaKuasa::class, 'surat_kuasa_id');
    }
}