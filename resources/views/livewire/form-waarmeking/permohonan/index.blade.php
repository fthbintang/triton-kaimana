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

                <a href="{{ route('waarmeking.create') }}" wire:navigate
                    class="btn btn-primary px-4 py-2 rounded-2 shadow-sm d-inline-flex align-items-center gap-2 fw-semibold">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Tambah Permohonan Baru</span>
                </a>
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
                                    <td class="ps-4 text-muted fw-medium">{{ $index + 1 }}</td>
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
                                    {{-- <td class="pe-4 text-center">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('cetak.waarmeking.pdf', ['id' => $item->id]) }}"
                                                target="_blank" class="btn btn-danger btn-sm px-2 rounded-2 shadow-sm">
                                                <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                                            </a>

                                            <a href="{{ route('cetak.waarmeking.word', ['id' => $item->id]) }}"
                                                class="btn btn-primary btn-sm px-2 rounded-2 shadow-sm">
                                                <i class="bi bi-file-earmark-word-fill"></i> Word
                                            </a>
                                        </div>
                                    </td> --}}
                                    <td class="pe-4 text-center">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('waarmeking.edit', ['id' => $item->id]) }}" wire:navigate
                                                class="btn btn-warning btn-sm px-2 rounded-2 shadow-sm text-white"
                                                title="Ubah Data">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <a href="{{ route('cetak.waarmeking.pdf', ['id' => $item->id]) }}"
                                                target="_blank" class="btn btn-danger btn-sm px-2 rounded-2 shadow-sm">
                                                <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                                            </a>

                                            <a href="{{ route('cetak.waarmeking.word', ['id' => $item->id]) }}"
                                                class="btn btn-primary btn-sm px-2 rounded-2 shadow-sm">
                                                <i class="bi bi-file-earmark-word-fill"></i> Word
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <div class="mb-2 fs-1">📂</div>
                                        <h6 class="fw-semibold mb-1">Belum Ada Data</h6>
                                        <p class="small text-muted mb-0">Permohonan dokumen Waarmeking masih kosong.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-sm border-0 rounded-3">
            @include('livewire.form-waarmeking.permohonan.create')
        </div>
    @endif

</div>
