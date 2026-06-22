<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKuasaWaarmeking extends Model
{
    use HasFactory;

    protected $table = 'surat_kuasa_waarmeking';
    protected $guarded = ['id'];

    public function pemberiKuasa()
    {
        return $this->hasMany(PemberiKuasaWaarmeking::class, 'surat_kuasa_waarmeking_id');
    }

    public function penerimaKuasa()
    {
        return $this->hasMany(PenerimaKuasaWaarmeking::class, 'surat_kuasa_waarmeking_id');
    }
}