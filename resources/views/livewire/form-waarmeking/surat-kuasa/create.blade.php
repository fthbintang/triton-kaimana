<div class="card shadow-sm border-0 rounded-3">
    <!-- HEADER UTAMA FORM -->
    <div class="card-header bg-court text-white p-4 text-center rounded-top-3 position-relative">

        <a href="{{ route('waarmeking.surat-kuasa.index') }}" wire:navigate
            class="btn btn-sm btn-outline-light position-absolute start-0 top-50 translate-middle-y ms-3 rounded-2 shadow-sm d-inline-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i>
            <span class="d-none d-md-inline">Kembali</span>
        </a>

        <h5 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">
            Formulir Surat Kuasa Waarmeking
        </h5>
        <p class="text-white-50 small m-0 mt-1">
            Isilah data di bawah ini secara lengkap dan benar sesuai dengan dokumen asli
        </p>
    </div>

    <div class="card-body p-4 p-md-5">

        <div class="alert alert-success border-0 bg-success bg-opacity-10 rounded-3 mb-5 p-3 shadow-sm">
            <h6 class="fw-bold text-court mb-2"><i class="bi bi-info-circle-fill me-2"></i> 3 Langkah Mudah Mengurus
                Surat
                Kuasa:</h6>
            <div class="row g-3 small text-muted">
                <div class="col-md-4">
                    <span class="badge badge-court rounded-pill me-1">1</span> <strong>Isi Form Online:</strong>
                    Lengkapi data keluarga (ahli waris) & penerima di bawah ini.
                </div>
                <div class="col-md-4">
                    <span class="badge badge-court rounded-pill me-1">2</span> <strong>Kirim Permohonan:</strong>
                    Periksa kembali data, lalu klik tombol kirim di paling bawah.
                </div>
                <div class="col-md-4">
                    <span class="badge badge-court rounded-pill me-1">3</span> <strong>Datang ke Kantor:</strong> Bawa
                    KTP asli ke Meja PTSP Hukum PN Kaimana untuk ambil surat Anda.
                </div>
            </div>
        </div>

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
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <h5 class="text-court fw-bold m-0">
                        <span class="badge badge-court me-2">II</span> Pihak I: Pemberi Kuasa (Keluarga yang Tidak
                        Hadir)
                    </h5>
                    <button type="button" wire:click="tambahPemberi"
                        class="btn btn-sm btn-outline-court fw-semibold rounded-pill px-3">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Orang
                    </button>
                </div>

                <!-- TAMBAHAN PENJELASAN ATURAN URUTAN AHLI WARIS -->
                <div class="alert alert-warning border-0 bg-warning bg-opacity-10 text-dark small rounded-3 mb-3 p-3">
                    <p class="fw-bold mb-1 text-warning-dark">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> CARA ISI URUTAN STATUS (Sesuai Silsilah
                        Keluarga):
                    </p>
                    <ol class="ps-3 mb-0 text-muted" style="font-size: 0.8rem;">
                        <li>Sesuaikan urutan dengan silsilah asli (contoh: <strong>Istri Pewaris</strong>, <strong>Ahli
                                Waris I</strong>, <strong>Ahli Waris III</strong>).</li>
                        <li>Status ini dapat Anda edit manual pada kotak input abu-abu di setiap kartu data jika
                            urutannya melompat.</li>
                    </ol>
                </div>

                @foreach ($pemberi_kuasa as $index => $pemberi)
                    <div class="card bg-light border-0 mb-3 shadow-sm rounded-3" wire:key="pemberi-{{ $index }}">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <!-- STATUS SEKARANG MENGGUNAKAN INPUT AGAR BISA DIEDIT MANUAl -->
                                <div class="d-flex align-items-center" style="max-width: 250px;">
                                    <span
                                        class="input-group-text bg-secondary text-white border-0 small rounded-start-pill py-1 px-3"
                                        style="font-size: 0.8rem;">Status:</span>
                                    <select wire:model="pemberi_kuasa.{{ $index }}.urutan_ahli_waris"
                                        class="form-select form-select-sm bg-white border-0 rounded-end-pill fw-bold text-dark @error('pemberi_kuasa.' . $index . '.urutan_ahli_waris') is-invalid @enderror">
                                        <option value="">-- Pilih Status Silsilah --</option>
                                        <option value="Istri Pewaris">Istri Pewaris (Jika Suami Meninggal)</option>
                                        <option value="Suami Pewaris">Suami Pewaris (Jika Istri Meninggal)</option>

                                        <option value="Ahli Waris I">Ahli Waris I (Anak Kandung ke-1)</option>
                                        <option value="Ahli Waris II">Ahli Waris II (Anak Kandung ke-2)</option>
                                        <option value="Ahli Waris III">Ahli Waris III (Anak Kandung ke-3)</option>
                                        <option value="Ahli Waris IV">Ahli Waris IV (Anak Kandung ke-4)</option>
                                        <option value="Ahli Waris V">Ahli Waris V (Anak Kandung ke-5)</option>
                                    </select>
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
                                    <small class="text-danger" style="font-size: 0.7rem; font-weight: 500;">* Lihat
                                        angka paling atas di KTP Anda</small>
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
                                        class="form-control form-control-sm"
                                        placeholder="Contoh: Petani, PNS, Swasta">
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
                        <span class="badge badge-court me-2">III</span> Pihak II: Penerima Kuasa (Yang Hadir di
                        Pengadilan)
                    </h5>
                    <button type="button" wire:click="tambahPenerima"
                        class="btn btn-sm btn-outline-court fw-semibold rounded-pill px-3">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Penerima
                    </button>
                </div>
                <p class="text-muted small mb-3 fst-italic">
                    * Penerima Kuasa adalah pihak yang ditunjuk untuk mengurus dokumen ke Pengadilan Negeri Kaimana.
                </p>

                @foreach ($penerima_kuasa as $index => $penerima)
                    <div class="card bg-light border-0 mb-3 shadow-sm rounded-3"
                        wire:key="penerima-{{ $index }}">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <!-- MENYESUAIKAN KEY MENJADI urutan_ahli_waris DAN BISA DIINPUT MANUAL -->
                                <div class="d-flex align-items-center" style="max-width: 250px;">
                                    <span
                                        class="input-group-text bg-dark text-white border-0 small rounded-start-pill py-1 px-3"
                                        style="font-size: 0.8rem;">Status:</span>
                                    <select wire:model="penerima_kuasa.{{ $index }}.urutan_ahli_waris"
                                        class="form-select form-select-sm bg-white border-0 rounded-end-pill fw-bold text-dark @error('penerima_kuasa.' . $index . '.urutan_ahli_waris') is-invalid @enderror">
                                        <option value="">-- Pilih Status Silsilah --</option>

                                        <!-- Opsi untuk Pasangan yang Ditinggalkan -->
                                        <option value="Istri Pewaris">Istri Pewaris (Jika Suami Meninggal)</option>
                                        <option value="Suami Pewaris">Suami Pewaris (Jika Istri Meninggal)</option>

                                        <!-- Opsi Garis Keturunan Anak (Dari Tertua ke Muda) -->
                                        <option value="Ahli Waris I">Ahli Waris I (Anak Kandung ke-1)</option>
                                        <option value="Ahli Waris II">Ahli Waris II (Anak Kandung ke-2)</option>
                                        <option value="Ahli Waris III">Ahli Waris III (Anak Kandung ke-3)</option>
                                        <option value="Ahli Waris IV">Ahli Waris IV (Anak Kandung ke-4)</option>
                                        <option value="Ahli Waris V">Ahli Waris V (Anak Kandung ke-5)</option>
                                    </select>
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
                                    <small class="text-danger" style="font-size: 0.7rem; font-weight: 500;">* Lihat
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
                    <a href="{{ route('waarmeking.surat-kuasa.index') }}" wire:navigate
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
                    '<p class="text-center fw-semibold text-success mb-3">Permohonan Surat Kuasa Waarmeking Anda berhasil dikirim!</p>' +
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
