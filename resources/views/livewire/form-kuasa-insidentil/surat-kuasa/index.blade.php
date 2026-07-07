<div>
    @if ($isCreating)
        @include('livewire.form-kuasa-insidentil.surat-kuasa.create')
    @else
        <div class="container-fluid py-4">
            <div class="card border-0 shadow-sm rounded-3">

                <div
                    class="card-header bg-white py-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 border-bottom-0">
                    <div class="d-flex align-items-start gap-3">
                        <a href="{{ route('portal') }}" wire:navigate
                            class="btn btn-outline-secondary btn-sm p-2 rounded-2 shadow-sm d-inline-flex align-items-center"
                            title="Kembali ke Portal">
                            <i class="bi bi-arrow-left fs-5 leading-none"></i>
                        </a>
                        <div>
                            <h4 class="card-title mb-1 fw-bold text-dark">
                                <i class="bi bi-file-earmark-text-fill me-2 text-primary"></i>Surat Kuasa Insidentil
                            </h4>
                            <p class="text-muted small mb-0">Manajemen delegasi berkas kuasa insidentil di lingkup
                                Pengadilan Negeri Kaimana</p>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-2 w-100 ms-md-auto" style="max-width: 300px;">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0 text-muted py-2">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="form-control border-start-0 ps-0 text-sm py-2"
                                placeholder="Cari nama atau NIK...">
                        </div>

                        <a href="{{ route('kuasa-insidentil.surat-kuasa.create') }}" wire:navigate
                            class="btn btn-primary py-2 rounded-2 shadow-sm d-inline-flex align-items-center justify-content-center gap-2 fw-semibold">
                            <i class="bi bi-plus-circle-fill"></i>
                            <span>Buat Surat Kuasa Baru</span>
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if (session()->has('success'))
                        <div class="alert alert-success mx-4 border-0 rounded-3 shadow-sm d-flex align-items-center gap-2"
                            role="alert">
                            <i class="bi bi-check-circle-fill fs-5"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-sm">
                            <thead class="table-light text-secondary text-uppercase"
                                style="font-size: 11px; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="ps-4 py-3" style="width: 70px;">No</th>
                                    <th class="py-3">Pemberi Kuasa</th>
                                    <th class="py-3">Penerima Kuasa</th>
                                    <th class="py-3">No. HP Pemohon</th>
                                    <th class="pe-4 py-3 text-center" style="width: 250px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($daftar_surat_kuasa as $index => $item)
                                    <tr>
                                        <td class="ps-4 text-muted fw-medium">
                                            {{ ($daftar_surat_kuasa->currentPage() - 1) * $daftar_surat_kuasa->perPage() + $index + 1 }}
                                        </td>

                                        <td>
                                            <div class="fw-semibold text-dark">
                                                {{ $item->pemberiKuasa->first()?->nama ?? '-' }}</div>
                                            @if ($item->pemberiKuasa->count() > 1)
                                                <span class="badge bg-secondary-subtle text-secondary-emphasis mt-1">
                                                    +{{ $item->pemberiKuasa->count() - 1 }} Jiwa Anggota Keluarga
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="fw-semibold text-dark">
                                                @if ($item->penerimaKuasa->count() > 1)
                                                    {{ $item->penerimaKuasa->first()?->nama }} <span
                                                        class="badge bg-secondary style="font-size:
                                                        10px;">+{{ $item->penerimaKuasa->count() - 1 }} Orang</span>
                                                @else
                                                    {{ $item->penerimaKuasa->first()?->nama ?? '-' }}
                                                @endif
                                            </div>

                                            <small class="text-muted d-block" style="font-size: 11px;">
                                                Kapasitas:
                                                @if ($item->penerimaKuasa->count() > 1)
                                                    Beberapa Penerima Kuasa
                                                @else
                                                    {{ $item->penerimaKuasa->first()?->status_penerima ?? '-' }}
                                                @endif
                                            </small>
                                        </td>

                                        <td>
                                            <span class="text-dark"><i
                                                    class="bi bi-whatsapp text-success me-1"></i>{{ $item->no_hp_pemohon }}</span>
                                        </td>

                                        <td class="pe-4 text-center">
                                            <div class="d-inline-flex gap-1 align-items-center">
                                                <a href="{{ route('kuasa-insidentil.surat-kuasa.edit', ['id' => $item->id]) }}"
                                                    wire:navigate
                                                    class="btn btn-warning btn-sm px-2 rounded-2 shadow-sm text-white"
                                                    title="Ubah Data">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>

                                                <button type="button"
                                                    onclick="konfirmasiHapus({{ $item->id }}, '{{ $item->pemberiKuasa->first()?->nama ?? 'Tidak Diketahui' }}')"
                                                    class="btn btn-outline-danger btn-sm px-2 rounded-2 shadow-sm"
                                                    title="Hapus Data">
                                                    <i class="bi bi-trash-fill"></i> Hapus
                                                </button>

                                                <button type="button"
                                                    class="btn btn-primary btn-sm px-2 rounded-2 shadow-sm d-inline-flex align-items-center gap-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalCetakKuasa{{ $item->id }}">
                                                    <i class="bi bi-printer-fill"></i> Cetak
                                                </button>

                                                <div class="modal fade" id="modalCetakKuasa{{ $item->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                                        <div class="modal-content border-0 shadow rounded-3 text-start">
                                                            <div class="modal-header bg-light border-bottom-0 py-3">
                                                                <h6 class="modal-title fw-bold text-dark"><i
                                                                        class="bi bi-download text-primary me-2"></i>Format
                                                                    Berkas</h6>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center p-4">
                                                                <p class="text-muted small mb-4">Pilih format unduhan
                                                                    dokumen surat kuasa:</p>
                                                                <div class="d-grid gap-2">
                                                                    <a href="{{ route('cetak.surat-kuasa.kuasa-insidentil.pdf', ['id' => $item->id]) }}"
                                                                        target="_blank"
                                                                        class="btn btn-danger py-2 rounded-2 d-flex align-items-center justify-content-center gap-2 fw-semibold shadow-sm">
                                                                        <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                                                                        Format
                                                                    </a>

                                                                    <a href="{{ route('cetak.surat-kuasa.kuasa-insidentil.word', ['id' => $item->id]) }}"
                                                                        class="btn btn-primary py-2 rounded-2 d-flex align-items-center justify-content-center gap-2 fw-semibold shadow-sm">
                                                                        <i class="bi bi-file-earmark-word-fill"></i>
                                                                        Word Format
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-folder-x fs-2 d-block mb-2"></i> Tidak ada berkas surat
                                            kuasa ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div
                    class="card-footer bg-white border-top-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2 px-4">
                    <div class="text-muted small">
                        Menampilkan {{ $daftar_surat_kuasa->firstItem() ?? 0 }} -
                        {{ $daftar_surat_kuasa->lastItem() ?? 0 }} dari {{ $daftar_surat_kuasa->total() }} berkas.
                    </div>
                    <div>{{ $daftar_surat_kuasa->links() }}</div>
                </div>

            </div>
        </div>
    @endif
</div>

<script>
    function konfirmasiHapus(id, nama) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data berkas Surat Kuasa atas nama " + nama + " akan dihapus permanen dari sistem TRITON!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545', // Warna merah (danger)
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-trash"></i> Ya, Hapus Data!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Panggil fungsi destroy() yang ada di dalam class Livewire PHP
                @this.call('destroy', id);
            }
        });
    }
</script>
