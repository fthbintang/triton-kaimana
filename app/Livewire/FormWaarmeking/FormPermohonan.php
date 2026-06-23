<?php

namespace App\Livewire\FormWaarmeking;

use App\Models\Permohonan;
use Livewire\Component;
use Livewire\Attributes\Layout;

class FormPermohonan extends Component
{
    // 1. Data Utama Pemohon
    public string $nama_pemohon = '';
    public string $nik_pemohon = '';
    public string $no_hp_pemohon = '';

    // 2. Data Spesifik Waarmeking
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
    public ?string $pesan_sukses = null; // Tanda tanya (?) artinya boleh kosong/null

    // Fungsi bawaan Livewire yang otomatis berjalan saat form pertama kali dibuka
    public function mount(): void
    {
        // Nilai awal diubah menjadi string kosong agar form bersih tidak ada angka 0
        $this->daftar_rekening = [
            [
                'nama_bank' => '',
                'cabang_bank' => '',
                'nomor_rekening' => '',
                'nominal_angka' => '', // <-- Ubah dari 0 menjadi ''
                'nominal_huruf' => ''
            ]
        ];
    }

    // Fungsi untuk menambah baris bank baru (Dijalankan saat tombol "+ Tambah Bank" diklik)
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

    // Fungsi untuk menghapus baris bank jika pengguna salah klik atau kelebihan
    public function hapusBank(int $index): void
    {
        unset($this->daftar_rekening[$index]);
        $this->daftar_rekening = array_values($this->daftar_rekening); // Reset susunan index array agar terurut kembali
    }

    // Mengawasi perubahan ketikan angka secara real-time untuk diubah ke teks huruf terbilang
    public function updatedDaftarRekening(mixed $value, string $key): void
    {
        if (str_contains($key, '.nominal_angka')) {
            $parts = explode('.', $key);
            $index = (int)$parts[0];
            
            // JIKA USER MENGINPUT SESUATU
            if ($value !== '' && $value !== null) {
                // Hilangkan semua tanda titik (.) yang diketik oleh javascript format uang
                $angkaHanyaDigit = str_replace('.', '', $value);
                $angkaClean = (int)$angkaHanyaDigit;
                
                // Set teks terbilang otomatis
                $this->daftar_rekening[$index]['nominal_huruf'] = $this->terbilang($angkaClean) . ' Rupiah';
            } else {
                // Jika dikosongkan total oleh user
                $this->daftar_rekening[$index]['nominal_huruf'] = '';
            }
        }
    }

    // Rumus Matematika Helper untuk mengubah Angka menjadi Teks Huruf Terbilang Indonesia
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
            // Validasi Data Utama Pemohon
            'nama_pemohon'   => 'required|string|min:3',
            'nik_pemohon'    => 'required|numeric|digits:16',
            'no_hp_pemohon'  => 'required|numeric|min_digits:10',

            // Validasi Data Detail Pemohon & Pewaris
            'tempat_lahir'   => 'required|string|min:3',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'agama'          => 'required|string',
            'pekerjaan'      => 'required|string',
            'nama_pewaris'   => 'required|string|min:3',
            'alamat'         => 'required|string|min:10',

            // Validasi Dinamis untuk Array Daftar Rekening Bank
            'daftar_rekening'                    => 'required|array|min:1',
            'daftar_rekening.*.nama_bank'        => 'required|string',
            'daftar_rekening.*.cabang_bank'      => 'required|string',
            'daftar_rekening.*.nomor_rekening'   => 'required|numeric',
            'daftar_rekening.*.nominal_angka'    => 'required',
        ];

        // 2. Kustomisasi Pesan Eror Bahasa Indonesia untuk Semua Kolom
        $messages = [
            // Pesan Data Utama
            'nama_pemohon.required'   => 'Nama lengkap pemohon wajib diisi.',
            'nama_pemohon.min'        => 'Nama lengkap minimal berisi 3 karakter.',
            'nik_pemohon.required'    => 'NIK wajib diisi sesuai KTP.',
            'nik_pemohon.digits'      => 'NIK harus tepat berjumlah 16 digit.',
            'nik_pemohon.numeric'     => 'NIK harus berupa angka.',
            'no_hp_pemohon.required'  => 'Nomor HP / WhatsApp wajib diisi.',
            'no_hp_pemohon.min_digits' => 'Nomor HP minimal berisi 10 digit.',

            // Pesan Data Detail & Pewaris
            'tempat_lahir.required'   => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required'  => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required'  => 'Silakan pilih jenis kelamin.',
            'agama.required'          => 'Agama wajib diisi.',
            'pekerjaan.required'      => 'Pekerjaan wajib diisi.',
            'nama_pewaris.required'   => 'Nama pewaris wajib diisi.',
            'alamat.required'         => 'Alamat domisili lengkap wajib diisi.',
            'alamat.min'              => 'Alamat harus ditulis secara lengkap (minimal 10 karakter).',

            // Pesan Validasi Rekening Bank (Dinamis memakai tanda bintang *)
            'daftar_rekening.*.nama_bank.required'      => 'Nama bank wajib diisi.',
            'daftar_rekening.*.cabang_bank.required'    => 'Cabang kantor bank wajib diisi.',
            'daftar_rekening.*.nomor_rekening.required' => 'Nomor rekening wajib diisi.',
            'daftar_rekening.*.nomor_rekening.numeric'  => 'Nomor rekening harus berupa angka murni.',
            'daftar_rekening.*.nominal_angka.required'  => 'Nominal tabungan wajib diisi.',
        ];

        // 3. Jalankan Validasi
        $this->validate($rules, $messages);

        // 4. Bersihkan karakter titik (.) dari nominal_angka sebelum disimpan ke JSON database
        $daftarRekeningCleaned = array_map(function ($rekening) {
            if (isset($rekening['nominal_angka'])) {
                $rekening['nominal_angka'] = (int) str_replace('.', '', $rekening['nominal_angka']);
            }
            return $rekening;
        }, $this->daftar_rekening);

        // 5. Gabungkan seluruh data spesifik menjadi satu struktur array data_spesifik
        $dataSpesifik = [
            'tempat_lahir'    => $this->tempat_lahir,
            'tanggal_lahir'   => $this->tanggal_lahir,
            'jenis_kelamin'   => $this->jenis_kelamin,
            'pekerjaan'       => $this->pekerjaan,
            'agama'           => $this->agama,
            'alamat'          => $this->alamat,
            'nama_pewaris'    => $this->nama_pewaris,
            'daftar_rekening' => $daftarRekeningCleaned
        ];

        // 6. Masukkan data ke Eloquent Model Permohonan
        Permohonan::create([
            'jenis_naskah'  => 'waarmeking',
            'nama_pemohon'  => $this->nama_pemohon,
            'nik_pemohon'   => $this->nik_pemohon,
            'no_hp_pemohon' => $this->no_hp_pemohon,
            'data_spesifik' => $dataSpesifik,
            'status'        => 'tunda'
        ]);

        // 7. Tampilkan notifikasi sukses via SweetAlert2 (mengirim nama pemohon) dan reset form
        $this->dispatch('permohonan-sukses', nama: $this->nama_pemohon);
        
        // Reset seluruh form ke kondisi kosong awal
        $this->reset(); 
        $this->mount();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.form-waarmeking.form-permohonan');
    }
}