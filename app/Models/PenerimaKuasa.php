<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaKuasa extends Model
{
    use HasFactory;

    protected $table = 'penerima_kuasa';
    protected $guarded = ['id'];

    public function suratKuasa()
    {
        return $this->belongsTo(SuratKuasa::class, 'surat_kuasa_id');
    }
}