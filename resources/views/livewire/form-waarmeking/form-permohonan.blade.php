<div class="card shadow-sm border-0 rounded-3">
    <!-- HEADER UTAMA FORM -->
    <div class="card-header bg-court text-white p-4 text-center rounded-top-3">
        <h5 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">
            Formulir Surat Permohonan Waarmeking
        </h5>
        <p class="text-white-50 small m-0 mt-1">
            Isilah data di bawah ini secara lengkap dan benar sesuai dengan dokumen asli
        </p>
    </div>

    <div class="card-body p-4 p-md-5">

        <!-- KOTAK ALUR PETUNJUK MASYARAKAT (PENJELASAN WAARMEKING) -->
        <div class="alert alert-success border-0 bg-success bg-opacity-10 rounded-3 mb-5 p-3 shadow-sm">
            <h6 class="fw-bold text-court mb-2">
                <i class="bi bi-info-circle-fill me-2"></i> Apa itu Waarmeking & Bagaimana Prosesnya?
            </h6>
            <p class="small text-muted mb-3">
                <strong>Waarmeking</strong> adalah proses pendaftaran/pengesahan surat kesepakatan ahli waris di
                Pengadilan Negeri, biasanya digunakan sebagai syarat utama untuk <strong>mencairkan saldo tabungan
                    bank</strong> milik keluarga yang sudah meninggal dunia.
            </p>
            <div class="row g-3 small text-muted border-top pt-2">
                <div class="col-md-4">
                    <span class="badge badge-court rounded-pill me-1">1</span> <strong>Isi Form:</strong> Masukkan data
                    Anda, data almarhum, dan nomor rekening bank secara teliti.
                </div>
                <div class="col-md-4">
                    <span class="badge badge-court rounded-pill me-1">2</span> <strong>Kirim:</strong> Periksa kembali
                    saldo angka, lalu klik tombol kirim di bawah.
                </div>
                <div class="col-md-4">
                    <span class="badge badge-court rounded-pill me-1">3</span> <strong>Ke Pengadilan:</strong> Bawa KTP
                    Anda & Buku Tabungan asli almarhum ke Meja PTSP Hukum PN Kaimana.
                </div>
            </div>
        </div>

        <form wire:submit.prevent="simpan">

            <!-- BAGIAN I: DATA UTAMA PEMOHON -->
            <div class="mb-5">
                <h5 class="text-court fw-bold border-bottom pb-2 mb-3">
                    <span class="badge badge-court me-2">I</span> Data Utama Pemohon
                </h5>
                <p class="text-muted small mb-3 fst-italic">* Pemohon adalah perwakilan ahli waris/keluarga yang mengisi
                    form ini dan yang akan datang ke pengadilan.</p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small mb-1">Nama Lengkap Pemohon</label>
                        <input type="text" wire:model="nama_pemohon"
                            class="form-control @error('nama_pemohon') is-invalid @enderror" placeholder="Sesuai KTP">
                        @error('nama_pemohon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small mb-1">NIK (16 Digit KTP)</label>
                        <input type="text" wire:model="nik_pemohon" maxlength="16"
                            class="form-control @error('nik_pemohon') is-invalid @enderror"
                            placeholder="16 Digit Nomor Induk Kependudukan">
                        <small class="text-danger d-block mt-1" style="font-size: 0.7rem; font-weight: 500;">* Lihat
                            angka paling atas di KTP Anda</small>
                        @error('nik_pemohon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small mb-1">No. HP / WhatsApp (Aktif)</label>
                        <input type="text" wire:model="no_hp_pemohon"
                            class="form-control @error('no_hp_pemohon') is-invalid @enderror"
                            placeholder="Contoh: 081234xxxxxx">
                        <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">* Pastikan nomor aktif agar
                            petugas bisa menghubungi Anda jika ada data yang keliru.</small>
                        @error('no_hp_pemohon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- BAGIAN II: DATA DETAIL PEMOHON & PEWARIS -->
            <div class="mb-5">
                <h5 class="text-court fw-bold border-bottom pb-2 mb-3">
                    <span class="badge badge-court me-2">II</span> Data Detail Pemohon & Pewaris
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small mb-1">Tempat Lahir Pemohon</label>
                        <input type="text" wire:model="tempat_lahir"
                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                            placeholder="Kota/Kabupaten tempat Anda lahir">
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small mb-1">Tanggal Lahir Pemohon</label>
                        <input type="date" wire:model="tanggal_lahir"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror">
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small mb-1">Jenis Kelamin</label>
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
                        <label class="form-label fw-semibold text-muted small mb-1">Agama</label>
                        <input type="text" wire:model="agama"
                            class="form-control @error('agama') is-invalid @enderror"
                            placeholder="Contoh: Kristen, Islam, Katolik">
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small mb-1">Pekerjaan</label>
                        <input type="text" wire:model="pekerjaan"
                            class="form-control @error('pekerjaan') is-invalid @enderror"
                            placeholder="Pekerjaan Anda sekarang">
                        @error('pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small mb-1">Nama Pewaris (Keluarga yang
                            Meninggal)</label>
                        <input type="text" wire:model="nama_pewaris" placeholder="Contoh: Alm. John Doe"
                            class="form-control @error('nama_pewaris') is-invalid @enderror">
                        <small class="text-danger d-block mt-1" style="font-size: 0.7rem; font-weight: 500;">* Tuliskan
                            nama lengkap almarhum/almarhumah</small>
                        @error('nama_pewaris')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold text-muted small mb-1">Alamat Lengkap Pemohon (Sesuai
                            KTP/Domisili)</label>
                        <textarea wire:model="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror"
                            placeholder="Tuliskan nama jalan, RT/RW, kampung/kelurahan, dan kecamatan tempat tinggal saat ini..."></textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- BAGIAN III: INFORMASI REKENING BANK PEWARIS -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <h5 class="text-court fw-bold m-0">
                        <span class="badge badge-court me-2">III</span> Informasi Rekening Bank Pewaris
                    </h5>
                    <button type="button" wire:click="tambahBank"
                        class="btn btn-sm btn-outline-court fw-semibold rounded-pill px-3">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Bank
                    </button>
                </div>
                <p class="text-muted small mb-3 fst-italic">* Masukkan data rekening milik Almarhum/ah secara teliti
                    sesuai yang tertera di Buku Tabungan asli.</p>

                @foreach ($daftar_rekening as $index => $rekening)
                    <div class="card bg-light border-0 mb-3 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-secondary rounded-pill px-3">Data Bank
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
                                    <label class="form-label text-muted small mb-1 fw-semibold">Nama Bank</label>
                                    <input type="text" wire:model="daftar_rekening.{{ $index }}.nama_bank"
                                        placeholder="Misal: Bank BRI, Bank Papua"
                                        class="form-control form-control-sm @error('daftar_rekening.' . $index . '.nama_bank') is-invalid @enderror">
                                    @error('daftar_rekening.' . $index . '.nama_bank')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Cabang Kantor
                                        Bank</label>
                                    <input type="text"
                                        wire:model="daftar_rekening.{{ $index }}.cabang_bank"
                                        placeholder="Misal: KC Kaimana"
                                        class="form-control form-control-sm @error('daftar_rekening.' . $index . '.cabang_bank') is-invalid @enderror">
                                    @error('daftar_rekening.' . $index . '.cabang_bank')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Nomor Rekening</label>
                                    <input type="text"
                                        wire:model="daftar_rekening.{{ $index }}.nomor_rekening"
                                        placeholder="Masukkan nomor rekening almarhum"
                                        class="form-control form-control-sm @error('daftar_rekening.' . $index . '.nomor_rekening') is-invalid @enderror">
                                    @error('daftar_rekening.' . $index . '.nomor_rekening')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Nominal Tabungan
                                        (Angka)
                                    </label>
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
                                    <label class="form-label text-muted small mb-1 fw-semibold">Terbilang Huruf
                                        (Otomatis)</label>
                                    <input type="text"
                                        wire:model="daftar_rekening.{{ $index }}.nominal_huruf" readonly
                                        class="form-control form-control-sm bg-white text-muted fst-italic fw-semibold border-light-subtle">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
                    <button type="submit" class="btn btn-court w-100 py-2 fw-bold rounded-3 shadow-sm">
                        Kirim Form <i class="bi bi-send-fill ms-1 small"></i>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<!-- SCRIPT LISTENER SWEETALERT2 -->
{{-- <script>
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
</script> --}}

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('permohonan-sukses', (event) => {
            // Ambil data event dengan aman untuk Livewire v3
            // Biasanya data dikirim dalam bentuk array pada indeks pertama, atau objek langsung
            let eventData = Array.isArray(event) ? event[0] : event;
            let namaPemohon = eventData.nama || (eventData.detail && eventData.detail.nama) ||
                'Pemohon';

            Swal.fire({
                title: "Pendaftaran Berhasil!",
                html: '<div class="text-start small">' +
                    '<p class="text-center fw-semibold text-success mb-3">Permohonan Waarmeking Anda berhasil dikirim ke sistem TRITON!</p>' +
                    '<hr>' +
                    '<ol class="ps-3 mb-0 text-muted">' +
                    '<li class="mb-2">Silakan kembali ke <strong>Meja PTSP Hukum</strong> untuk dibantu petugas mencetak Surat Permohonan Anda.</li>' +
                    '<li>Sampaikan kepada petugas bahwa permohonan diajukan atas nama: <br>' +
                    '<span class="badge bg-court text-white mt-1 px-3 py-2 fs-6 w-100 text-truncate">' +
                    '<i class="bi bi-person-fill me-1"></i> ' + namaPemohon +
                    '</span>' +
                    '</li>' +
                    '</ol>' +
                    '</div>',
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
