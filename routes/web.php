<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\FormPermohonanWaarmeking;
use App\Livewire\FormPermohonanSuratKuasaWaarmeking;

Route::get('/', function () {
    return view('portal');
})->name('portal');

Route::get('/layanan/waarmeking', FormPermohonanWaarmeking::class)->name('layanan.waarmeking');

Route::get('/layanan/surat-kuasa', FormPermohonanSuratKuasaWaarmeking::class)->name('layanan.surat-kuasa');

// Route placeholder untuk layanan lainnya
Route::get('/layanan/tidak-dipidana', function() { return 'Halaman Surat Keterangan Tidak Pernah Dipidana (Sedang Dikembangkan)'; })->name('layanan.tidak-dipidana');