<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\FormWaarmeking;

Route::get('/', function () {
    return view('portal');
})->name('portal');

// Route form waarmeking yang sudah kita buat sebelumnya (pastikan sudah ada)
Route::get('/layanan/waarmeking', FormWaarmeking::class)->name('layanan.waarmeking');

// Route placeholder untuk layanan lainnya (bisa Anda hubungkan ke component masing-masing nanti)
Route::get('/layanan/surat-kuasa', function() { return 'Halaman Surat Kuasa Insidentil (Sedang Dikembangkan)'; })->name('layanan.surat-kuasa');
Route::get('/layanan/tidak-dipidana', function() { return 'Halaman Surat Keterangan Tidak Pernah Dipidana (Sedang Dikembangkan)'; })->name('layanan.tidak-dipidana');