<?php

use Illuminate\Support\Facades\Route;

// 1. Import Class Livewire dari Sub-Folder Baru
use App\Livewire\FormWaarmeking\FormPermohonan as WaarmekingPermohonan;
use App\Livewire\FormWaarmeking\FormSuratKuasa as WaarmekingSuratKuasa;
use App\Livewire\FormKuasaInsidentil\FormPermohonan as KuasaInsidentilPermohonan;

Route::get('/', function () {
    return view('portal');
})->name('portal');

// 2. Routing Menggunakan Standar Livewire 4.x & Nama Class Baru (Alias)
Route::livewire('/layanan/permohonan-waarmeking', WaarmekingPermohonan::class)
    ->name('layanan.waarmeking');

Route::livewire('/layanan/surat-kuasa-waarmeking', WaarmekingSuratKuasa::class)
    ->name('layanan.surat-kuasa');

Route::livewire('/layanan/permohonan-surat-kuasa-insidentil', KuasaInsidentilPermohonan::class)
    ->name('layanan.permohononan-kuasa-insidentil');

// Route placeholder untuk layanan lainnya
Route::get('/layanan/tidak-dipidana', function() { 
    return 'Halaman Surat Keterangan Tidak Pernah Dipidana (Sedang Dikembangkan)'; 
})->name('layanan.tidak-dipidana');