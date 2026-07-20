<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | TRITON - HUKUM PN Kaimana</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <!-- NAVIGATION BAR (TOPBAR) -->
    <nav class="bg-gradient-to-r from-[#0A3622] to-[#146C43] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Sisi Kiri: Identitas Aplikasi -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-1.5 rounded-lg shadow flex items-center justify-center w-8 h-8">
                        <i class="fa-solid fa-scale-balanced text-[#0A3622] text-sm"></i>
                    </div>
                    <div>
                        <span class="font-extrabold tracking-tight text-lg">TRITON <span
                                class="text-[#FFC107] font-light">- HUKUM</span></span>
                        <span
                            class="hidden md:inline-block text-[10px] text-emerald-200/80 bg-emerald-900/40 px-2 py-0.5 rounded-full ml-2 border border-emerald-700/50">PN
                            KAIMANA</span>
                    </div>
                </div>

                <!-- Sisi Kanan: Informasi Akun & Tombol Logout -->
                <div class="flex items-center space-x-4">
                    <!-- Detail Pengguna (Hidden di Layar Kecil) -->
                    <div class="hidden sm:flex flex-col text-right">
                        <span
                            class="text-sm font-semibold tracking-wide">{{ Auth::user()->name ?? 'Nama Pengguna' }}</span>
                        <span class="text-[10px] text-emerald-200/80 uppercase tracking-widest font-medium">Petugas
                            Hukum</span>
                    </div>

                    <!-- Pembatas Garis -->
                    <div class="hidden sm:block h-6 w-px bg-white/20"></div>

                    <!-- Tombol Logout -->
                    <!-- Jika menggunakan Laravel Fortify/Breeze biasa, logout harus berupa form POST demi keamanan -->
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                            class="bg-red-700 hover:bg-red-600 text-white px-3 py-2 rounded-xl text-xs font-semibold shadow-sm transition-all duration-150 flex items-center space-x-1.5 cursor-pointer transform active:scale-95">
                            <i class="fa-solid fa-right-from-bracket text-xs"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA (WORKSPACE) -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Welcome Banner Mini -->
        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Selamat Datang di Panel Utama</h1>
                <p class="text-sm text-gray-500 mt-1">Sistem informasi manajemen registrasi dan dokumen Kepaniteraan
                    Hukum.</p>
            </div>
            <div
                class="text-sm text-gray-400 bg-gray-50 border border-gray-200/60 rounded-xl px-4 py-2.5 self-start md:self-auto flex items-center space-x-2">
                <i class="fa-regular fa-calendar-days text-[#146C43]"></i>
                <span class="font-medium text-gray-600">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
        </div>

        <!-- AREA DUMMY / PLACEHOLDER (Ganti Bagian Ini Nanti) -->
        <div class="border-2 border-dashed border-gray-200 rounded-2xl bg-white p-12 text-center">
            <div
                class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4 text-[#146C43]">
                <i class="fa-solid fa-code-branch text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Ruang Siap Pakai</h3>
            <p class="text-sm text-gray-500 max-w-md mx-auto mb-4">
                Autentikasi login dan fungsi logout telah berhasil dipasang. Silakan isi bagian ini dengan tabel data,
                ringkasan berkas, atau menu fitur yang Anda inginkan.
            </p>
            <div class="inline-flex space-x-2">
                <span
                    class="bg-emerald-50 text-[#146C43] text-xs font-semibold px-3 py-1.5 rounded-lg border border-emerald-200/50">Status:
                    Terautentikasi</span>
                <span
                    class="bg-amber-50 text-amber-800 text-xs font-semibold px-3 py-1.5 rounded-lg border border-amber-200/50">Tema:
                    Hijau PN Kaimana</span>
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-400">
        <div class="max-w-7xl mx-auto px-4">
            &copy; 2026 Pengadilan Negeri Kaimana. Hak Cipta Dilindungi.
        </div>
    </footer>

</body>

</html>
