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
Route::get('/permohonan/cetak-permohonan/waarmeking-word/{id}', [WaarmekingPermohonan::class, 'bikinWordDownload'])->name('cetak.waarmeking.word');

Route::livewire('/surat-kuasa/waarmeking', WaarmekingSuratKuasa::class)->name('waarmeking.surat-kuasa.index');
Route::livewire('/surat-kuasa/waarmeking/tambah', WaarmekingSuratKuasa::class)->name('waarmeking.surat-kuasa.create');
Route::livewire('/surat-kuasa/waarmeking/edit/{id}', WaarmekingSuratKuasa::class)->name('waarmeking.surat-kuasa.edit');
Route::livewire('/surat-kuasa/cetak-surat-kuasa/waarmeking-pdf/{id}', WaarmekingSuratKuasa::class)->name('cetak.surat-kuasa.waarmeking.pdf');
Route::get('/surat-kuasa/cetak-surat-kuasa/waarmeking-word/{id}', [WaarmekingSuratKuasa::class, 'bikinWordDownload'])->name('cetak.surat-kuasa.waarmeking.word');

Route::livewire('/layanan/permohonan-surat-kuasa-insidentil', KuasaInsidentilPermohonan::class)
    ->name('layanan.permohononan-kuasa-insidentil');

Route::livewire('/layanan/tidak-dipidana', TidakDipidanaPermohonan::class)
    ->name('layanan.tidak-dipidana');