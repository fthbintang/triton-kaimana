<?php

namespace App\Livewire\FormWaarmeking;

use App\Models\Permohonan;
use Livewire\Component;
use Livewire\Attributes\Layout;

class FormPermohonan extends Component
{
    // 1. Data Utama Pemohon (Berperan sebagai Pemohon Utama / Perwakilan)
    public string $nama_pemohon = '';
    public string $nik_pemohon = '';
    public string $no_hp_pemohon = '';

    // BARU: Array Dinamis untuk menampung data banyak pemohon/ahli waris tambahan
    public array $pemohon_tambahan = [];

    // 2. Data Spesifik Waarmeking (Detail Pemohon Utama)
    public string $tempat_lahir = '';
    public string $tanggal_lahir = '';
    public string $jenis_kelamin = '';
    public string $pekerjaan = '';
    public string $agama = '';
    public string $alamat = '';
    public string $nama_pewaris = '';

    // 3. Array Dinamis untuk menampung data banyak bank sekaligus
    public array $daftar_rekening = [];

    // 4. Status Notifikasi Sukses
    public ?string $pesan_sukses = null;

    // Fungsi bawaan Livewire yang otomatis berjalan saat form pertama kali dibuka
    public function mount(): void
    {
        // BARU: Inisialisasi awal pemohon tambahan kosong (biar muncul jika user klik tombol tambah)
        $this->pemohon_tambahan = [];

        // Nilai awal daftar rekening
        $this->daftar_rekening = [
            [
                'nama_bank' => '',
                'cabang_bank' => '',
                'nomor_rekening' => '',
                'nominal_angka' => '', 
                'nominal_huruf' => ''
            ]
        ];
    }

    // BARU: Fungsi untuk menambah baris pemohon tambahan (Dijalankan saat tombol "+ Tambah Ahli Waris" diklik)
    public function tambahPemohon(): void
    {
        $this->pemohon_tambahan[] = [
            'nama' => '',
            'nik' => '',
            'tempat_lahir' => '',
            'tanggal_lahir' => '',
            'jenis_kelamin' => '',
            'agama' => '',
            'pekerjaan' => '',
            'alamat' => ''
        ];
    }

    // BARU: Fungsi untuk menghapus baris pemohon tambahan jika kelebihan
    public function hapusPemohon(int $index): void
    {
        unset($this->pemohon_tambahan[$index]);
        $this->pemohon_tambahan = array_values($this->pemohon_tambahan); // Reset susunan index array
    }

    // Fungsi untuk menambah baris bank baru
    public function tambahBank(): void
    {
        $this->daftar_rekening[] = [
            'nama_bank' => '',
            'cabang_bank' => '',
            'nomor_rekening' => '',
            'nominal_angka' => '',
            'nominal_huruf' => ''
        ];
    }

    // Fungsi untuk menghapus baris bank
    public function hapusBank(int $index): void
    {
        unset($this->daftar_rekening[$index]);
        $this->daftar_rekening = array_values($this->daftar_rekening);
    }

    // Mengawasi perubahan ketikan angka secara real-time
    public function updatedDaftarRekening(mixed $value, string $key): void
    {
        if (str_contains($key, '.nominal_angka')) {
            $parts = explode('.', $key);
            $index = (int)$parts[0];
            
            if ($value !== '' && $value !== null) {
                $angkaHanyaDigit = str_replace('.', '', $value);
                $angkaClean = (int)$angkaHanyaDigit;
                
                $this->daftar_rekening[$index]['nominal_huruf'] = $this->terbilang($angkaClean) . ' Rupiah';
            } else {
                $this->daftar_rekening[$index]['nominal_huruf'] = '';
            }
        }
    }

    // Rumus Matematika Helper Terbilang
    private function terbilang(int $angka): string
    {
        $angka = abs((int)$angka);
        $baca = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        
        if ($angka < 12) {
            return " " . $baca[$angka];
        } elseif ($angka < 20) {
            return $this->terbilang($angka - 10) . " Belas";
        } elseif ($angka < 100) {
            return $this->terbilang($angka / 10) . " Puluh" . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            return " Seratus" . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return $this->terbilang($angka / 100) . " Ratus" . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            return " Seribu" . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return $this->terbilang($angka / 1000) . " Ribu" . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return $this->terbilang($angka / 1000000) . " Juta" . $this->terbilang($angka % 1000000);
        }
        
        return "";
    }

