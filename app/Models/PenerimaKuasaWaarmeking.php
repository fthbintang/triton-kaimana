<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaKuasaWaarmeking extends Model
{
    use HasFactory;

    protected $table = 'penerima_kuasa_waarmeking';
    protected $guarded = ['id'];

    public function suratKuasa()
    {
        return $this->belongsTo(SuratKuasaWaarmeking::class, 'surat_kuasa_waarmeking_id');
    }
}