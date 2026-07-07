<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemberiKuasa extends Model
{
    use HasFactory;

    protected $table = 'pemberi_kuasa';
    protected $guarded = ['id'];

    public function suratKuasa()
    {
        return $this->belongsTo(SuratKuasa::class, 'surat_kuasa_id');
    }
}