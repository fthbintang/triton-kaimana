<div class="card shadow-sm border-0 rounded-3">
    <!-- HEADER UTAMA FORM -->
    <div class="card-header bg-court text-white p-4 text-center rounded-top-3 position-relative">

        <a href="{{ route('waarmeking.index') }}" wire:navigate
            class="btn btn-sm btn-outline-light position-absolute start-0 top-50 translate-middle-y ms-3 rounded-2 shadow-sm d-inline-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i>
            <span class="d-none d-md-inline">Kembali</span>
        </a>

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
                <i class="bi bi-info-circle-fill me-2"></i> Apa itu Waarmeking?
            </h6>
            <p class="small text-muted mb-1">
                <strong>Waarmeking</strong> adalah proses pendaftaran/pengesahan surat kesepakatan ahli waris di
                Pengadilan Negeri, biasanya digunakan sebagai syarat utama untuk <strong>mencairkan saldo tabungan
                    bank</strong> milik keluarga yang sudah meninggal dunia.
            </p>
        </div>

        <form wire:submit.prevent="save">

            <div class="col-md-12 mb-4">
                <label class="form-label fw-semibold text-muted small mb-1">Tujuan Permohonan Surat
                    (Kepada Yth.)</label>
                <select wire:model="tujuan_pimpinan"
                    class="form-select form-select-sm @error('tujuan_pimpinan') is-invalid @enderror">
                    <option value="Ketua">Ketua Pengadilan Negeri Kaimana</option>
                    <option value="Wakil Ketua">Wakil Ketua Pengadilan Negeri Kaimana</option>
                    <option value="Plh. Ketua">Plh. Ketua Pengadilan Negeri Kaimana</option>
                    <option value="Plt. Ketua">Plt. Ketua Pengadilan Negeri Kaimana</option>
                </select>
                @error('tujuan_pimpinan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- BAGIAN I: DATA AHLI WARIS / PEMOHON -->
            <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h5 class="text-court fw-bold mb-0">
                        <span class="badge badge-court me-2">I</span> Data Ahli Waris (Pemohon)
                    </h5>
                    <button type="button" wire:click="tambahPemohon"
                        class="btn btn-sm btn-outline-success fw-semibold rounded-pill px-3">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Ahli Waris
                    </button>
                </div>
                <div class="alert alert-warning border-0 shadow-sm rounded-3 mb-3 p-3">
                    <p class="text-muted small mb-2 fst-italic">
                        * Isi data Pemohon Utama (Perwakilan). Jika ada anggota ahli waris lain yang <strong
                            class="text-court">juga ikut datang langsung ke Pengadilan Negeri Kaimana</strong>, silakan
                        klik tombol <strong>+ Tambah Ahli Waris</strong> di bawah agar nama mereka tercantum di surat
                        permohonan.
                    </p>
                    <p class="text-muted small mb-2 fst-italic">
                        * <strong class="text-danger">PENTING:</strong> Seluruh nama ahli waris yang dimasukkan ke dalam
                        form ini <strong class="text-danger">WAJIB HADIR FISIK</strong> ke Pengadilan Negeri Kaimana
                        untuk tanda tangan di depan petugas. Jika ada ahli waris yang tidak bisa ikut datang, maka ia
                        <strong class="text-danger">wajib membuat Surat Kuasa</strong> terlebih dahulu untuk diserahkan
                        ke Bagian Hukum.
                    </p>
                    <div class="d-flex align-items-center gap-2 mt-2 pt-2 border-top border-warning-subtle">
                        <i class="bi bi-file-earmark-text-fill text-warning" style="font-size: 1.1rem;"></i>
                        <span class="small fw-medium text-dark">Ada ahli waris yang tidak bisa ikut hadir ke
                            Pengadilan?</span>
                        <a href="{{ route('waarmeking.surat-kuasa.create') }}" target="_blank"
                            class="btn btn-xs btn-primary py-0 px-2 fw-semibold text-decoration-none rounded"
                            style="font-size: 0.75rem;">
                            Isi Form Surat Kuasa Di Sini <i class="bi bi-box-arrow-up-right ms-1"
                                style="font-size: 0.65rem;"></i>
                        </a>
                    </div>
                </div>

                <div class="card bg-white border-light shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-court text-white py-2 small fw-semibold">
                        Ahli Waris Utama / Perwakilan
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mb-1">Nama Lengkap Pemohon</label>
                            <input type="text" wire:model="nama_pemohon"
                                class="form-control form-control-sm @error('nama_pemohon') is-invalid @enderror"
                                placeholder="Sesuai KTP">
                            @error('nama_pemohon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mb-1">NIK (16 Digit KTP)</label>
                            <input type="text" wire:model="nik_pemohon" maxlength="16"
                                class="form-control form-control-sm @error('nik_pemohon') is-invalid @enderror"
                                placeholder="16 Digit NIK KTP">
                            @error('nik_pemohon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mb-1">Hubungan Silsilah Ahli
                                Waris</label>
                            <select wire:model="urutan_ahli_waris"
                                class="form-select form-select-sm @error('urutan_ahli_waris') is-invalid @enderror">
                                <option value="">-- Pilih Status Silsilah --</option>
                                <option value="Istri Pewaris">Istri Pewaris (Jika Suami Meninggal)</option>
                                <option value="Suami Pewaris">Suami Pewaris (Jika Istri Meninggal)</option>

                                <option value="Ahli Waris I">Ahli Waris I (Anak Kandung ke-1)</option>
                                <option value="Ahli Waris II">Ahli Waris II (Anak Kandung ke-2)</option>
                                <option value="Ahli Waris III">Ahli Waris III (Anak Kandung ke-3)</option>
                                <option value="Ahli Waris IV">Ahli Waris IV (Anak Kandung ke-4)</option>
                                <option value="Ahli Waris V">Ahli Waris V (Anak Kandung ke-5)</option>
                            </select>
                            @error('urutan_ahli_waris')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mb-1">No. HP / WhatsApp
                                (Aktif)</label>
                            <input type="text" wire:model="no_hp_pemohon"
                                class="form-control form-control-sm @error('no_hp_pemohon') is-invalid @enderror"
                                placeholder="Contoh: 081234xxxxxx">
                            @error('no_hp_pemohon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small mb-1">Tempat Lahir</label>
                            <input type="text" wire:model="tempat_lahir"
                                class="form-control form-control-sm @error('tempat_lahir') is-invalid @enderror"
                                placeholder="Kota/Kabupaten">
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

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted small mb-1">Agama</label>
                            <input type="text" wire:model="agama"
                                class="form-control form-control-sm @error('agama') is-invalid @enderror"
                                placeholder="Contoh: Islam">
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted small mb-1">Pekerjaan</label>
                            <input type="text" wire:model="pekerjaan"
                                class="form-control form-control-sm @error('pekerjaan') is-invalid @enderror"
                                placeholder="Pekerjaan">
                            @error('pekerjaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted small mb-1">Alamat Lengkap (Sesuai
                                KTP/Domisili)</label>
                            <textarea wire:model="alamat" rows="2"
                                class="form-control form-control-sm @error('alamat') is-invalid @enderror"
                                placeholder="Jalan, RT/RW, Kampung/Kelurahan, Kecamatan..."></textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @foreach ($pemohon_tambahan as $index => $item)
                    <div class="card bg-light border-0 mb-3 shadow-sm rounded-3 text-dark"
                        wire:key="pemohon-tambahan-{{ $index }}">
                        <div
                            class="card-header bg-secondary text-white d-flex justify-content-between align-items-center py-2">
                            <span class="fw-semibold small">Ahli Waris Tambahan #{{ $index + 1 }}</span>
                            <button type="button" wire:click="hapusPemohon({{ $index }})"
                                class="btn btn-sm btn-link text-white text-decoration-none p-0 small"
                                style="font-size: 0.8rem;">
                                <i class="bi bi-trash3-fill me-1"></i> Hapus
                            </button>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1 fw-semibold">Nama Lengkap</label>
                                <input type="text" wire:model="pemohon_tambahan.{{ $index }}.nama"
                                    placeholder="Sesuai KTP"
                                    class="form-control form-control-sm @error('pemohon_tambahan.' . $index . '.nama') is-invalid @enderror">
                                @error('pemohon_tambahan.' . $index . '.nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1 fw-semibold">NIK KTP</label>
                                <input type="text" wire:model="pemohon_tambahan.{{ $index }}.nik"
                                    maxlength="16" placeholder="16 Digit Angka"
                                    class="form-control form-control-sm @error('pemohon_tambahan.' . $index . '.nik') is-invalid @enderror">
                                @error('pemohon_tambahan.' . $index . '.nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label text-muted small mb-1 fw-semibold">Hubungan Silsilah Ahli
                                    Waris</label>
                                <select wire:model="pemohon_tambahan.{{ $index }}.urutan_ahli_waris"
                                    class="form-select form-select-sm @error('pemohon_tambahan.' . $index . '.urutan_ahli_waris') is-invalid @enderror">
                                    <option value="">-- Pilih Status Silsilah --</option>
                                    <option value="Istri Pewaris">Istri Pewaris (Jika Suami Meninggal)</option>
                                    <option value="Suami Pewaris">Suami Pewaris (Jika Istri Meninggal)</option>

                                    <option value="Ahli Waris I">Ahli Waris I (Anak Kandung ke-1)</option>
                                    <option value="Ahli Waris II">Ahli Waris II (Anak Kandung ke-2)</option>
                                    <option value="Ahli Waris III">Ahli Waris III (Anak Kandung ke-3)</option>
                                    <option value="Ahli Waris IV">Ahli Waris IV (Anak Kandung ke-4)</option>
                                    <option value="Ahli Waris V">Ahli Waris V (Anak Kandung ke-5)</option>
                                </select>
                                @error('pemohon_tambahan.' . $index . '.urutan_ahli_waris')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label text-muted small mb-1 fw-semibold">Tempat Lahir</label>
                                <input type="text" wire:model="pemohon_tambahan.{{ $index }}.tempat_lahir"
                                    placeholder="Kabupaten/Kota"
                                    class="form-control form-control-sm @error('pemohon_tambahan.' . $index . '.tempat_lahir') is-invalid @enderror">
                                @error('pemohon_tambahan.' . $index . '.tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label text-muted small mb-1 fw-semibold">Tanggal Lahir</label>
                                <input type="date" wire:model="pemohon_tambahan.{{ $index }}.tanggal_lahir"
                                    class="form-control form-control-sm @error('pemohon_tambahan.' . $index . '.tanggal_lahir') is-invalid @enderror">
                                @error('pemohon_tambahan.' . $index . '.tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-muted small mb-1 fw-semibold">Jenis Kelamin</label>
                                <select wire:model="pemohon_tambahan.{{ $index }}.jenis_kelamin"
                                    class="form-select form-select-sm @error('pemohon_tambahan.' . $index . '.jenis_kelamin') is-invalid @enderror">
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                @error('pemohon_tambahan.' . $index . '.jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-muted small mb-1 fw-semibold">Agama</label>
                                <input type="text" wire:model="pemohon_tambahan.{{ $index }}.agama"
                                    placeholder="Contoh: Islam"
                                    class="form-control form-control-sm @error('pemohon_tambahan.' . $index . '.agama') is-invalid @enderror">
                                @error('pemohon_tambahan.' . $index . '.agama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-muted small mb-1 fw-semibold">Pekerjaan</label>
                                <input type="text" wire:model="pemohon_tambahan.{{ $index }}.pekerjaan"
                                    placeholder="Pekerjaan"
                                    class="form-control form-control-sm @error('pemohon_tambahan.' . $index . '.pekerjaan') is-invalid @enderror">
                                @error('pemohon_tambahan.' . $index . '.pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label text-muted small mb-1 fw-semibold">Alamat Rumah
                                    Lengkap</label>
                                <textarea wire:model="pemohon_tambahan.{{ $index }}.alamat" rows="2"
                                    placeholder="Jalan, Kelurahan, Kecamatan"
                                    class="form-control form-control-sm @error('pemohon_tambahan.' . $index . '.alamat') is-invalid @enderror"></textarea>
                                @error('pemohon_tambahan.' . $index . '.alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- BAGIAN II: DATA PEWARIS (YANG MENINGGAL DUNIA) -->
            <div class="mb-5">
                <h5 class="text-court fw-bold border-bottom pb-2 mb-3">
                    <span class="badge badge-court me-2">II</span> Data Pewaris (Almarhum/ah)
                </h5>
                <p class="text-muted small mb-3 fst-italic">* Masukkan nama lengkap keluarga yang telah meninggal dunia
                    selaku pemilik rekening asal.</p>

                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold text-muted small mb-1">Nama Pewaris (Keluarga yang
                            Meninggal)</label>
                        <input type="text" wire:model="nama_pewaris" placeholder="Contoh: Almarhum Budi Santoso"
                            class="form-control @error('nama_pewaris') is-invalid @enderror">
                        <small class="text-danger d-block mt-1" style="font-size: 0.7rem; font-weight: 500;">*
                            Tuliskan nama lengkap almarhum/almarhumah beserta gelar (jika ada)</small>
                        @error('nama_pewaris')
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
                    <a href="{{ route('waarmeking.index') }}" wire:navigate
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
@if (session()->has('cetak_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Pendaftaran Berhasil!',
                text: 'Data permohonan atas nama {{ session('cetak_nama') }} telah disimpan. Apakah Anda ingin langsung mencetak dokumen?',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#1e4620',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-printer"></i> Cetak PDF Sekarang',
                cancelButtonText: 'Nanti Saja'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Membuka tab baru untuk cetak PDF stream berdasarkan ID yang disimpan
                    window.open('?id={{ session('cetak_id') }}', '_blank');
                }
            });
        });
    </script>
@endif
