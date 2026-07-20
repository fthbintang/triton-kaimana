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

    <!-- Topbar / Navbar Modern Bootstrap 5 -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm fixed-top py-2">
        <div class="container">

            <!-- Sisi Kiri: Identitas Aplikasi & Logo Resmi PN Kaimana -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <!-- Logo Gambar PN Kaimana -->
                <div class="d-flex align-items-center justify-content-center me-2" style="width: 42px; height: 42px;">
                    <img src="{{ asset('img/logo-pn-kaimana.png') }}" alt="Logo PN Kaimana" class="img-fluid"
                        style="max-height: 100%; object-fit: contain;">
                </div>
                <div class="lh-sm">
                    <div class="d-flex align-items-center mb-0.5">
                        <!-- Nama Brand Lebih Tegas & Proporsional -->
                        <span class="fw-bold text-dark" style="font-size: 16px; letter-spacing: -0.3px;">
                            TRITON - Kepaniteraan Hukum
                        </span>
                    </div>
                    <!-- Sub-teks Instansi dengan Gaya Wide Tracking -->
                    <span class="text-uppercase text-muted d-block font-semibold"
                        style="font-size: 9px; letter-spacing: 1px; font-weight: 600;">
                        PN Kaimana
                    </span>
                </div>
            </a>

            <!-- Tombol Hamburger untuk Mobile -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Konten Navbar -->
            <div class="collapse navbar-collapse" id="navbarContent">

                <!-- Sisi Kanan: Menu Navigasi, Profil, & Logout -->
                <div class="navbar-nav ms-auto align-items-lg-center mt-3 mt-lg-0 gap-3">

                    <!-- 1. Tombol CRUD User (Hanya untuk Admin) -->
                    @if (auth()->user()->role === 'Admin')
                        <div class="nav-item">
                            <a class="btn btn-outline-success btn-sm fw-bold d-inline-flex align-items-center px-3 py-2 rounded-3 border-emerald-200"
                                href="{{ route('users.index') }}" style="color: #146C43; font-size: 12px;">
                                <i class="fa-solid fa-users-gear me-2"></i>
                                <span>Kelola Pengguna</span>
                            </a>
                        </div>
                    @endif

                    <!-- Pembatas Vertikal (Hanya tampil di Layar Besar) -->
                    <div class="d-none d-lg-block bg-gray-200" style="width: 1px; height: 24px;"></div>

                    <!-- 2. Informasi User yang Login -->
                    <div class="nav-item d-flex align-items-center text-lg-end gap-2">
                        <div class="d-none d-md-block">
                            <p class="mb-0 fw-bold text-dark" style="font-size: 12px; line-height: 1;">
                                {{ auth()->user()->nama_lengkap }}</p>
                            <p class="mb-0 text-uppercase fw-semibold text-emerald-700"
                                style="font-size: 10px; margin-top: 4px; letter-spacing: 0.5px; color: #146C43;">
                                {{ auth()->user()->role }}</p>
                        </div>
                        <!-- Avatar Lingkaran Inisial Nama -->
                        <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold shadow-sm"
                            style="background: linear-gradient(135deg, #146C43 0%, #FFC107 100%); width: 34px; height: 34px; font-size: 12px;">
                            {{ strtoupper(substr(auth()->user()->username, 0, 2)) }}
                        </div>
                    </div>

                    <!-- Pembatas Vertikal (Hanya tampil di Layar Besar) -->
                    <div class="d-none d-lg-block bg-gray-200" style="width: 1px; height: 24px;"></div>

                    <!-- 3. Tombol Logout (Form POST) -->
                    <div class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                            @csrf
                            <button type="submit"
                                class="btn btn-danger btn-sm fw-bold d-inline-flex align-items-center px-3 py-2 rounded-3 border-0"
                                style="background-color: #FFF5F5; color: #E53E3E; font-size: 12px;"
                                onmouseover="this.style.backgroundColor='#FED7D7'"
                                onmouseout="this.style.backgroundColor='#FFF5F5'">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </nav>

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
                {{-- <div class="d-flex align-items-center mb-3 text-center text-md-start flex-column flex-md-row">
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
                            <span class="text-nowrap"><i class="bi bi-globe small"></i> Website:
                                pn-kaimana.go.id</span>
                        </p>
                    </div>
                </div> --}}

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