    // Fungsi Eksekusi ketika Form di-Submit oleh user
    public function simpan(): void
    {
        // 1. Definisikan Aturan Validasi untuk Semua Kolom
        $rules = [
            // Validasi Data Utama Pemohon (Perwakilan)
            'nama_pemohon'   => 'required|string|min:3',
            'nik_pemohon'    => 'required|numeric|digits:16',
            'no_hp_pemohon'  => 'required|numeric|min_digits:10',

            // Validasi Data Detail Pemohon Utama & Pewaris
            'tempat_lahir'   => 'required|string|min:3',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'agama'          => 'required|string',
            'pekerjaan'      => 'required|string',
            'nama_pewaris'   => 'required|string|min:3',
            'alamat'         => 'required|string|min:10',

            // BARU: Validasi Dinamis Pemohon Tambahan (Jika ada lebih dari 1 orang)
            'pemohon_tambahan'                    => 'nullable|array',
            'pemohon_tambahan.*.nama'             => 'required|string|min:3',
            'pemohon_tambahan.*.nik'              => 'required|numeric|digits:16',
            'pemohon_tambahan.*.tempat_lahir'     => 'required|string',
            'pemohon_tambahan.*.tanggal_lahir'    => 'required|date',
            'pemohon_tambahan.*.jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'pemohon_tambahan.*.agama'            => 'required|string',
            'pemohon_tambahan.*.pekerjaan'        => 'required|string',
            'pemohon_tambahan.*.alamat'           => 'required|string',

            // Validasi Dinamis untuk Array Daftar Rekening Bank
            'daftar_rekening'                    => 'required|array|min:1',
            'daftar_rekening.*.nama_bank'        => 'required|string',
            'daftar_rekening.*.cabang_bank'      => 'required|string',
            'daftar_rekening.*.nomor_rekening'   => 'required|numeric',
            'daftar_rekening.*.nominal_angka'    => 'required',
        ];

        // 2. Kustomisasi Pesan Eror Bahasa Indonesia
        $messages = [
            'nama_pemohon.required'   => 'Nama lengkap pemohon utama wajib diisi.',
            'nama_pemohon.min'        => 'Nama lengkap minimal berisi 3 karakter.',
            'nik_pemohon.required'    => 'NIK pemohon utama wajib diisi.',
            'nik_pemohon.digits'      => 'NIK pemohon utama harus tepat berjumlah 16 digit.',
            'nik_pemohon.numeric'     => 'NIK harus berupa angka.',
            'no_hp_pemohon.required'  => 'Nomor HP / WhatsApp wajib diisi.',
            'no_hp_pemohon.min_digits' => 'Nomor HP minimal berisi 10 digit.',

            'tempat_lahir.required'   => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required'  => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required'  => 'Silakan pilih jenis kelamin.',
            'agama.required'          => 'Agama wajib diisi.',
            'pekerjaan.required'      => 'Pekerjaan wajib diisi.',
            'nama_pewaris.required'   => 'Nama pewaris wajib diisi.',
            'alamat.required'         => 'Alamat domisili lengkap wajib diisi.',
            'alamat.min'              => 'Alamat harus ditulis secara lengkap (minimal 10 karakter).',

            // BARU: Pesan error untuk pemohon tambahan
            'pemohon_tambahan.*.nama.required'   => 'Nama ahli waris tambahan wajib diisi.',
            'pemohon_tambahan.*.nik.required'    => 'NIK ahli waris tambahan wajib diisi.',
            'pemohon_tambahan.*.nik.digits'      => 'NIK ahli waris tambahan harus 16 digit.',

            // Pesan Validasi Rekening Bank
            'daftar_rekening.*.nama_bank.required'      => 'Nama bank wajib diisi.',
            'daftar_rekening.*.cabang_bank.required'    => 'Cabang kantor bank wajib diisi.',
            'daftar_rekening.*.nomor_rekening.required' => 'Nomor rekening wajib diisi.',
            'daftar_rekening.*.nomor_rekening.numeric'  => 'Nomor rekening harus berupa angka murni.',
            'daftar_rekening.*.nominal_angka.required'  => 'Nominal tabungan wajib diisi.',
        ];

        // 3. Jalankan Validasi
        $this->validate($rules, $messages);

        // 4. Bersihkan karakter titik (.) dari nominal_angka
        $daftarRekeningCleaned = array_map(function ($rekening) {
            if (isset($rekening['nominal_angka'])) {
                $rekening['nominal_angka'] = (int) str_replace('.', '', $rekening['nominal_angka']);
            }
            return $rekening;
        }, $this->daftar_rekening);

        // 5. Gabungkan seluruh data spesifik menjadi satu struktur array data_spesifik
        $dataSpesifik = [
            'tempat_lahir'     => $this->tempat_lahir,
            'tanggal_lahir'    => $this->tanggal_lahir,
            'jenis_kelamin'    => $this->jenis_kelamin,
            'pekerjaan'        => $this->pekerjaan,
            'agama'            => $this->agama,
            'alamat'           => $this->alamat,
            'nama_pewaris'     => $this->nama_pewaris,
            'daftar_rekening'  => $daftarRekeningCleaned,
            'pemohon_tambahan' => $this->pemohon_tambahan // BARU: Masuk ke JSON database
        ];

        // 6. Masukkan data ke Eloquent Model Permohonan
        Permohonan::create([
            'jenis_naskah'  => 'waarmeking',
            'nama_pemohon'  => $this->nama_pemohon, // Pemohon 1 / Perwakilan
            'nik_pemohon'   => $this->nik_pemohon,
            'no_hp_pemohon' => $this->no_hp_pemohon,
            'data_spesifik' => $dataSpesifik,
            'status'        => 'tunda'
        ]);

        // 7. Tampilkan notifikasi sukses dan reset form
        $this->dispatch('permohonan-sukses', nama: $this->nama_pemohon);
        
        $this->reset(); 
        $this->mount();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.form-waarmeking.form-permohonan');
    }
}