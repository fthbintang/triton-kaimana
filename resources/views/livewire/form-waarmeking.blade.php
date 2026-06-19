<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-court text-white p-3 text-center rounded-top-3">
        <h5 class="fw-bold m-0" style="letter-spacing: 0.5px;">FORMULIR PENDAFTARAN SURAT PERMOHONAN WAARMEKING</h5>
        <small class="text-white-50">Isilah data di bawah ini secara lengkap dan benar sesuai dokumen asli</small>
    </div>

    <div class="card-body p-4 p-md-5">

        @if ($pesan_sukses)
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <strong>Pendaftaran Berhasil!</strong> {{ $pesan_sukses }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form wire:submit.prevent="simpan">

            <div class="mb-5">
                <h5 class="text-court fw-bold border-bottom pb-2 mb-3">
                    <span class="badge badge-court me-2">I</span> Data Utama Pemohon
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Nama Lengkap Pemohon</label>
                        <input type="text" wire:model="nama_pemohon"
                            class="form-control @error('nama_pemohon') is-invalid @enderror" placeholder="Sesuai KTP">
                        @error('nama_pemohon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">NIK (16 Digit)</label>
                        <input type="text" wire:model="nik_pemohon" maxlength="16"
                            class="form-control @error('nik_pemohon') is-invalid @enderror"
                            placeholder="16 Digit Nomor Induk Kependudukan">
                        @error('nik_pemohon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">No. HP / WhatsApp (Aktif)</label>
                        <input type="text" wire:model="no_hp_pemohon"
                            class="form-control @error('no_hp_pemohon') is-invalid @enderror"
                            placeholder="Contoh: 081234xxxxxx">
                        @error('no_hp_pemohon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <h5 class="text-court fw-bold border-bottom pb-2 mb-3">
                    <span class="badge badge-court me-2">II</span> Data Detail Pemohon & Pewaris
                </h5>
                <div class="row g-3">
                    <!-- Tempat Lahir -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Tempat Lahir</label>
                        <input type="text" wire:model="tempat_lahir"
                            class="form-control @error('tempat_lahir') is-invalid @enderror">
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Tanggal Lahir</label>
                        <input type="date" wire:model="tanggal_lahir"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror">
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Jenis Kelamin</label>
                        <select wire:model="jenis_kelamin"
                            class="form-select @error('jenis_kelamin') is-invalid @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Agama -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Agama</label>
                        <input type="text" wire:model="agama"
                            class="form-control @error('agama') is-invalid @enderror">
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pekerjaan -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Pekerjaan</label>
                        <input type="text" wire:model="pekerjaan"
                            class="form-control @error('pekerjaan') is-invalid @enderror">
                        @error('pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Pewaris -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Nama Pewaris (Almarhum/ah)</label>
                        <input type="text" wire:model="nama_pewaris" placeholder="Contoh: Alm. John Doe"
                            class="form-control @error('nama_pewaris') is-invalid @enderror">
                        @error('nama_pewaris')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="col-12">
                        <label class="form-label fw-semibold text-muted small">Alamat Lengkap (Sesuai Domisili)</label>
                        <textarea wire:model="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror"
                            placeholder="Tuliskan alamat lengkap..."></textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h5 class="text-court fw-bold m-0">
                        <span class="badge badge-court me-2">III</span> Informasi Rekening Bank Pewaris
                    </h5>
                    <button type="button" wire:click="tambahBank" class="btn btn-sm btn-outline-court fw-semibold">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Rekening Bank
                    </button>
                </div>

                @foreach ($daftar_rekening as $index => $rekening)
                    <div class="card bg-light border-0 mb-3 shadow-sm rounded-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-secondary">Rekening #{{ $index + 1 }}</span>
                                @if (count($daftar_rekening) > 1)
                                    <button type="button" wire:click="hapusBank({{ $index }})"
                                        class="btn btn-sm btn-link text-danger text-decoration-none p-0">
                                        <i class="bi bi-trash3-fill me-1"></i> Hapus
                                    </button>
                                @endif
                            </div>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Nama Bank</label>
                                    <input type="text" wire:model="daftar_rekening.{{ $index }}.nama_bank"
                                        placeholder="Misal: Bank BRI"
                                        class="form-control form-control-sm @error('daftar_rekening.' . $index . '.nama_bank') is-invalid @enderror">
                                    @error('daftar_rekening.' . $index . '.nama_bank')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Cabang Kantor Bank</label>
                                    <input type="text"
                                        wire:model="daftar_rekening.{{ $index }}.cabang_bank"
                                        placeholder="Misal: KC Kaimana"
                                        class="form-control form-control-sm @error('daftar_rekening.' . $index . '.cabang_bank') is-invalid @enderror">
                                    @error('daftar_rekening.' . $index . '.cabang_bank')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Nomor Rekening</label>
                                    <input type="text"
                                        wire:model="daftar_rekening.{{ $index }}.nomor_rekening"
                                        class="form-control form-control-sm @error('daftar_rekening.' . $index . '.nomor_rekening') is-invalid @enderror">
                                    @error('daftar_rekening.' . $index . '.nomor_rekening')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Nominal Tabungan (Angka)</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-court text-white border-0">Rp</span>
                                        <input type="text"
                                            wire:model.live="daftar_rekening.{{ $index }}.nominal_angka"
                                            class="form-control @error('daftar_rekening.' . $index . '.nominal_angka') is-invalid @enderror"
                                            placeholder="Contoh: 5.000.000"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')">
                                        @error('daftar_rekening.' . $index . '.nominal_angka')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <label class="form-label text-muted small mb-1">Terbilang (Otomatis)</label>
                                    <input type="text"
                                        wire:model="daftar_rekening.{{ $index }}.nominal_huruf" readonly
                                        class="form-control form-control-sm bg-white text-muted fst-italic fw-semibold">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 border-top pt-3">
                <button type="submit" class="btn btn-court px-5 py-2 fw-bold shadow-sm">
                    <i class="bi bi-file-earmark-arrow-up-fill me-2"></i> Kirim Permohonan Resmi
                </button>
            </div>
        </form>
    </div>
</div>
