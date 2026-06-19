<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-court text-white p-4 text-center rounded-top-3">
        <h5 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">
            Formulir Surat Permohonan Waarmeking
        </h5>
        <p class="text-white-50 small m-0 mt-1">
            Isilah data di bawah ini secara lengkap dan benar sesuai dengan dokumen asli
        </p>
    </div>

    <div class="card-body p-4 p-md-5">

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
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Tempat Lahir</label>
                        <input type="text" wire:model="tempat_lahir"
                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                            placeholder="Kota/Kabupaten">
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Tanggal Lahir</label>
                        <input type="date" wire:model="tanggal_lahir"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror">
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Jenis Kelamin</label>
                        <select wire:model="jenis_kelamin"
                            class="form-select @error('jenis_kelamin') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Agama</label>
                        <input type="text" wire:model="agama"
                            class="form-control @error('agama') is-invalid @enderror" placeholder="Agama Pemohon">
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Pekerjaan</label>
                        <input type="text" wire:model="pekerjaan"
                            class="form-control @error('pekerjaan') is-invalid @enderror"
                            placeholder="Pekerjaan Sekarang">
                        @error('pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Nama Pewaris (Almarhum/ah)</label>
                        <input type="text" wire:model="nama_pewaris" placeholder="Contoh: Alm. John Doe"
                            class="form-control @error('nama_pewaris') is-invalid @enderror">
                        @error('nama_pewaris')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold text-muted small">Alamat Lengkap (Sesuai Domisili)</label>
                        <textarea wire:model="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror"
                            placeholder="Tuliskan nama jalan, RT/RW, kelurahan, dan kecamatan..."></textarea>
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
                    <button type="button" wire:click="tambahBank"
                        class="btn btn-sm btn-outline-court fw-semibold rounded-pill px-3">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Bank
                    </button>
                </div>

                @foreach ($daftar_rekening as $index => $rekening)
                    <div class="card bg-light border-0 mb-3 shadow-sm rounded-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-secondary rounded-pill px-3">Rekening
                                    #{{ $index + 1 }}</span>
                                @if (count($daftar_rekening) > 1)
                                    <button type="button" wire:click="hapusBank({{ $index }})"
                                        class="btn btn-sm btn-link text-danger text-decoration-none p-0 fw-medium">
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
                                        placeholder="Masukkan nomor rekening"
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
                                        class="form-control form-control-sm bg-white text-muted fst-italic fw-semibold border-light-subtle">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

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
                    <button type="submit" class="btn btn-court w-100 py-2 fw-bold rounded-3 shadow-sm">
                        Kirim Form <i class="bi bi-send-fill ms-1 small"></i>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<!-- SCRIPT LISTENER SWEETALERT2 -->
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('permohonan-sukses', (event) => {
            // Ambil nama dari event detail sesuai standar Livewire terbaru
            const namaPemohon = event.nama || event[0].nama;

            Swal.fire({
                title: "Pendaftaran Berhasil!",
                html: `
                    <div class="text-start small">
                        <p class="text-center fw-semibold text-success mb-3">Permohonan Waarmeking Anda berhasil dikirim ke sistem TRITON!</p>
                        <hr>
                        <ol class="ps-3 mb-0 text-muted">
                            <li class="mb-2">Silakan kembali ke <strong>Meja PTSP Hukum</strong> untuk dibantu petugas mencetak Surat Permohonan Anda.</li>
                            <li>Sampaikan kepada petugas bahwa permohonan diajukan atas nama: <br>
                                <span class="badge bg-court text-white mt-1 px-3 py-2 fs-6 w-100 text-truncate">
                                    <i class="bi bi-person-fill me-1"></i> ${namaPemohon}
                                </span>
                            </li>
                        </ol>
                    </div>
                `,
                icon: "success",
                confirmButtonText: '<i class="bi bi-arrow-left-circle me-1"></i> Selesai & Kembali',
                confirmButtonColor: '#2c3e50',
                allowOutsideClick: false,
                customClass: {
                    popup: 'rounded-4 shadow'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.navigate('/');
                }
            });
        });
    });
</script>
