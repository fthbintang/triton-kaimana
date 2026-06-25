<div class="container-fluid py-4">

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 border-0 border-start border-success border-4"
            role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5 text-success"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (!$isCreating)
        <div class="card shadow-sm border-0 rounded-3">
            <div
                class="card-header bg-white py-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 border-bottom-0">
                <div class="d-flex align-items-start gap-3">
                    <a href="{{ route('portal') }}" wire:navigate
                        class="btn btn-outline-secondary btn-sm p-2 rounded-2 shadow-sm d-inline-flex align-items-center"
                        title="Kembali ke Portal">
                        <i class="bi bi-arrow-left fs-5 leading-none"></i>
                    </a>

                    <div>
                        <h4 class="card-title mb-1 fw-bold text-dark">
                            <i class="bi bi-folder-symlink me-2 text-primary"></i>Registrasi Waarmeking (Kaimana)
                        </h4>
                        <p class="text-muted small mb-0">Daftar berkas permohonan naskah hukum waarmeking yang tercatat
                            di dalam sistem TRITON</p>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 w-100 w-md-auto">
                    <div class="input-group shadow-sm" style="min-width: 260px;">
                        <span class="input-group-text bg-white border-end-0 text-muted py-2">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            class="form-control border-start-0 ps-0 text-sm py-2"
                            placeholder="Cari nama, NIK, atau HP...">
                    </div>

                    <a href="{{ route('waarmeking.create') }}" wire:navigate
                        class="btn btn-primary px-4 py-2 rounded-2 shadow-sm d-inline-flex align-items-center justify-content-center gap-2 fw-semibold text-nowrap">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>Tambah Permohonan Baru</span>
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary text-uppercase font-monospace"
                            style="font-size: 0.8rem; letter-spacing: 0.5px;">
                            <tr>
                                <th scope="col" class="ps-4 py-3">No</th>
                                <th scope="col" class="py-3">Pemohon / NIK</th>
                                <th scope="col" class="py-3">Nama Pewaris</th>
                                <th scope="col" class="py-3">Detail Spesifik</th>
                                <th scope="col" class="pe-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftar_waarmeking as $index => $item)
                                <tr>
                                    <td class="ps-4 text-muted fw-medium">
                                        {{ ($daftar_waarmeking->currentPage() - 1) * $daftar_waarmeking->perPage() + $index + 1 }}
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark mb-1">{{ $item->nama_pemohon }}</div>
                                        <div class="text-muted small mb-1"><i
                                                class="bi bi-card-id me-1"></i>{{ $item->nik_pemohon }}</div>
                                        <div class="text-muted small"><i
                                                class="bi bi-telephone me-1"></i>{{ $item->no_hp_pemohon }}</div>
                                    </td>
                                    <td class="fw-semibold text-secondary">
                                        {{ $item->data_spesifik['nama_pewaris'] ?? '-' }}</td>
                                    <td>
                                        <div class="p-2 bg-light rounded-2 border border-light-subtle"
                                            style="font-size: 0.85rem;">
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-1"><span class="text-muted">Pekerjaan:</span>
                                                    <strong>{{ $item->data_spesifik['pekerjaan'] ?? '-' }}</strong>
                                                </li>
                                                <li class="mb-1"><span class="text-muted">Rekening:</span> <span
                                                        class="badge bg-secondary-subtle text-secondary-emphasis">{{ isset($item->data_spesifik['daftar_rekening']) ? count($item->data_spesifik['daftar_rekening']) : 0 }}
                                                        Bank</span></li>
                                                <li><span class="text-muted">Ahli Waris:</span> <span
                                                        class="badge bg-info-subtle text-info-emphasis">{{ isset($item->data_spesifik['pemohon_tambahan']) ? count($item->data_spesifik['pemohon_tambahan']) : 0 }}
                                                        Jiwa</span></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <div class="d-inline-flex gap-1 align-items-center">
                                            <a href="{{ route('waarmeking.edit', ['id' => $item->id]) }}" wire:navigate
                                                class="btn btn-warning btn-sm px-2 rounded-2 shadow-sm text-white"
                                                title="Ubah Data">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <button type="button"
                                                onclick="konfirmasiHapus({{ $item->id }}, '{{ $item->nama_pemohon }}')"
                                                class="btn btn-danger btn-sm px-2 rounded-2 shadow-sm"
                                                title="Hapus Data">
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>

                                            <button type="button"
                                                class="btn btn-primary btn-sm px-2 rounded-2 shadow-sm d-inline-flex align-items-center gap-1"
                                                data-bs-toggle="modal" data-bs-target="#modalCetak{{ $item->id }}">
                                                <i class="bi bi-printer-fill"></i> Cetak
                                            </button>

                                            <div class="modal fade" id="modalCetak{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="labelModal{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                    <div class="modal-content border-0 shadow rounded-3">
                                                        <div class="modal-header bg-light border-bottom-0 py-3">
                                                            <h6 class="modal-title fw-bold text-dark"
                                                                id="labelModal{{ $item->id }}">
                                                                <i class="bi bi-download text-primary me-2"></i>Format
                                                                Unduhan
                                                            </h6>
                                                            <button type="button" class="btn-close"
                                                                data-bs-submit="modal" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body text-center p-4">
                                                            <p class="text-muted small mb-4">Silakan pilih format
                                                                dokumen hukum Waarmeking atas nama
                                                                <strong>{{ $item->nama_pemohon }}</strong> :
                                                            </p>

                                                            <div class="d-grid gap-2">
                                                                <a href="{{ route('cetak.waarmeking.pdf', ['id' => $item->id]) }}"
                                                                    target="_blank"
                                                                    class="btn btn-danger py-2.5 rounded-2 d-flex align-items-center justify-content-center gap-2 fw-semibold shadow-sm">
                                                                    <i class="bi bi-file-earmark-pdf-fill fs-5"></i>
                                                                    <span>Unduh Dokumen PDF</span>
                                                                </a>

                                                                <a href="{{ route('cetak.waarmeking.word', ['id' => $item->id]) }}"
                                                                    class="btn btn-primary py-2.5 rounded-2 d-flex align-items-center justify-content-center gap-2 fw-semibold shadow-sm">
                                                                    <i class="bi bi-file-earmark-word-fill fs-5"></i>
                                                                    <span>Unduh Dokumen Word</span>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="modal-footer bg-light border-top-0 justify-content-center py-2">
                                                            <button type="button"
                                                                class="btn btn-link text-decoration-none text-muted btn-sm"
                                                                data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <div class="mb-2 fs-1">📂</div>
                                        <h6 class="fw-semibold mb-1">Belum Ada Data</h6>
                                        <p class="small text-muted mb-0">Permohonan dokumen Waarmeking masih kosong.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Bagian Bawah Tabel untuk Navigasi Halaman -->
                    <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2 px-2">
                        <div class="text-muted small">
                            Menampilkan {{ $daftar_waarmeking->firstItem() ?? 0 }} sampai
                            {{ $daftar_waarmeking->lastItem() ?? 0 }} dari {{ $daftar_waarmeking->total() }} data
                            permohonan.
                        </div>
                        <div>
                            <!-- Link Tombol Angka Pagination Otomatis dari Livewire -->
                            {{ $daftar_waarmeking->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-sm border-0 rounded-3">
            @include('livewire.form-waarmeking.permohonan.create')
        </div>
    @endif

</div>

<script>
    function konfirmasiHapus(id, nama) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data permohonan atas nama " + nama + " akan dihapus permanen dari sistem TRITON!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545', // Warna merah untuk aksi hapus (danger)
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
