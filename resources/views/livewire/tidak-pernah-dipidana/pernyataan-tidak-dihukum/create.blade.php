<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-court text-white p-4 text-center rounded-top-3 position-relative">

        <a href="{{ route('tidak-dipidana.surat-pernyataan-tidak-dihukum') }}" wire:navigate
            class="btn btn-sm btn-outline-light position-absolute start-0 top-50 translate-middle-y ms-3 rounded-2 shadow-sm d-inline-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i>
            <span class="d-none d-md-inline">Kembali</span>
        </a>

        <h5 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">
            Formulir Surat Pernyataan Tidak Pernah Dihukum
        </h5>
        <p class="text-white-50 small m-0 mt-1">
            Isilah data di bawah ini secara lengkap dan benar
        </p>
    </div>

    <div class="card-body p-4 p-md-5">
        <form wire:submit.prevent="save">
            <div class="row g-3">

                <!-- IDENTITAS UTAMA -->
                <div class="col-12 border-bottom pb-2 mb-2">
                    <span class="fw-bold text-court small">
                        <i class="bi bi-person-fill me-1"></i> Identitas Diri Pemohon
                    </span>
                </div>

                {{-- Baris 1: Nama Lengkap (Full di mobile, mengambil 8 grid di desktop) & Jenis Kelamin (4 grid) --}}
                <div class="col-md-8">
                    <label class="form-label fw-semibold text-muted small mb-1">Nama Lengkap</label>
                    <input type="text" wire:model="nama_pemohon"
                        class="form-control form-control-sm @error('nama_pemohon') is-invalid @enderror"
                        placeholder="Sesuai KTP (Tanpa Singkatan)">
                    @error('nama_pemohon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
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

                {{-- Baris 2: Tempat Lahir, Tanggal Lahir, & Agama (Simetris: 4 - 4 - 4 grid) --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small mb-1">Tempat Lahir</label>
                    <input type="text" wire:model="tempat_lahir"
                        class="form-control form-control-sm @error('tempat_lahir') is-invalid @enderror"
                        placeholder="Kota / Kabupaten">
                    @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small mb-1">Tanggal Lahir</label>
                    <input type="date" wire:model="tanggal_lahir"
                        class="form-control form-control-sm @error('tanggal_lahir') is-invalid @enderror">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small mb-1">Agama</label>
                    <input type="text" wire:model="agama"
                        class="form-control form-control-sm @error('agama') is-invalid @enderror"
                        placeholder="Contoh: Islam / Kristen">
                    @error('agama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Baris 3: Pekerjaan, Jabatan, & No HP (Simetris: 4 - 4 - 4 grid) --}}
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
                    <small class="text-muted d-block" style="font-size: 0.65rem; margin-top: 2px;">
                        * Isi tanda (-) jika tidak ada jabatan spesifik.
                    </small>
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

                {{-- Baris 4: Alamat Lengkap (Full 12 grid) --}}
                <div class="col-12">
                    <label class="form-label fw-semibold text-muted small mb-1">Alamat Lengkap (Sesuai KTP)</label>
                    <textarea wire:model="alamat" rows="3" class="form-control form-control-sm @error('alamat') is-invalid @enderror"
                        placeholder="Contoh: Jl. Cenderawasih, RT 04/RW 02, Kelurahan Kaimana Kota, Distrik Kaimana"></textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- TOMBOL AKSI RESPONSIF -->
                <div class="col-12 mt-4 pt-3 border-top">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                        <a href="{{ route('tidak-dipidana.surat-pernyataan-tidak-dihukum') }}" wire:navigate
                            class="btn btn-light border text-secondary px-4 py-2 fw-semibold rounded-3 shadow-sm order-2 order-md-1">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>

                        <button type="submit" wire:loading.attr="disabled"
                            class="btn btn-court rounded-pill fw-semibold px-4 py-2 order-1 order-md-2">
                            <span wire:loading.remove><i class="bi bi-send-fill me-1"></i> Kirim Form</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>Menyimpan...
                            </span>
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
