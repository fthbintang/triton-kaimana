<?php

use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

use App\Livewire\FormWaarmeking\FormPermohonan as WaarmekingPermohonan;
use App\Livewire\FormWaarmeking\FormSuratKuasa as WaarmekingSuratKuasa;
use App\Livewire\FormKuasaInsidentil\FormPermohonan as KuasaInsidentilPermohonan;
use App\Livewire\FormKuasaInsidentil\FormSuratKuasa as KuasaInsidentilSuratKuasa;
use App\Livewire\TidakPernahDipidana\FormKeteranganTidakDihukum as TidakDipidanaPernyataan;
use App\Livewire\TidakPernahDipidana\FormSuratKuasa as TidakDipidanaSuratKuasa;

Route::livewire('/', Login::class)->name('login')->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::get('/portal', function () {
        return view('livewire/portal');
    })->name('portal');

    Route::post('/logout', [Login::class, 'logout'])->name('logout');

    Route::get('/users', function () {
        return "Ini adalah halaman CRUD Kelola Pengguna (Sedang dalam pengembangan)";
    })->name('users.index');

    // =========================================================================
    // 1. MODUL WAARMEKING
    // =========================================================================
    Route::livewire('/portal/permohonan/waarmeking', WaarmekingPermohonan::class)->name('waarmeking.index');
    Route::livewire('/portal/permohonan/waarmeking/tambah', WaarmekingPermohonan::class)->name('waarmeking.create');
    Route::livewire('/portal/permohonan/waarmeking/edit/{id}', WaarmekingPermohonan::class)->name('waarmeking.edit');
    Route::livewire('/portal/permohonan/cetak-permohonan/waarmeking-pdf/{id}', WaarmekingPermohonan::class)->name('cetak.waarmeking.pdf');
    Route::get('/portal/permohonan/cetak-permohonan/waarmeking-word/{id}', [WaarmekingPermohonan::class, 'bikinWordDownload'])->name('cetak.waarmeking.word');

    Route::livewire('/portal/surat-kuasa/waarmeking', WaarmekingSuratKuasa::class)->name('waarmeking.surat-kuasa.index');
    Route::livewire('/portal/surat-kuasa/waarmeking/tambah', WaarmekingSuratKuasa::class)->name('waarmeking.surat-kuasa.create');
    Route::livewire('/portal/surat-kuasa/waarmeking/edit/{id}', WaarmekingSuratKuasa::class)->name('waarmeking.surat-kuasa.edit');
    Route::livewire('/portal/surat-kuasa/cetak-surat-kuasa/waarmeking-pdf/{id}', WaarmekingSuratKuasa::class)->name('cetak.surat-kuasa.waarmeking.pdf');
    Route::get('/portal/surat-kuasa/cetak-surat-kuasa/waarmeking-word/{id}', [WaarmekingSuratKuasa::class, 'bikinWordDownload'])->name('cetak.surat-kuasa.waarmeking.word');

    // =========================================================================
    // 2. MODUL KUASA INSIDENTIL
    // =========================================================================
    Route::livewire('/portal/permohonan/kuasa-insidentil', KuasaInsidentilPermohonan::class)->name('permohonan.kuasa-insidentil.index');
    Route::livewire('/portal/permohonan/kuasa-insidentil/tambah', KuasaInsidentilPermohonan::class)->name('permohonan.kuasa-insidentil.create');
    Route::livewire('/portal/permohonan/kuasa-insidentil/edit/{id}', KuasaInsidentilPermohonan::class)->name('permohonan.kuasa-insidentil.edit');
    Route::get('/portal/permohonan/cetak-permohonan/kuasa-insidentil-pdf/{id}', KuasaInsidentilPermohonan::class)->name('cetak.kuasa-insidentil.pdf');
    Route::get('/portal/permohonan/cetak-permohonan/kuasa-insidentil-word/{id}', [KuasaInsidentilPermohonan::class, 'bikinWordDownload'])->name('cetak.kuasa-insidentil.word');

    Route::livewire('/portal/surat-kuasa/kuasa-insidentil', KuasaInsidentilSuratKuasa::class)->name('kuasa-insidentil.surat-kuasa.index');
    Route::livewire('/portal/surat-kuasa/kuasa-insidentil/tambah', KuasaInsidentilSuratKuasa::class)->name('kuasa-insidentil.surat-kuasa.create');
    Route::livewire('/portal/surat-kuasa/kuasa-insidentil/edit/{id}', KuasaInsidentilSuratKuasa::class)->name('kuasa-insidentil.surat-kuasa.edit');
    Route::livewire('/portal/surat-kuasa/cetak-surat-kuasa/kuasa-insidentil-pdf/{id}', KuasaInsidentilSuratKuasa::class)->name('cetak.surat-kuasa.kuasa-insidentil.pdf');
    Route::get('/portal/surat-kuasa/cetak-surat-kuasa/kuasa-insidentil-word/{id}', [KuasaInsidentilSuratKuasa::class, 'bikinWordDownload'])->name('cetak.surat-kuasa.kuasa-insidentil.word');

    // =========================================================================
    // 3. MODUL TIDAK PERNAH DIHUKUM
    // =========================================================================
    Route::livewire('/portal/surat-pernyataan/tidak-dipidana', TidakDipidanaPernyataan::class)->name('tidak-dipidana.surat-pernyataan-tidak-dihukum');
    Route::livewire('/portal/surat-pernyataan/tidak-dipidana/tambah', TidakDipidanaPernyataan::class)->name('tidak-dipidana.surat-pernyataan-tidak-dihukum.create');
    Route::livewire('/portal/surat-pernyataan/tidak-dipidana/edit/{id}', TidakDipidanaPernyataan::class)->name('tidak-dipidana.surat-pernyataan-tidak-dihukum.edit');
    Route::livewire('/portal/surat-pernyataan/tidak-dipidana/pernyataan-tidak-dihukum-pdf/{id}', TidakDipidanaPernyataan::class)->name('cetak.surat-pernyataan-tidak-dihukum.pdf');
    Route::get('/portal/surat-pernyataan/tidak-dipidana/pernyataan-tidak-dihukum-word/{id}', [TidakDipidanaPernyataan::class, 'bikinWordDownload'])->name('cetak.surat-pernyataan-tidak-dihukum.word');

    Route::livewire('/portal/surat-kuasa/tidak-dipidana', TidakDipidanaSuratKuasa::class)->name('tidak-dipidana.surat-kuasa-tidak-dihukum');
    Route::livewire('/portal/surat-kuasa/tidak-dipidana/tambah', TidakDipidanaSuratKuasa::class)->name('tidak-dipidana.surat-kuasa-tidak-dihukum.create');
    Route::livewire('/portal/surat-kuasa/tidak-dipidana/edit/{id}', TidakDipidanaSuratKuasa::class)->name('tidak-dipidana.surat-kuasa-tidak-dihukum.edit');
    Route::livewire('/portal/surat-kuasa/cetak-surat-kuasa/surat-kuasa-tidak-dipidana-pdf/{id}', TidakDipidanaSuratKuasa::class)->name('cetak.surat-kuasa-tidak-dihukum.pdf');
    Route::get('/portal/surat-kuasa/cetak-surat-kuasa/surat-kuasa-tidak-dipidana-word/{id}', [TidakDipidanaSuratKuasa::class, 'bikinWordDownload'])->name('cetak.surat-kuasa-tidak-dihukum.word');
});