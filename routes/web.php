<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\FormWaarmeking\FormPermohonan as WaarmekingPermohonan;
use App\Livewire\FormWaarmeking\FormSuratKuasa as WaarmekingSuratKuasa;
use App\Livewire\FormKuasaInsidentil\FormPermohonan as KuasaInsidentilPermohonan;
use App\Livewire\TidakPernahDipidana\FormPermohonan as TidakDipidanaPermohonan;

Route::get('/', function () {
    return view('portal');
})->name('portal');

Route::livewire('/permohonan/waarmeking', WaarmekingPermohonan::class)->name('waarmeking.index');
Route::livewire('/permohonan/waarmeking/tambah', WaarmekingPermohonan::class)->name('waarmeking.create');
Route::livewire('/permohonan/waarmeking/edit/{id}', WaarmekingPermohonan::class)->name('waarmeking.edit');
Route::livewire('/permohonan/cetak-permohonan/waarmeking-pdf/{id}', WaarmekingPermohonan::class)->name('cetak.waarmeking.pdf');
Route::livewire('/permohonan/cetak-permohonan/waarmeking-word/{id}', [WaarmekingPermohonan::class, 'bikinWordDownload'])->name('cetak.waarmeking.word');

Route::livewire('/layanan/surat-kuasa-waarmeking', WaarmekingSuratKuasa::class)
    ->name('layanan.surat-kuasa');

Route::livewire('/layanan/permohonan-surat-kuasa-insidentil', KuasaInsidentilPermohonan::class)
    ->name('layanan.permohononan-kuasa-insidentil');

Route::livewire('/layanan/tidak-dipidana', TidakDipidanaPermohonan::class)
    ->name('layanan.tidak-dipidana');