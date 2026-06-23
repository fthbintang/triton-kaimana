<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Waarmeking - TRITON PN Kaimana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        :root {
            --warna-court: #0A5C36;
            /* Hijau Tua Khas Mahkamah Agung */
            --warna-court-light: #e8f5e9;
        }

        .bg-court {
            bg-color: var(--warna-court) !important;
            background: var(--warna-court);
        }

        .text-court {
            color: var(--warna-court) !important;
        }

        .btn-court {
            background-color: var(--warna-court);
            color: white;
        }

        .btn-court:hover {
            background-color: #084729;
            color: white;
        }

        .btn-outline-court {
            border-color: var(--warna-court);
            color: var(--warna-court);
        }

        .btn-outline-court:hover {
            background-color: var(--warna-court);
            color: white;
        }

        .badge-court {
            background-color: var(--warna-court);
            color: white;
        }

        .line-double {
            border-top: 3px double #333;
            opacity: 1;
            margin-top: 5px;
        }
    </style>
    @livewireStyles
</head>

<body class="bg-light">

    <div id="global-loader" class="loading-overlay" style="display: none;">
        <div class="spinner-border text-court" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h5 class="fw-bold text-dark mt-3 mb-1">Memproses Halaman...</h5>
        <p class="text-muted small">Mohon tunggu sebentar, sedang menyiapkan data</p>
    </div>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <!-- KOP SURAT RESMI INSTANSI -->
                <div class="d-flex align-items-center mb-3 text-center text-md-start flex-column flex-md-row">
                    <!-- Logo di sebelah kiri (Aman dari peringatan VS Code) -->
                    <div class="mb-3 mb-md-0" style="flex-shrink: 0;">
                        <img src="{{ asset('img/logo-pn-kaimana.png') }}" alt="Logo PN Kaimana" class="img-fluid"
                            style="max-height: 115px;">
                    </div>

                    <!-- Teks Instansi Rata Tengah Sejati (Aman dari peringatan VS Code) -->
                    <div class="text-center" style="flex-grow: 1; margin-left: -115px;">
                        <h4 class="fw-bold m-0 text-dark"
                            style="letter-spacing: 0.5px; font-size: 1.35rem; font-weight: 700;">MAHKAMAH AGUNG REPUBLIK
                            INDONESIA</h4>
                        <h4 class="fw-bold m-0 text-dark"
                            style="letter-spacing: 0.5px; font-size: 1.35rem; font-weight: 700;">DIREKTORAT JENDERAL
                            BADAN PERADILAN UMUM</h4>
                        <h4 class="fw-bold m-0 text-dark"
                            style="letter-spacing: 0.5px; font-size: 1.35rem; font-weight: 700;">PENGADILAN TINGGI PAPUA
                            BARAT</h4>
                        <h4 class="fw-bold m-0 text-dark"
                            style="letter-spacing: 0.5px; font-size: 1.35rem; font-weight: 800;">PENGADILAN NEGERI
                            KAIMANA</h4>

                        <!-- Alamat Kontak -->
                        <p class="small m-0 text-muted lh-sm mt-2" style="font-size: 0.85rem;">
                            Jalan Batu Putih, Kelurahan Krooy, Kabupaten Kaimana, Papua Barat <br>
                            <span class="text-nowrap"><i class="bi bi-telephone-fill small"></i> Tlp. (0957)
                                2227166</span> |
                            <span class="text-nowrap"><i class="bi bi-envelope-fill small"></i> Email:
                                pnkaimana@gmail.com</span> |
                            <span class="text-nowrap"><i class="bi bi-globe small"></i> Website: pn-kaimana.go.id</span>
                        </p>
                    </div>
                </div>

                <hr class="line-double">

                <div class="mt-4">
                    {{ $slot }}
                </div>

                <div class="text-center mt-4 mb-5">
                    <p class="text-muted small">
                        <i class="bi bi-shield-lock-fill"></i> Data permohonan yang dikirimkan terenkripsi secara aman
                        dan langsung masuk ke Sistem Kepaniteraan Hukum PN Kaimana.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Ketika user mulai mengklik tombol rute (Proses muat dimulai)
        document.addEventListener('livewire:navigate', () => {
            document.getElementById('global-loader').style.display = 'flex';
        });

        // Ketika halaman baru selesai dimuat ke browser (Proses muat selesai)
        document.addEventListener('livewire:navigated', () => {
            document.getElementById('global-loader').style.display = 'none';
        });
    </script>
    @livewireScripts
</body>

</html>
