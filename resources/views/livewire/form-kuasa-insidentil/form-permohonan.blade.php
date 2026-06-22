<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-court text-white p-4 text-center rounded-top-3">
                    <h5 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">
                        Formulir Surat Permohonan Kuasa Insidentil
                    </h5>
                    <p class="text-white-50 small m-0 mt-1">
                        Isilah data di bawah ini secara lengkap dan benar sesuai dengan dokumen asli KTP
                    </p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form wire:submit="simpan">

                        <div class="mb-5">
                            <h5 class="text-court fw-bold border-bottom pb-2 mb-3">
                                <span class="badge badge-court me-2">I</span> Data Penerima Kuasa (Pemohon yang Datang)
                            </h5>
                            <p class="text-muted small fst-italic">* Isi dengan data diri Anda selaku orang yang
                                menerima kuasa untuk menghadiri sidang.</p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small mb-1">Nama Lengkap Penerima
                                        Kuasa</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('nama_pemohon') is-invalid @enderror"
                                        wire:model="nama_pemohon" placeholder="Sesuai KTP">
                                    @error('nama_pemohon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small mb-1">NIK (16 Digit
                                        KTP)</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('nik_pemohon') is-invalid @enderror"
                                        wire:model="nik_pemohon" placeholder="Contoh: 9102..." maxlength="16">
                                    @error('nik_pemohon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Jenis Kelamin</label>
                                    <select wire:model="jenis_kelamin_penerima"
                                        class="form-select form-select-sm @error('jenis_kelamin_penerima') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin_penerima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Agama</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('agama_penerima') is-invalid @enderror"
                                        wire:model="agama_penerima" placeholder="Contoh: Islam, Kristen">
                                    @error('agama_penerima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Pekerjaan</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('pekerjaan_penerima') is-invalid @enderror"
                                        wire:model="pekerjaan_penerima" placeholder="Contoh: PNS, Swasta">
                                    @error('pekerjaan_penerima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold text-muted small mb-1">Nomor HP / WhatsApp
                                        Aktif</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('no_hp_pemohon') is-invalid @enderror"
                                        wire:model="no_hp_pemohon" placeholder="Contoh: 081234xxxxxx">
                                    @error('no_hp_pemohon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Alamat Lengkap Penerima
                                        Kuasa</label>
                                    <textarea wire:model="alamat_penerima"
                                        class="form-control form-control-sm @error('alamat_penerima') is-invalid @enderror" rows="2"
                                        placeholder="Sesuai KTP..."></textarea>
                                    @error('alamat_penerima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h5 class="text-court fw-bold border-bottom pb-2 mb-3">
                                <span class="badge badge-court me-2">II</span> Data Pemberi Kuasa
                            </h5>
                            <p class="text-muted small fst-italic">* Isi dengan data keluarga yang memberikan kuasa
                                kepada Anda karena halangan hadir.</p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small mb-1">Nama Lengkap Pemberi
                                        Kuasa</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('nama_pemberi') is-invalid @enderror"
                                        wire:model="nama_pemberi" placeholder="Sesuai KTP">
                                    @error('nama_pemberi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small mb-1">NIK (16 Digit
                                        KTP)</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('nik_pemberi') is-invalid @enderror"
                                        wire:model="nik_pemberi" placeholder="Contoh: 9102..." maxlength="16">
                                    @error('nik_pemberi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Jenis Kelamin</label>
                                    <select wire:model="jenis_kelamin_pemberi"
                                        class="form-select form-select-sm @error('jenis_kelamin_pemberi') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin_pemberi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Agama</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('agama_pemberi') is-invalid @enderror"
                                        wire:model="agama_pemberi" placeholder="Contoh: Islam, Kristen">
                                    @error('agama_pemberi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-muted small mb-1 fw-semibold">Alamat Lengkap Pemberi
                                        Kuasa</label>
                                    <textarea wire:model="alamat_pemberi"
                                        class="form-control form-control-sm @error('alamat_pemberi') is-invalid @enderror" rows="2"
                                        placeholder="Sesuai KTP..."></textarea>
                                    @error('alamat_pemberi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h5 class="text-court fw-bold border-bottom pb-2 mb-3">
                                <span class="badge badge-court me-2">III</span> Hubungan Keluarga & Objek Perkara
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small mb-1">Hubungan
                                        Keluarga</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('hubungan_keluarga') is-invalid @enderror"
                                        wire:model="hubungan_keluarga"
                                        placeholder="Contoh: Suami, Istri, Ayah, Ibu, Saudara Kandung dll">
                                    @error('hubungan_keluarga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small mb-1">Perkara Permohonan Yang
                                        Diajukan</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('perkara_permohonan') is-invalid @enderror"
                                        wire:model="perkara_permohonan" placeholder="Contoh: Permohonan Ganti Nama">
                                    @error('perkara_permohonan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-2 mt-4 pt-3 border-top">
                            <div class="col-6 col-md-3">
                                <a href="{{ route('portal') }}" wire:navigate
                                    class="btn btn-light border text-secondary w-100 py-2 fw-semibold rounded-3 shadow-sm">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                            </div>
                            <div class="col-md-6 d-none d-md-block"></div>
                            <div class="col-6 col-md-3">
                                <button type="submit" class="btn btn-court w-100 py-2 fw-bold rounded-3 shadow-sm">
                                    <span wire:loading.remove>Kirim Form <i
                                            class="bi bi-send-fill ms-1 small"></i></span>
                                    <span wire:loading>Memproses...</span>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('permohonan-sukses', (event) => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Permohonan Kuasa Insidentil atas nama ' + event.nama +
                    ' berhasil dikirim.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.navigate('{{ route('portal') }}');
                }
            });
        });
    });
</script>
