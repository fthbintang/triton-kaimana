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
            <h2 class="fw-bold text-dark m-0">APLIKASI TRITON</h2>
            <p class="fw-semibold text-court my-1" style="font-size: 0.95rem; letter-spacing: 0.5px;">
                (Terintegrasi Pelayanan Informasi Dan Permohonan Online)
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

            <!-- 1. Waarmeking -->
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('layanan.waarmeking') }}" class="text-decoration-none text-dark">
                    <div class="card h-100 p-4 text-center menu-card">
                        <div class="card-body">
                            <div class="icon-box">
                                <i class="bi bi-file-earmark-check-fill fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Permohonan Waarmeking</h5>
                            <p class="small text-muted mb-0">Pembuatan surat permohonan pengesahan surat keterangan ahli
                                waris di bawah tangan beserta rincian tabungan.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 2. Surat Kuasa Insidentil -->
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('layanan.surat-kuasa') }}" class="text-decoration-none text-dark">
                    <div class="card h-100 p-4 text-center menu-card">
                        <div class="card-body">
                            <div class="icon-box">
                                <i class="bi bi-person-vcard-fill fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Kuasa Insidentil</h5>
                            <p class="small text-muted mb-0">Pembuatan surat permohonan izin beracara sebagai kuasa
                                hukum insidentil khusus untuk keluarga dekat.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 3. Surat Keterangan Tidak Pernah Dipidana -->
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('layanan.tidak-dipidana') }}" class="text-decoration-none text-dark">
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
