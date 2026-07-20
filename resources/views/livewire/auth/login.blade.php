<!-- Cukup langsung tulis Card-nya saja tanpa pembungkus HTML luar -->
<div
    class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden max-w-4xl w-full flex flex-col md:flex-row transform transition-all duration-300 hover:shadow-emerald-950/20">

    <!-- Sisi Kiri: Branding -->
    <div
        class="md:w-1/2 bg-gradient-to-br from-[#146C43] to-[#0A3622] p-8 text-white flex flex-col justify-between relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
        <div class="absolute -left-10 -top-10 w-40 h-40 bg-[#FFC107]/10 rounded-full blur-2xl"></div>

        <div class="flex items-center space-x-3 z-10">
            <div class="bg-white p-2 rounded-lg shadow-md flex items-center justify-center w-10 h-10">
                <i class="fa-solid fa-scale-balanced text-[#0A3622] text-lg"></i>
            </div>
            <div>
                <h3 class="font-bold text-xs tracking-wider uppercase text-emerald-100">Pengadilan Negeri</h3>
                <h2 class="font-extrabold text-sm tracking-wide text-[#FFC107]">KAIMANA</h2>
            </div>
        </div>

        <div class="my-12 md:my-0 z-10">
            <div
                class="inline-block bg-[#FFC107] text-[#0A3622] text-xs font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-widest shadow-sm">
                Kepaniteraan Hukum
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight mb-2">
                TRITON <span class="text-[#FFC107] font-light">- HUKUM</span>
            </h1>
            <p class="text-xs text-emerald-100 font-medium leading-relaxed max-w-sm">
                Template Registrasi Informasi, Tatacara, dan Output Naskah - Hukum.
            </p>
        </div>

        <div class="text-xs text-emerald-200/60 border-t border-white/10 pt-4 flex justify-between items-center z-10">
            <!-- Menjabarkan esensi KUAT secara horizontal -->
            <span>Kreatif • Ulet • Akuntabel • Transparan</span>
            <span class="text-[#FFC107] font-semibold">
                <i class="fa-solid fa-shield-halved text-[10px] mr-1"></i>Pelayanan KUAT
            </span>
        </div>
    </div>

    <!-- Sisi Kanan: Form Login -->
    <div class="md:w-1/2 p-8 md:p-10 flex flex-col justify-center bg-white">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-[#0A3622]">Selamat Datang</h2>
            <p class="text-sm text-gray-500 mt-1">Silakan masuk menggunakan akun Anda.</p>
        </div>

        <!-- Perhatikan wire:submit.prevent di sini -->
        <form wire:submit.prevent="login" novalidate class="space-y-5">
            <!-- Input Username -->
            <div>
                <label for="username"
                    class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-user-tie text-sm"></i>
                    </div>
                    <!-- Menggunakan .blur agar validasi terasa responsif -->
                    <input type="text" id="username" wire:model.blur="username"
                        class="block w-full pl-10 pr-3 py-3 bg-gray-50 border @error('username') border-red-500 bg-red-50/30 @else border-gray-200 @enderror rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#146C43] focus:border-transparent focus:bg-white transition-all duration-200"
                        placeholder="Masukkan nama pengguna">
                </div>
                @error('username')
                    <span class="text-red-600 text-xs mt-1 block font-medium"><i
                            class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Password -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="password"
                        class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Password</label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <input type="password" id="password" wire:model.blur="password"
                        class="block w-full pl-10 pr-10 py-3 bg-gray-50 border @error('password') border-red-500 bg-red-50/30 @else border-gray-200 @enderror rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#146C43] focus:border-transparent focus:bg-white transition-all duration-200"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <span class="text-red-600 text-xs mt-1 block font-medium"><i
                            class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span>
                @enderror
            </div>

            <!-- Ingat Saya -->
            <div class="flex items-center">
                <input id="remember" type="checkbox" wire:model="remember"
                    class="h-4 w-4 text-[#146C43] focus:ring-[#146C43] border-gray-300 rounded-md accent-[#146C43]">
                <label for="remember" class="ml-2 block text-xs font-medium text-gray-600">
                    Ingat sesi saya di perangkat ini
                </label>
            </div>

            <!-- Tombol Login dengan Fitur Loading Otomatis -->
            <button type="submit" wire:loading.attr="disabled"
                class="w-full bg-[#0A3622] hover:bg-[#146C43] text-white font-semibold py-3 px-4 rounded-xl text-sm shadow-md hover:shadow-lg transform active:scale-[0.98] transition-all duration-150 flex items-center justify-center space-x-2 cursor-pointer mt-2">

                <!-- State 1: Tampilan Normal (Akan disembunyikan saat loading) -->
                <span wire:loading.remove class="d-flex align-items-center justify-content-center gap-2">
                    <span>Login ke Sistem</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </span>

                <!-- State 2: Tampilan Loading (Hanya muncul saat proses backend berjalan) -->
                <span wire:loading class="d-flex align-items-center justify-content-center gap-2">
                    <span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span>
                    <span>Memproses Masuk...</span>
                </span>
            </button>
        </form>

        <div class="mt-10 text-center text-[11px] text-gray-400">
            &copy; 2026 Pengadilan Negeri Kaimana. Hak Cipta Dilindungi.
        </div>
    </div>
</div>
