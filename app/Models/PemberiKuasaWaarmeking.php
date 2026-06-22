<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemberiKuasaWaarmeking extends Model
{
    use HasFactory;

    protected $table = 'pemberi_kuasa_waarmeking';
    protected $guarded = ['id'];

    public function suratKuasa()
    {
        return $this->belongsTo(SuratKuasaWaarmeking::class, 'surat_kuasa_waarmeking_id');
    }
}