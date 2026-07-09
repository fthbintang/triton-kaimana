<div class="container-fluid py-4">

    {{-- Alert Notifikasi Sukses --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center rounded-3 border-0 shadow-sm p-3 mb-4"
            role="alert">
            <i class="bi bi-check-circle-fill fs-5 me-2"></i>
            <div>
                <span class="fw-bold">Berhasil!</span> {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tampilan Utama Data/Table --}}
    @if (!$isCreating)
        <div class="card shadow-sm border-0 rounded-3">
            {{-- Card Header & Pencarian --}}
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
                            <i class="bi bi-file-earmark-person-fill me-2 text-primary"></i>Surat Pernyataan Tidak
                            Pernah Dihukum
                        </h4>
                        <p class="text-muted small mb-0">Daftar Surat Pernyataan Tidak Dihukum yang tercatat di sistem
                            TRITON</p>
                    </div>
                </div>

                <div class="d-flex flex-column gap-2 w-100 ms-md-auto" style="max-width: 300px;">
                    <a href="{{ route('tidak-dipidana.surat-pernyataan-tidak-dihukum.create') }}" wire:navigate
                        class="btn btn-primary py-2 rounded-2 shadow-sm d-inline-flex align-items-center justify-content-center gap-2 fw-semibold text-decoration-none">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>Tambah Surat pernyataan Baru</span>
                    </a>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted py-2">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            class="form-control border-start-0 ps-0 text-sm py-2" placeholder="Cari nama pemohon...">
                    </div>
                </div>
            </div>

            {{-- Table Data --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary text-uppercase font-monospace"
                            style="font-size: 0.8rem; letter-spacing: 0.5px;">
                            <tr>
                                <th scope="col" class="ps-4 py-3" style="width: 5%">No</th>
                                <th scope="col" class="py-3" style="width: 30%">Nama & Kontak</th>
                                <th scope="col" class="py-3" style="width: 30%">Tempat, Tgl Lahir & Agama</th>
                                <th scope="col" class="py-3" style="width: 20%">Pekerjaan / Jabatan</th>
                                <th scope="col" class="pe-4 py-3 text-center" style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftar_tidak_dihukum as $index => $item)
                                @php
                                    // Mengambil data spesifik pemohon dari kolom JSON secara aman
                                    $dataSpesifik = is_array($item->data_spesifik)
                                        ? $item->data_spesifik
                                        : json_decode($item->data_spesifik, true);
                                    $pemohon = $dataSpesifik['pemohon'] ?? [];
                                @endphp
                                <tr>
                                    {{-- No --}}
                                    <td class="ps-4 text-muted fw-medium">
                                        {{ ($daftar_tidak_dihukum->currentPage() - 1) * $daftar_tidak_dihukum->perPage() + $index + 1 }}
                                    </td>

                                    {{-- Nama & Kontak --}}
                                    <td>
                                        <div class="fw-bold text-dark mb-1">{{ $item->nama_pemohon }}</div>
                                        <div class="text-muted small">
                                            <i class="bi bi-telephone me-1"></i>{{ $item->no_hp_pemohon }}
                                        </div>
                                        <div class="text-muted small text-truncate" style="max-width: 250px;"
                                            title="{{ $pemohon['alamat'] ?? '-' }}">
                                            <i
                                                class="bi bi-geo-alt me-1"></i>{{ Str::limit($pemohon['alamat'] ?? '-', 40) }}
                                        </div>
                                    </td>

                                    {{-- Tempat, Tgl Lahir & Agama --}}
                                    <td>
                                        <div class="text-dark mb-1" style="font-size: 0.9rem;">
                                            {{ $pemohon['tempat_lahir'] ?? '-' }},
                                            {{ isset($pemohon['tanggal_lahir']) ? \Carbon\Carbon::parse($pemohon['tanggal_lahir'])->translatedFormat('d F Y') : '-' }}
                                        </div>
                                        <div class="text-muted small">
                                            <span class="badge bg-light text-secondary border">Agama:
                                                {{ $pemohon['agama'] ?? '-' }}</span>
                                            <span
                                                class="badge bg-light text-secondary border">{{ $pemohon['jenis_kelamin'] ?? '-' }}</span>
                                        </div>
                                    </td>

                                    {{-- Pekerjaan / Jabatan --}}
                                    <td>
                                        <div class="fw-semibold text-dark mb-1" style="font-size: 0.9rem;">
                                            {{ $pemohon['pekerjaan'] ?? '-' }}
                                        </div>
                                        <div class="text-muted small">
                                            <i class="bi bi-person-badge me-1"></i>Jabatan:
                                            {{ !empty($pemohon['jabatan']) ? $pemohon['jabatan'] : '-' }}
                                        </div>
                                    </td>

                                    {{-- Tombol Aksi --}}
                                    <td class="pe-4 text-center">
                                        <div class="d-inline-flex gap-1 align-items-center justify-content-center">

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('tidak-dipidana.surat-pernyataan-tidak-dihukum.edit', $item->id) }}"
                                                wire:navigate
                                                class="btn btn-warning btn-sm px-2 rounded-2 text-white d-inline-flex align-items-center gap-1 shadow-sm"
                                                style="height: 31px; font-size: 0.875rem;" title="Ubah Data">
                                                <i class="bi bi-pencil-square"></i>
                                                <span>Edit</span>
                                            </a>

                                            <!-- Tombol Hapus (Sudah Disetarakan Tinggi & Flexbox-nya) -->
                                            <button type="button"
                                                onclick="konfirmasiHapus({{ $item->id }}, '{{ $item->nama_pemohon }}')"
                                                class="btn btn-danger btn-sm px-2 rounded-2 d-inline-flex align-items-center gap-1 shadow-sm"
                                                style="height: 31px; font-size: 0.875rem;" title="Hapus Data">
                                                <i class="bi bi-trash-fill"></i>
                                                <span>Hapus</span>
                                            </button>

                                            <!-- Tombol Cetak -->
                                            <button type="button"
                                                class="btn btn-primary btn-sm px-2 rounded-2 d-inline-flex align-items-center gap-1 shadow-sm"
                                                data-bs-toggle="modal" data-bs-target="#modalCetak{{ $item->id }}"
                                                style="height: 31px; font-size: 0.875rem;" title="Cetak Dokumen">
                                                <i class="bi bi-printer-fill"></i>
                                                <span>Cetak</span>
                                            </button>

                                            {{-- Modal Cetak --}}
                                            <div class="modal fade" id="modalCetak{{ $item->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                    <div class="modal-content border-0 shadow rounded-3">
                                                        <div class="modal-header bg-light border-bottom-0 py-3">
                                                            <h6 class="modal-title fw-bold text-dark">
                                                                <i class="bi bi-download text-primary me-2"></i>Format
                                                                Unduhan
                                                            </h6>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-4">
                                                            <p class="text-muted small mb-4">Unduh Surat Pernyataan
                                                                untuk <strong>{{ $item->nama_pemohon }}</strong>:</p>
                                                            <div class="d-grid gap-2">
                                                                <a href="{{ route('cetak.surat-pernyataan-tidak-dihukum.pdf', $item->id) }}"
                                                                    target="_blank"
                                                                    class="btn btn-danger py-2 rounded-2 d-flex align-items-center justify-content-center gap-2 fw-semibold shadow-sm text-decoration-none">
                                                                    <i class="bi bi-file-earmark-pdf-fill fs-5"></i>
                                                                    <span>PDF</span>
                                                                </a>
                                                                <a href="{{ route('cetak.surat-pernyataan-tidak-dihukum.word', $item->id) }}"
                                                                    class="btn btn-primary py-2 rounded-2 d-flex align-items-center justify-content-center gap-2 fw-semibold shadow-sm text-decoration-none">
                                                                    <i class="bi bi-file-earmark-word-fill fs-5"></i>
                                                                    <span>Word</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal --}}

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <div class="mb-2 fs-1">📂</div>
                                        <h6 class="fw-semibold mb-1">Belum Ada Data</h6>
                                        <p class="small text-muted mb-0">Permohonan Surat Keterangan Tidak Pernah
                                            Dihukum masih kosong.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination Footer --}}
                    <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2 px-3 pb-3">
                        <div class="text-muted small">
                            Menampilkan {{ $daftar_tidak_dihukum->firstItem() ?? 0 }} sampai
                            {{ $daftar_tidak_dihukum->lastItem() ?? 0 }} dari
                            {{ $daftar_tidak_dihukum->total() }} data Surat Pernyataan.
                        </div>
                        <div>
                            {{ $daftar_tidak_dihukum->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @else
        {{-- Tampilan Form Create --}}
        <div class="card shadow-sm border-0 rounded-3">
            @include('livewire.tidak-pernah-dipidana.pernyataan-tidak-dihukum.create')
        </div>
    @endif

</div>

<script>
    function konfirmasiHapus(id, nama) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data atas nama " + nama + " akan dihapus permanen dari sistem TRITON!",
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
