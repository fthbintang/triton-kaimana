<div class="card shadow-sm border-0 rounded-3">
    <!-- HEADER UTAMA FORM -->
    <div class="card-header bg-court text-white p-4 text-center rounded-top-3 position-relative">

        <a href="{{ route('kuasa-insidentil.surat-kuasa.index') }}" wire:navigate
            class="btn btn-sm btn-outline-light position-absolute start-0 top-50 translate-middle-y ms-3 rounded-2 shadow-sm d-inline-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i>
            <span class="d-none d-md-inline">Kembali</span>
        </a>

        <h5 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">
            Formulir Surat Kuasa Insidentil
        </h5>
        <p class="text-white-50 small m-0 mt-1">
            Isilah data di bawah ini secara lengkap dan benar sesuai dengan dokumen asli
        </p>
    </div>

    <div class="card-body p-4 p-md-5">

        <form wire:submit.prevent="save">

            <div class="mb-5">
                <h5 class="text-court fw-bold border-bottom pb-2 mb-3">
                    <span class="badge badge-court me-2">I</span> Kontak Utama Pemohon
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small mb-1">Nomor HP / WhatsApp Aktif</label>
                        <input type="text" wire:model="no_hp_pemohon"
                            class="form-control @error('no_hp_pemohon') is-invalid @enderror"
                            placeholder="Contoh: 081234xxxxxx">
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                            * Pastikan nomor ini aktif agar petugas kami bisa menghubungi Anda jika diperlukan.
                        </small>
                        @error('no_hp_pemohon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <h5 class="text-court fw-bold border-bottom pb-2 mb-3">
                    <span class="badge badge-court me-2">II</span> Klasifikasi Perkara
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small mb-1">Sifat Perkara</label>
                        <select wire:model="sifat_perkara"
                            class="form-select @error('sifat_perkara') is-invalid @enderror">
                            <option value="">-- Pilih Sifat Perkara --</option>
                            <!-- Ubah value menjadi huruf kecil semua -->
                            <option value="permohonan">Permohonan (Satu Pihak / Voluntair)</option>
                            <option value="gugatan">Gugatan (Ada Lawan / Kontenisius)</option>
                        </select>
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                            * Pilih jenis berkas perkara yang akan diajukan ke Pengadilan Negeri Kaimana.
                        </small>
                        @error('sifat_perkara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h5 class="text-court fw-bold m-0">
                        <span class="badge badge-court me-2">III</span> Pihak I: Pemberi Kuasa
                    </h5>
                    <button type="button" wire:click="tambahPemberi"
                        class="btn btn-sm btn-outline-court fw-semibold rounded-pill px-3">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Orang
                    </button>
                </div>

                <div class="alert alert-info border-0 bg-info bg-opacity-10 text-dark small rounded-3 mb-3 p-3">
                    <p class="fw-bold mb-1 text-info-dark">
                        <i class="bi bi-info-circle-fill me-1"></i> KETENTUAN PEMBERI KUASA:
                    </p>
                    <p class="m-0 text-muted" style="font-size: 0.8rem;">
                        Masukkan data pihak yang memberikan kuasa hukum insidentil. Pastikan nama, NIK, dan alamat yang
                        diinput telah sesuai dengan dokumen identitas resmi (KTP) yang berlaku.
                    </p>
                </div>

                @foreach ($pemberi_kuasa as $index => $pemberi)
                    <div class="card bg-light border-0 mb-3 shadow-sm rounded-3" wire:key="pemberi-{{ $index }}">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-secondary rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                                        Orang Ke-{{ $index + 1 }}
                                    </span>
                                </div>

                                @if (count($pemberi_kuasa) > 1)
                                    <button type="button" wire:click="hapusPemberi({{ $index }})"
                                        class="btn btn-sm btn-link text-danger text-decoration-none p-0 fw-medium">
                                        <i class="bi bi-trash3-fill me-1"></i> Hapus
                                    </button>
                                @endif
                            </div>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Nama Lengkap</label>
                                    <input type="text" wire:model="pemberi_kuasa.{{ $index }}.nama"
                                        class="form-control form-control-sm" placeholder="Sesuai KTP">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">NIK (16 Digit Angka
                                        KTP)</label>
                                    <input type="text" wire:model="pemberi_kuasa.{{ $index }}.nik"
                                        class="form-control form-control-sm" maxlength="16"
                                        placeholder="Contoh: 9102...">
                                    <small class="text-muted" style="font-size: 0.7rem; font-weight: 500;">* Lihat angka
                                        paling atas di KTP Anda</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Jenis Kelamin</label>
                                    <select wire:model="pemberi_kuasa.{{ $index }}.jenis_kelamin"
                                        class="form-select form-select-sm @error('pemberi_kuasa.' . $index . '.jenis_kelamin') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    @error('pemberi_kuasa.' . $index . '.jenis_kelamin')
                                        <div class="invalid-feedback small" style="font-size: 11px;">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Agama</label>
                                    <input type="text" wire:model="pemberi_kuasa.{{ $index }}.agama"
                                        class="form-control form-control-sm"
                                        placeholder="Contoh: Kristen, Islam, Katolik">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Pekerjaan</label>
                                    <input type="text" wire:model="pemberi_kuasa.{{ $index }}.pekerjaan"
                                        class="form-control form-control-sm" placeholder="Contoh: Petani, PNS, Swasta">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Alamat Lengkap (Sesuai
                                        KTP)</label>
                                    <textarea wire:model="pemberi_kuasa.{{ $index }}.alamat" class="form-control form-control-sm" rows="2"
                                        placeholder="Tuliskan nama jalan, RT/RW, kampung/kelurahan, dan kecamatan..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <h5 class="text-court fw-bold m-0">
                        <span class="badge badge-court me-2">IV</span> Pihak II: Penerima Kuasa
                    </h5>
                    <button type="button" wire:click="tambahPenerima"
                        class="btn btn-sm btn-outline-court fw-semibold rounded-pill px-3">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Penerima
                    </button>
                </div>
                <p class="text-muted small mb-3 fst-italic">
                    * Penerima Kuasa adalah pihak yang ditunjuk untuk mewakili atau menghadiri persidangan/keperluan di
                    pengadilan.
                </p>

                @foreach ($penerima_kuasa as $index => $penerima)
                    <div class="card bg-light border-0 mb-3 shadow-sm rounded-3"
                        wire:key="penerima-{{ $index }}">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-dark rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                                        Penerima Ke-{{ $index + 1 }}
                                    </span>
                                </div>

                                @if (count($penerima_kuasa) > 1)
                                    <button type="button" wire:click="hapusPenerima({{ $index }})"
                                        class="btn btn-sm btn-link text-danger text-decoration-none p-0 fw-medium">
                                        <i class="bi bi-trash3-fill me-1"></i> Hapus
                                    </button>
                                @endif
                            </div>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Nama Lengkap</label>
                                    <input type="text" wire:model="penerima_kuasa.{{ $index }}.nama"
                                        class="form-control form-control-sm" placeholder="Sesuai KTP">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">NIK (16 Digit Angka
                                        KTP)</label>
                                    <input type="text" wire:model="penerima_kuasa.{{ $index }}.nik"
                                        class="form-control form-control-sm" maxlength="16"
                                        placeholder="Contoh: 9102...">
                                    <small class="text-muted" style="font-size: 0.7rem; font-weight: 500;">* Lihat
                                        angka paling atas di KTP Anda</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Jenis Kelamin</label>
                                    <select wire:model="penerima_kuasa.{{ $index }}.jenis_kelamin"
                                        class="form-select form-select-sm @error('penerima_kuasa.' . $index . '.jenis_kelamin') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    @error('penerima_kuasa.' . $index . '.jenis_kelamin')
                                        <div class="invalid-feedback small" style="font-size: 11px;">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Agama</label>
                                    <input type="text" wire:model="penerima_kuasa.{{ $index }}.agama"
                                        class="form-control form-control-sm"
                                        placeholder="Contoh: Kristen, Islam, Katolik">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Pekerjaan</label>
                                    <input type="text" wire:model="penerima_kuasa.{{ $index }}.pekerjaan"
                                        class="form-control form-control-sm"
                                        placeholder="Contoh: Petani, PNS, Swasta">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Alamat Lengkap (Sesuai
                                        KTP)</label>
                                    <textarea wire:model="penerima_kuasa.{{ $index }}.alamat" class="form-control form-control-sm" rows="2"
                                        placeholder="Tuliskan nama jalan, RT/RW, kampung/kelurahan, dan kecamatan..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row g-2 mt-4 pt-3 border-top">
                <div class="col-6 col-md-3 order-1">
                    <a href="{{ route('kuasa-insidentil.surat-kuasa.index') }}" wire:navigate
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

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('permohonan-sukses', (event) => {
            // Ambil data event dengan aman untuk Livewire v3 (baik objek langsung atau array)
            let eventData = Array.isArray(event) ? event[0] : event;
            let namaPemohon = eventData.nama || (eventData.detail && eventData.detail.nama) ||
                'Pemohon';

            Swal.fire({
                title: "Pendaftaran Berhasil!",
                html: '<div class="text-start small">' +
                    '<p class="text-center fw-semibold text-success mb-3">Permohonan Surat Kuasa Insidentil Anda berhasil dikirim!</p>' +
                    '<hr>' +
                    '<ol class="ps-3 mb-0 text-muted">' +
                    '<li class="mb-2">Silakan ke <strong>Meja PTSP Hukum</strong> untuk proses pencetakan dokumen Surat Kuasa Anda.</li>' +
                    '<li>Sampaikan perwakilan nama ahli waris utama: <br>' +
                    '<span class="badge bg-success text-white mt-1 px-3 py-2 fs-6 w-100 text-truncate">' +
                    '<i class="bi bi-person-fill me-1"></i> ' + namaPemohon +
                    '</span>' +
                    '</li>' +
                    '</ol>' +
                    '</div>',
                icon: "success",
                confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Selesai',
                confirmButtonColor: '#0A5C36',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.navigate('/');
                }
            });
        });
    });
</script>
