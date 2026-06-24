<div class="container py-4">
    <!-- NOTIFIKASI SUKSES / GAGAL -->
    @if (session()->has('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <!-- CARD FORM INPUT -->
    <div class="card bg-white border-light shadow-sm rounded-3">
        <div class="card-header bg-court text-white py-2 fw-semibold">
            Form Dokumen Surat Keterangan Tidak Pernah Dipidana & Surat Pernyataan
        </div>

        <div class="card-body">
            <form wire:submit.prevent="simpanPermohonan" class="row g-3">

                <!-- IDENTITAS UTAMA -->
                <div class="col-12 border-bottom pb-1 mb-1">
                    <span class="fw-bold text-court small"><i class="bi bi-person-fill me-1"></i> Identitas Diri
                        Pemohon</span>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small mb-1">Nama Lengkap</label>
                    <input type="text" wire:model="nama_pemohon"
                        class="form-control form-control-sm @error('nama_pemohon') is-invalid @enderror"
                        placeholder="Sesuai KTP (Tanpa Singkatan)">
                    @error('nama_pemohon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small mb-1">NIK (16 Digit KTP)</label>
                    <input type="text" wire:model="nik_pemohon" maxlength="16"
                        class="form-control form-control-sm @error('nik_pemohon') is-invalid @enderror"
                        placeholder="Contoh: 9102................">
                    @error('nik_pemohon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small mb-1">Tempat Lahir</label>
                    <input type="text" wire:model="tempat_lahir"
                        class="form-control form-control-sm @error('tempat_lahir') is-invalid @enderror"
                        placeholder="Kota / Kabupaten">
                    @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small mb-1">Tanggal Lahir</label>
                    <input type="date" wire:model="tanggal_lahir"
                        class="form-control form-control-sm @error('tanggal_lahir') is-invalid @enderror">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small mb-1">Jenis Kelamin</label>
                    <select wire:model="jenis_kelamin"
                        class="form-select form-select-sm @error('jenis_kelamin') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small mb-1">Agama</label>
                    <input type="text" wire:model="agama"
                        class="form-control form-control-sm @error('agama') is-invalid @enderror"
                        placeholder="Contoh: Islam / Kristen">
                    @error('agama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small mb-1">Pekerjaan</label>
                    <input type="text" wire:model="pekerjaan"
                        class="form-control form-control-sm @error('pekerjaan') is-invalid @enderror"
                        placeholder="Contoh: Wiraswasta / PNS / Tani">
                    @error('pekerjaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small mb-1">Jabatan</label>
                    <input type="text" wire:model="jabatan"
                        class="form-control form-control-sm @error('jabatan') is-invalid @enderror"
                        placeholder="Contoh: Staf / Kepala Kampung / -">
                    <small class="text-muted d-block" style="font-size: 0.7rem; margin-top: 2px;">* Isi tanda (-) jika
                        tidak ada jabatan spesifik.</small>
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small mb-1">No. HP / WhatsApp Aktif</label>
                    <input type="text" wire:model="no_hp_pemohon"
                        class="form-control form-control-sm @error('no_hp_pemohon') is-invalid @enderror"
                        placeholder="Contoh: 0812XXXXXXXX">
                    @error('no_hp_pemohon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold text-muted small mb-1">Alamat Lengkap (Sesuai KTP)</label>
                    <input type="text" wire:model="alamat"
                        class="form-control form-control-sm @error('alamat') is-invalid @enderror"
                        placeholder="Nama Jalan, RT/RW, Kampung / Kelurahan">
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- TOMBOL AKSI RESPONSIF -->
                <div class="row g-2 mt-4 pt-3 border-top">
                    <div class="col-6 col-md-3 order-1">
                        <a href="/" wire:navigate
                            class="btn btn-light border text-secondary w-100 py-2 fw-semibold rounded-3 shadow-sm">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                    <div class="col-12 col-md-6 order-3 order-md-2">
                    </div>
                    <div class="col-6 col-md-3 order-2 order-md-3">
                        <button type="submit" wire:loading.attr="disabled"
                            class="btn btn-court rounded-pill fw-semibold px-4">
                            <span wire:loading.remove><i class="bi bi-send-fill me-1"></i> Kirim Form</span>
                            <span wire:loading><span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>Menyimpan...</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
