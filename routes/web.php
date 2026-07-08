<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\FormWaarmeking\FormPermohonan as WaarmekingPermohonan;
use App\Livewire\FormWaarmeking\FormSuratKuasa as WaarmekingSuratKuasa;
use App\Livewire\FormKuasaInsidentil\FormPermohonan as KuasaInsidentilPermohonan;
use App\Livewire\FormKuasaInsidentil\FormSuratKuasa as KuasaInsidentilSuratKuasa;
use App\Livewire\TidakPernahDipidana\FormKeteranganTidakDihukum as TidakDipidanaPernyataan;

Route::get('/', function () {
    return view('portal');
})->name('portal');

// =========================================================================
// 1. MODUL WAARMEKING
// =========================================================================
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


// =========================================================================
// 2. MODUL KUASA INSIDENTIL
// =========================================================================
Route::livewire('/permohonan/kuasa-insidentil', KuasaInsidentilPermohonan::class)->name('permohonan.kuasa-insidentil.index');
Route::livewire('/permohonan/kuasa-insidentil/tambah', KuasaInsidentilPermohonan::class)->name('permohonan.kuasa-insidentil.create');
Route::livewire('/permohonan/kuasa-insidentil/edit/{id}', KuasaInsidentilPermohonan::class)->name('permohonan.kuasa-insidentil.edit');
Route::get('/permohonan/cetak-permohonan/kuasa-insidentil-pdf/{id}', KuasaInsidentilPermohonan::class)->name('cetak.kuasa-insidentil.pdf');
Route::get('/permohonan/cetak-permohonan/kuasa-insidentil-word/{id}', [KuasaInsidentilPermohonan::class, 'bikinWordDownload'])->name('cetak.kuasa-insidentil.word');

Route::livewire('/surat-kuasa/kuasa-insidentil', KuasaInsidentilSuratKuasa::class)->name('kuasa-insidentil.surat-kuasa.index');
Route::livewire('/surat-kuasa/kuasa-insidentil/tambah', KuasaInsidentilSuratKuasa::class)->name('kuasa-insidentil.surat-kuasa.create');
Route::livewire('/surat-kuasa/kuasa-insidentil/edit/{id}', KuasaInsidentilSuratKuasa::class)->name('kuasa-insidentil.surat-kuasa.edit');
Route::livewire('/surat-kuasa/cetak-surat-kuasa/kuasa-insidentil-pdf/{id}', KuasaInsidentilSuratKuasa::class)->name('cetak.surat-kuasa.kuasa-insidentil.pdf');
Route::get('/surat-kuasa/cetak-surat-kuasa/kuasa-insidentil-word/{id}', [KuasaInsidentilSuratKuasa::class, 'bikinWordDownload'])->name('cetak.surat-kuasa.kuasa-insidentil.word');

// =========================================================================
// 3. MODUL TIDAK PERNAH DIHUKUM
// =========================================================================
Route::livewire('/surat-pernyataan/tidak-dipidana', TidakDipidanaPernyataan::class)->name('tidak-dipidana.surat-pernyataan-tidak-dihukum');
Route::livewire('/surat-pernyataan/tidak-dipidana/tambah', TidakDipidanaPernyataan::class)->name('tidak-dipidana.surat-pernyataan-tidak-dihukum.create');
Route::livewire('/surat-pernyataan/tidak-dipidana/edit/{id}', TidakDipidanaPernyataan::class)->name('tidak-dipidana.surat-pernyataan-tidak-dihukum.edit');
Route::livewire('/surat-pernyataan/tidak-dipidana/pernyataan-tidak-dihukum-pdf/{id}', TidakDipidanaPernyataan::class)->name('cetak.surat-pernyataan-tidak-dihukum.pdf');
Route::get('/surat-pernyataan/tidak-dipidana/pernyataan-tidak-dihukum-word/{id}', [TidakDipidanaPernyataan::class, 'bikinWordDownload'])->name('cetak.surat-pernyataan-tidak-dihukum.word');