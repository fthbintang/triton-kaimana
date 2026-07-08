<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRITON - Pengadilan Negeri Kaimana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --court-color: #0A5C36;
            --court-hover: #074327;
        }

        body {
            background-color: #f4f7f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .text-court {
            color: var(--court-color);
        }

        .bg-court {
            background-color: var(--court-color);
        }

        /* Efek Hover Keren pada Kartu Pilihan */
        .menu-card {
            border: none;
            border-radius: 16px;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 20px rgba(10, 92, 54, 0.15);
            border-bottom: 4px solid var(--court-color);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            border-radius: 50px;
            background-color: rgba(10, 92, 54, 0.1);
            color: var(--court-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            transition: all 0.3s ease;
        }

        .menu-card:hover .icon-box {
            background-color: var(--court-color);
            color: white;
        }
    </style>
</head>

<body>

    <div class="container my-auto py-5">

        <!-- HEADER PORTAL -->
        <div class="text-center mb-5">
            <img src="{{ asset('img/logo-pn-kaimana.png') }}" alt="Logo PN Kaimana" class="img-fluid mb-3"
                style="max-height: 110px;">
            <h2 class="fw-bold text-dark m-0">TRITON - HUKUM</h2>
            <p class="fw-semibold text-court my-1" style="font-size: 0.95rem; letter-spacing: 0.5px;">
                (Template Registrasi Informasi, Tatacara, dan Output Naskah - Hukum)
            </p>
            <p class="text-secondary lead fs-6 m-0">Sistem Pelayanan Hukum Mandiri — Pengadilan Negeri Kaimana</p>
            <p class="text-muted fw-medium small text-uppercase pt-3" style="letter-spacing: 1px; font-size: 0.8rem;">
                Kepaniteraan Hukum</p>
            <div class="mx-auto bg-court mt-2" style="width: 60px; height: 4px; border-radius: 2px;"></div>
        </div>

        <!-- KALIMAT INSTRUKSI PANDUAN WIDGET -->
        <div class="text-center mb-4">
            <p
                class="text-muted small fw-medium text-uppercase shadow-sm bg-white d-inline-block px-3 py-2 rounded-pill border">
                <i class="bi bi-info-circle-fill text-court me-1"></i> Silakan Pilih Layanan Untuk Membuat Surat
                Permohonan Anda
            </p>
        </div>

        <!-- 3 PILIHAN TOMBOL LAYANAN -->
        <div class="row g-4 justify-content-center">

            <!-- 1. Waarmeking (Membuka Pilihan Dokumen via Pop-up) -->
            <div class="col-md-4 col-sm-6">
                <div class="card h-100 p-4 text-center menu-card" data-bs-toggle="modal"
                    data-bs-target="#modalWaarmeking">
                    <div class="card-body">
                        <div class="icon-box">
                            <i class="bi bi-file-earmark-check-fill fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Permohonan Waarmeking</h5>
                        <p class="small text-muted mb-0">Pembuatan surat permohonan pengesahan surat keterangan ahli
                            waris di bawah tangan beserta rincian tabungan.</p>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalWaarmeking" tabindex="-1" aria-labelledby="modalWaarmekingLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content" style="border-radius: 16px; border: none;">
                        <div class="modal-header border-0 pb-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body pt-0 text-center">
                            <i class="bi bi-folder2-open text-court" style="font-size: 3.5rem;"></i>
                            <h4 class="fw-bold mt-2 text-dark">Pilih Dokumen Waarmeking</h4>
                            <p class="text-muted small mb-4">Silakan pilih jenis dokumen kelengkapan waarmeking yang
                                ingin Anda buat</p>

                            <div class="row g-3 justify-content-center">
                                <div class="col-md-6">
                                    <a href="{{ route('waarmeking.index') }}" wire:navigate
                                        class="text-decoration-none text-dark">
                                        <div class="card p-4 h-100 menu-card border border-light-subtle">
                                            <div class="text-court mb-2"><i class="bi bi-file-earmark-text fs-3"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1">1. Surat Permohonan</h6>
                                            <p class="text-muted m-0" style="font-size: 0.75rem;">Formulir utama
                                                permohonan waarmeking untuk diajukan ke Ketua Pengadilan.</p>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-6">
                                    <a href="{{ route('waarmeking.surat-kuasa.index') }}" wire:navigate
                                        class="text-decoration-none text-dark">
                                        <div class="card p-4 h-100 menu-card border border-light-subtle">
                                            <div class="text-warning mb-2"><i
                                                    class="bi bi-file-earmark-person fs-3"></i></div>
                                            <h6 class="fw-bold mb-1">2. Surat Kuasa</h6>
                                            <p class="text-muted m-0" style="font-size: 0.75rem;">Surat pemberian kuasa
                                                pengurusan jika diwakilkan oleh salah satu ahli waris.</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 justify-content-center pb-4">
                            <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3"
                                data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Surat Kuasa Insidentil -->
            <div class="col-md-4 col-sm-6">
                <div class="card h-100 p-4 text-center menu-card" data-bs-toggle="modal"
                    data-bs-target="#modalKuasaInsidentil" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="icon-box">
                            <i class="bi bi-person-vcard-fill fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Kuasa Insidentil</h5>
                        <p class="small text-muted mb-0">Pembuatan surat permohonan izin beracara sebagai kuasa
                            hukum insidentil khusus untuk keluarga dekat.</p>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalKuasaInsidentil" tabindex="-1" aria-labelledby="modalKuasaInsidentilLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content" style="border-radius: 16px; border: none;">
                        <div class="modal-header border-0 pb-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body pt-0 text-center">
                            <i class="bi bi-folder2-open text-court" style="font-size: 3.5rem;"></i>
                            <h4 class="fw-bold mt-2 text-dark">Pilih Dokumen Kuasa Insidentil</h4>
                            <p class="text-muted small mb-4">Silakan pilih jenis dokumen kelengkapan Kuasa Insidentil
                                yang
                                ingin Anda buat</p>

                            <div class="row g-3 justify-content-center">
                                <div class="col-md-6">
                                    <a href="{{ route('permohonan.kuasa-insidentil.index') }}" wire:navigate
                                        class="text-decoration-none text-dark">
                                        <div class="card p-4 h-100 menu-card border border-light-subtle">
                                            <div class="text-court mb-2"><i class="bi bi-file-earmark-text fs-3"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1">1. Surat Permohonan</h6>
                                            <p class="text-muted m-0" style="font-size: 0.75rem;">Formulir permohonan
                                                izin
                                                kuasa insidentil untuk diajukan kepada Ketua Pengadilan Negeri.</p>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-6">
                                    <a href="{{ route('kuasa-insidentil.surat-kuasa.index') }}" wire:navigate
                                        class="text-decoration-none text-dark">
                                        <div class="card p-4 h-100 menu-card border border-light-subtle">
                                            <div class="text-warning mb-2"><i
                                                    class="bi bi-file-earmark-person fs-3"></i></div>
                                            <h6 class="fw-bold mb-1">2. Surat Kuasa</h6>
                                            <p class="text-muted m-0" style="font-size: 0.75rem;">Surat pemberian
                                                kuasa khusus
                                                antara pemberi kuasa (prinsipal) dan penerima kuasa (keluarga).</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 justify-content-center pb-4">
                            <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3"
                                data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Surat Keterangan Tidak Pernah Dipidana -->
            {{-- <div class="col-md-4 col-sm-6">
                <a href="{{ route('layanan.tidak-dipidana') }}" wire:navigate class="text-decoration-none text-dark">
                    <div class="card h-100 p-4 text-center menu-card">
                        <div class="card-body">
                            <div class="icon-box">
                                <i class="bi bi-shield-exclamation fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Keterangan Tidak Dipidana</h5>
                            <p class="small text-muted mb-0">Pengisian data permohonan surat keterangan resmi tidak
                                pernah dihukum sebagai syarat kelengkapan administrasi.</p>
                        </div>
                    </div>
                </a>
            </div> --}}

            <!-- 1. KARTU MENU UTAMA (TRIGGER MODAL) -->
            <div class="col-md-4 col-sm-6">
                <!-- Mengganti tag <a> dengan target modal -->
                <div class="card h-100 p-4 text-center menu-card" data-bs-toggle="modal"
                    data-bs-target="#modalTidakDipidana" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="icon-box">
                            <i class="bi bi-shield-exclamation fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Keterangan Tidak Dipidana</h5>
                        <p class="small text-muted mb-0">Pengisian data permohonan surat keterangan resmi tidak
                            pernah dihukum sebagai syarat kelengkapan administrasi.</p>
                    </div>
                </div>
            </div>

            <!-- 2. MODAL PILIHAN DOKUMEN KETERANGAN TIDAK DIPIDANA -->
            <div class="modal fade" id="modalTidakDipidana" tabindex="-1" aria-labelledby="modalTidakDipidanaLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content" style="border-radius: 16px; border: none;">
                        <div class="modal-header border-0 pb-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body pt-0 text-center">
                            <i class="bi bi-folder2-open text-court" style="font-size: 3.5rem;"></i>
                            <h4 class="fw-bold mt-2 text-dark">Pilih Dokumen yang Diperlukan</h4>
                            <p class="text-muted small mb-4">Silakan tentukan jenis berkas administrasi Surat
                                Keterangan Tidak Dipidana yang ingin Anda buat</p>

                            <div class="row g-3 justify-content-center">
                                <!-- PILIHAN 1: SURAT PERNYATAAN MANDIRI -->
                                <div class="col-md-6">
                                    <a href="{{ route('tidak-dipidana.surat-pernyataan-tidak-dihukum') }}"
                                        wire:navigate class="text-decoration-none text-dark">
                                        <div class="card p-4 h-100 menu-card border border-light-subtle">
                                            <div class="text-court mb-2">
                                                <i class="bi bi-file-earmark-check fs-3"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1">1. Surat Pernyataan</h6>
                                            <p class="text-muted m-0" style="font-size: 0.75rem;">Surat pernyataan
                                                mandiri tidak pernah dihukum penjara dan/atau tidak sedang menjalani
                                                proses hukum.</p>
                                        </div>
                                    </a>
                                </div>

                                <!-- PILIHAN 2: SURAT KUASA (PENGURUSAN DIWAKILKAN) -->
                                <div class="col-md-6">
                                    <!-- Silakan sesuaikan nama route surat kuasa tidak dipidana Anda di sini -->
                                    <a href="#" wire:navigate class="text-decoration-none text-dark">
                                        <div class="card p-4 h-100 menu-card border border-light-subtle">
                                            <div class="text-warning mb-2">
                                                <i class="bi bi-file-earmark-person fs-3"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1">2. Surat Kuasa</h6>
                                            <p class="text-muted m-0" style="font-size: 0.75rem;">Wajib dibuat jika
                                                pengurusan administrasi Surat Keterangan Tidak Dipidana dikuasakan
                                                kepada orang lain.</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 justify-content-center pb-4">
                            <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3"
                                data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="text-center py-3 bg-white border-top shadow-sm">
        <p class="small text-muted m-0">
            © 2026 Kepaniteraan Hukum Pengadilan Negeri Kaimana. Aplikasi TRITON Hak Cipta Dilindungi.
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
