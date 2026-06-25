<?php

namespace App\Livewire\FormWaarmeking;

use App\Models\Permohonan;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;
use Livewire\WithPagination;

class FormPermohonan extends Component
{
    use WithPagination; // 2. Gunakan Trait di dalam Class

    // Properti khusus Pagination (Menggunakan styling Bootstrap)
    protected $paginationTheme = 'bootstrap';

    // 3. Properti untuk menampung kata kunci pencarian
    public string $search = '';
    
    // Pengontrol Tampilan Halaman (Tabel vs Form)
    public bool $isCreating = false;

    // Properti baru untuk menyimpan ID saat mode EDIT
    public ?int $permohonanId = null;

    // 1. Data Utama Pemohon (Berperan sebagai Pemohon Utama / Perwakilan)
    public string $nama_pemohon = '';
    public string $nik_pemohon = '';
    public string $no_hp_pemohon = '';

    // Array Dinamis untuk menampung data banyak pemohon/ahli waris tambahan
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
    
    public function mount($id = null)
    {
        // 1. Logika Stream PDF Anda yang lama tetap di paling atas
        if ($id && request()->is('*pdf*')) { 
            $this->bikinPdfStream($id);
        }

        // 2. LOGIKA DETEKSI MODE: TAMBAH ATAU EDIT
        if (request()->is('*tambah')) {
            $this->isCreating = true;
            $this->permohonanId = null;
            $this->inisialisasiFormKosong();
        } 
        elseif (request()->route('id') && request()->is('*edit*')) {
            // Jika rute mengandung ID dan berada di URL edit
            $this->isCreating = true;
            $this->permohonanId = request()->route('id');
            $this->isiDataKeForm($this->permohonanId); // Muat data lama ke form
        } 
        else {
            $this->isCreating = false;
        }
    }

    // Fungsi untuk menambah baris pemohon tambahan (Dijalankan saat tombol "+ Tambah Ahli Waris" diklik)
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
        // Livewire mengirimkan key berformat "index.nama_kolom", contoh: "0.nominal_angka"
        if (str_contains($key, '.nominal_angka')) {
            $parts = explode('.', $key);
            $index = (int)$parts[0]; // Mendapatkan index array (0, 1, 2, dst)
            
            if ($value !== '' && $value !== null) {
                // Bersihkan jika user memasukkan format titik/koma pemisah ribuan
                $angkaHanyaDigit = str_replace(['.', ','], '', $value);
                $angkaClean = (int)$angkaHanyaDigit;
                
                // Set terbilang, lalu rapikan spasi berlebih dengan trim()
                $this->daftar_rekening[$index]['nominal_huruf'] = trim($this->terbilang($angkaClean)) . ' Rupiah';
            } else {
                $this->daftar_rekening[$index]['nominal_huruf'] = '';
            }
        }
    }

    private function terbilang(int $angka): string
    {
        $angka = abs($angka);
        $baca = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        
        if ($angka < 12) {
            return " " . $baca[$angka];
        } elseif ($angka < 20) {
            return $this->terbilang($angka - 10) . " Belas";
        } elseif ($angka < 100) {
            return $this->terbilang((int)($angka / 10)) . " Puluh" . $this->terbilang($angka % 10); // <-- Tambahkan (int)
        } elseif ($angka < 200) {
            return " Seratus" . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return $this->terbilang((int)($angka / 100)) . " Ratus" . $this->terbilang($angka % 100); // <-- Tambahkan (int)
        } elseif ($angka < 2000) {
            return " Seribu" . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return $this->terbilang((int)($angka / 1000)) . " Ribu" . $this->terbilang($angka % 1000); // <-- Tambahkan (int)
        } elseif ($angka < 1000000000) {
            return $this->terbilang((int)($angka / 1000000)) . " Juta" . $this->terbilang($angka % 1000000); // <-- Tambahkan (int)
        }
        
        return "";
    }

    // Fungsi pembantu untuk set form awal jika data baru
    private function inisialisasiFormKosong()
    {
        $this->pemohon_tambahan = [];
        $this->daftar_rekening = [
            ['nama_bank' => '', 'cabang_bank' => '', 'nomor_rekening' => '', 'nominal_angka' => '', 'nominal_huruf' => '']
        ];
    }

    // Fungsi pembantu untuk menarik data lama dari DB ke dalam input form
    private function isiDataKeForm($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $dataSpesifik = $permohonan->data_spesifik;

        $this->nama_pemohon   = $permohonan->nama_pemohon;
        $this->nik_pemohon    = $permohonan->nik_pemohon;
        $this->no_hp_pemohon  = $permohonan->no_hp_pemohon;
        
        $this->tempat_lahir   = $dataSpesifik['tempat_lahir'] ?? '';
        $this->tanggal_lahir  = $dataSpesifik['tanggal_lahir'] ?? '';
        $this->jenis_kelamin  = $dataSpesifik['jenis_kelamin'] ?? 'Laki-laki';
        $this->agama          = $dataSpesifik['agama'] ?? 'Islam';
        $this->pekerjaan      = $dataSpesifik['pekerjaan'] ?? '';
        $this->nama_pewaris   = $dataSpesifik['nama_pewaris'] ?? '';
        $this->alamat         = $dataSpesifik['alamat'] ?? '';
        
        $this->pemohon_tambahan = $dataSpesifik['pemohon_tambahan'] ?? [];
        $this->daftar_rekening  = $dataSpesifik['daftar_rekening'] ?? [];
    }

    // Fungsi Eksekusi ketika Form di-Submit oleh user
    // public function save(): void
    // {
    //     // 1. Definisikan Aturan Validasi untuk Semua Kolom
    //     $rules = [
    //         'nama_pemohon'   => 'required|string|min:3',
    //         'nik_pemohon'    => 'required|numeric|digits:16',
    //         'no_hp_pemohon'  => 'required|numeric|min_digits:10',

    //         'tempat_lahir'   => 'required|string|min:3',
    //         'tanggal_lahir'  => 'required|date',
    //         'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
    //         'agama'          => 'required|string',
    //         'pekerjaan'      => 'required|string',
    //         'nama_pewaris'   => 'required|string|min:3',
    //         'alamat'         => 'required|string|min:10',

    //         'pemohon_tambahan'                    => 'nullable|array',
    //         'pemohon_tambahan.*.nama'             => 'required|string|min:3',
    //         'pemohon_tambahan.*.nik'              => 'required|numeric|digits:16',
    //         'pemohon_tambahan.*.tempat_lahir'     => 'required|string',
    //         'pemohon_tambahan.*.tanggal_lahir'    => 'required|date',
    //         'pemohon_tambahan.*.jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
    //         'pemohon_tambahan.*.agama'            => 'required|string',
    //         'pemohon_tambahan.*.pekerjaan'        => 'required|string',
    //         'pemohon_tambahan.*.alamat'           => 'required|string',

    //         'daftar_rekening'                    => 'required|array|min:1',
    //         'daftar_rekening.*.nama_bank'        => 'required|string',
    //         'daftar_rekening.*.cabang_bank'      => 'required|string',
    //         'daftar_rekening.*.nomor_rekening'   => 'required|numeric',
    //         'daftar_rekening.*.nominal_angka'    => 'required',
    //     ];

    //     // 2. Kustomisasi Pesan Eror Bahasa Indonesia
    //     $messages = [
    //         'nama_pemohon.required'   => 'Nama lengkap pemohon utama wajib diisi.',
    //         'nama_pemohon.min'        => 'Nama lengkap minimal berisi 3 karakter.',
    //         'nik_pemohon.required'    => 'NIK pemohon utama wajib diisi.',
    //         'nik_pemohon.digits'      => 'NIK pemohon utama harus tepat berjumlah 16 digit.',
    //         'nik_pemohon.numeric'     => 'NIK harus berupa angka.',
    //         'no_hp_pemohon.required'  => 'Nomor HP / WhatsApp wajib diisi.',
    //         'no_hp_pemohon.min_digits'=> 'Nomor HP minimal berisi 10 digit.',

    //         'tempat_lahir.required'   => 'Tempat lahir wajib diisi.',
    //         'tanggal_lahir.required'  => 'Tanggal lahir wajib diisi.',
    //         'jenis_kelamin.required'  => 'Silakan pilih jenis kelamin.',
    //         'agama.required'          => 'Agama wajib diisi.',
    //         'pekerjaan.required'      => 'Pekerjaan wajib diisi.',
    //         'nama_pewaris.required'   => 'Nama pewaris wajib diisi.',
    //         'alamat.required'         => 'Alamat domisili lengkap wajib diisi.',
    //         'alamat.min'              => 'Alamat harus ditulis secara lengkap (minimal 10 karakter).',

    //         'pemohon_tambahan.*.nama.required'   => 'Nama ahli waris tambahan wajib diisi.',
    //         'pemohon_tambahan.*.nik.required'    => 'NIK ahli waris tambahan wajib diisi.',
    //         'pemohon_tambahan.*.nik.digits'      => 'NIK ahli waris tambahan harus 16 digit.',

    //         'daftar_rekening.*.nama_bank.required'      => 'Nama bank wajib diisi.',
    //         'daftar_rekening.*.cabang_bank.required'    => 'Cabang kantor bank wajib diisi.',
    //         'daftar_rekening.*.nomor_rekening.required' => 'Nomor rekening wajib diisi.',
    //         'daftar_rekening.*.nomor_rekening.numeric'  => 'Nomor rekening harus berupa angka murni.',
    //         'daftar_rekening.*.nominal_angka.required'  => 'Nominal tabungan wajib diisi.',
    //     ];

    //     // 3. Jalankan Validasi
    //     $this->validate($rules, $messages);

    //     // 4. Bersihkan karakter titik (.) dari nominal_angka
    //     $daftarRekeningCleaned = array_map(function ($rekening) {
    //         if (isset($rekening['nominal_angka'])) {
    //             $rekening['nominal_angka'] = (int) str_replace('.', '', $rekening['nominal_angka']);
    //         }
    //         return $rekening;
    //     }, $this->daftar_rekening);

    //     // 5. Gabungkan seluruh data spesifik menjadi satu struktur array data_spesifik
    //     $dataSpesifik = [
    //         'tempat_lahir'     => $this->tempat_lahir,
    //         'tanggal_lahir'    => $this->tanggal_lahir,
    //         'jenis_kelamin'    => $this->jenis_kelamin,
    //         'pekerjaan'        => $this->pekerjaan,
    //         'agama'            => $this->agama,
    //         'alamat'           => $this->alamat,
    //         'nama_pewaris'     => $this->nama_pewaris,
    //         'daftar_rekening'  => $daftarRekeningCleaned,
    //         'pemohon_tambahan' => $this->pemohon_tambahan 
    //     ];

    //     // 6. Masukkan data ke Eloquent Model Permohonan
    //     $permohonan = Permohonan::create([
    //         'jenis_naskah'  => 'waarmeking',
    //         'nama_pemohon'  => $this->nama_pemohon, 
    //         'nik_pemohon'   => $this->nik_pemohon,
    //         'no_hp_pemohon' => $this->no_hp_pemohon,
    //         'data_spesifik' => $dataSpesifik, 
    //     ]);

    //     // 7. MODIFIKASI: Gunakan Flash Session untuk membawa sinyal sukses + ID ke halaman Index
    //     // (Karena halaman dialihkan, browser butuh mengingat ini setelah halaman termuat ulang)
    //     session()->flash('success', 'Permohonan Waarmeking berhasil didaftarkan.');
    //     session()->flash('cetak_id', $permohonan->id);
    //     session()->flash('cetak_nama', $this->nama_pemohon);
        
    //     // 8. REDIRECT: Lempar user kembali ke halaman tabel index utama TRITON
    //     $this->redirect('/permohonan/waarmeking', navigate: true);
    // }

    public function save(): void
    {
        // ATURAN VALIDASI (Sama persis seperti kode validasi Anda yang kemarin)
        $rules = [
            'nama_pemohon'   => 'required|string|min:3',
            'nik_pemohon'    => 'required|numeric|digits:16',
            'no_hp_pemohon'  => 'required|numeric|min_digits:10',
            'tempat_lahir'   => 'required|string|min:3',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'agama'          => 'required|string',
            'pekerjaan'      => 'required|string',
            'nama_pewaris'   => 'required|string|min:3',
            'alamat'         => 'required|string|min:10',
            'daftar_rekening' => 'required|array|min:1',
            'daftar_rekening.*.nama_bank'        => 'required|string',
            'daftar_rekening.*.cabang_bank'      => 'required|string',
            'daftar_rekening.*.nomor_rekening'   => 'required|numeric',
            'daftar_rekening.*.nominal_angka'    => 'required',
        ];
        
        $this->validate($rules);

        // Bersihkan titik nominal angka
        $daftarRekeningCleaned = array_map(function ($rekening) {
            if (isset($rekening['nominal_angka'])) {
                $rekening['nominal_angka'] = (int) str_replace('.', '', $rekening['nominal_angka']);
            }
            return $rekening;
        }, $this->daftar_rekening);

        $dataSpesifik = [
            'tempat_lahir'     => $this->tempat_lahir,
            'tanggal_lahir'    => $this->tanggal_lahir,
            'jenis_kelamin'    => $this->jenis_kelamin,
            'pekerjaan'        => $this->pekerjaan,
            'agama'            => $this->agama,
            'alamat'           => $this->alamat,
            'nama_pewaris'     => $this->nama_pewaris,
            'daftar_rekening'  => $daftarRekeningCleaned,
            'pemohon_tambahan' => $this->pemohon_tambahan 
        ];

        // LOGIKA PINDAH CABANG: UPDATE ATAU CREATE
        if ($this->permohonanId) {
            // JIKA SEDANG MODE EDIT -> UPDATE DATA LAMA
            $permohonan = Permohonan::findOrFail($this->permohonanId);
            $permohonan->update([
                'nama_pemohon'  => $this->nama_pemohon, 
                'nik_pemohon'   => $this->nik_pemohon,
                'no_hp_pemohon' => $this->no_hp_pemohon,
                'data_spesifik' => $dataSpesifik,
            ]);
            session()->flash('success', 'Permohonan Waarmeking berhasil diperbarui.');
        } else {
            // JIKA DATA BARU -> CREATE SEPERTI BIASA
            $permohonan = Permohonan::create([
                'jenis_naskah'  => 'waarmeking',
                'nama_pemohon'  => $this->nama_pemohon, 
                'nik_pemohon'   => $this->nik_pemohon,
                'no_hp_pemohon' => $this->no_hp_pemohon,
                'data_spesifik' => $dataSpesifik, 
                'status'        => 'tunda'
            ]);
            session()->flash('success', 'Permohonan Waarmeking berhasil didaftarkan.');
            session()->flash('cetak_id', $permohonan->id);
            session()->flash('cetak_nama', $this->nama_pemohon);
        }

        $this->redirect('/permohonan/waarmeking', navigate: true);
    }

    private function bikinPdfStream($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $dataSpesifik = $permohonan->data_spesifik;

        $daftarRekeningCleaned = array_map(function ($rekening) {
            if (isset($rekening['nominal_angka'])) {
                $rekening['nominal_huruf'] = $this->terbilang((int)$rekening['nominal_angka']) . " Rupiah";
            }
            return $rekening;
        }, $dataSpesifik['daftar_rekening'] ?? []);

        // =========================================================================
        // TRIK OTOMATISASI UKURAN FONT & SPASI AGAR PAS 1 HALAMAN / TIDAK NANGGUNG
        // =========================================================================
        $jumlahRekening = count($daftarRekeningCleaned);
        $jumlahAhliWaris = count($dataSpesifik['pemohon_tambahan'] ?? []);
        $totalBarisDinamis = $jumlahRekening + $jumlahAhliWaris;

        // Nilai Default (Sangat aman untuk dokumen standar yang pendek)
        $fontSize = '12pt';
        $lineHeight = '1.5';
        $tableSpacing = '15px';

        if ($totalBarisDinamis >= 3 && $totalBarisDinamis <= 5) {
            // Data mulai agak padat, ciutkan sedikit agar dipaksa muat 1 halaman
            $fontSize = '11pt';
            $lineHeight = '1.3';
            $tableSpacing = '10px';
        } elseif ($totalBarisDinamis > 5) {
            // Data terlalu banyak, tidak mungkin dipaksa 1 halaman. 
            // Set ukuran sedang agar melebar ke halaman 2 dengan rapi (tidak nanggung)
            $fontSize = '11.5pt';
            $lineHeight = '1.4';
            $tableSpacing = '12px';
        }

        // PASTIKAN SEMUA DATA DI BAWAH INI TERKIRIM KE BLADE PDF
        $pdf = Pdf::loadView('exports.pdf-permohonan-waarmeking', [
            'nama_pemohon'     => $permohonan->nama_pemohon,
            'tempat_lahir'     => $dataSpesifik['tempat_lahir'] ?? '',
            'tanggal_lahir'    => $dataSpesifik['tanggal_lahir'] ?? '',
            'jenis_kelamin'    => $dataSpesifik['jenis_kelamin'] ?? '',
            'pekerjaan'        => $dataSpesifik['pekerjaan'] ?? '',
            'agama'            => $dataSpesifik['agama'] ?? '',
            'alamat'           => $dataSpesifik['alamat'] ?? '',
            'nama_pewaris'     => $dataSpesifik['nama_pewaris'] ?? '',
            'daftar_rekening'  => $daftarRekeningCleaned,
            'pemohon_tambahan' => $dataSpesifik['pemohon_tambahan'] ?? [],
            
            // Oper variabel styling baru ke Blade PDF Anda
            'fontSize'         => $fontSize,
            'lineHeight'       => $lineHeight,
            'tableSpacing'     => $tableSpacing
        ])->setPaper('a4', 'portrait');

        // Kembalikan response berupa stream
        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Preview_Waarmeking_'.$permohonan->nama_pemohon.'.pdf"',
        ])->send();

        exit;
    }

    public function bikinWordDownload($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $dataSpesifik = $permohonan->data_spesifik;

        $daftarRekeningCleaned = array_map(function ($rekening) {
            if (isset($rekening['nominal_angka'])) {
                $rekening['nominal_huruf'] = $this->terbilang((int)$rekening['nominal_angka']) . " Rupiah";
            }
            return $rekening;
        }, $dataSpesifik['daftar_rekening'] ?? []);

        // 1. Ambil hitungan baris dinamis yang sama persis seperti versi PDF
        $jumlahRekening = count($daftarRekeningCleaned);
        $jumlahAhliWaris = count($dataSpesifik['pemohon_tambahan'] ?? []);
        $totalBarisDinamis = $jumlahRekening + $jumlahAhliWaris;

        $fontSize = '12pt';
        $lineHeight = '1.5';
        $tableSpacing = '15px';

        if ($totalBarisDinamis >= 3 && $totalBarisDinamis <= 5) {
            $fontSize = '11pt';
            $lineHeight = '1.3';
            $tableSpacing = '10px';
        } elseif ($totalBarisDinamis > 5) {
            $fontSize = '11.5pt';
            $lineHeight = '1.4';
            $tableSpacing = '12px';
        }

        // 2. Render view Blade PDF Anda menjadi string HTML murni (Gunakan file blade yang sama persis!)
        $htmlContent = view('exports.pdf-permohonan-waarmeking', [
            'nama_pemohon'     => $permohonan->nama_pemohon,
            'tempat_lahir'     => $dataSpesifik['tempat_lahir'] ?? '',
            'tanggal_lahir'    => $dataSpesifik['tanggal_lahir'] ?? '',
            'jenis_kelamin'    => $dataSpesifik['jenis_kelamin'] ?? '',
            'pekerjaan'        => $dataSpesifik['pekerjaan'] ?? '',
            'agama'            => $dataSpesifik['agama'] ?? '',
            'alamat'           => $dataSpesifik['alamat'] ?? '',
            'nama_pewaris'     => $dataSpesifik['nama_pewaris'] ?? '',
            'daftar_rekening'  => $daftarRekeningCleaned,
            'pemohon_tambahan' => $dataSpesifik['pemohon_tambahan'] ?? [],
            'fontSize'         => $fontSize,
            'lineHeight'       => $lineHeight,
            'tableSpacing'     => $tableSpacing
        ])->render();

        // 3. Bungkus HTML dengan XML dokumen Word agar dibaca resmi sebagai halaman Portrait A4 oleh MS Word
        $wordDocument = "
        <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
        <head>
            <title>Export Word</title>
            </head>
        <body>
            <div class='Section1'>
                {$htmlContent}
            </div>
        </body>
        </html>";

        // 4. Stream ke browser untuk langsung download berkas .doc/.docx
        $filename = 'Permohonan_Waarmeking_' . $permohonan->nama_pemohon . '.doc';

        return response($wordDocument, 200, [
            'Content-Type' => 'application/msword',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'private, max-age=0, must-revalidate',
        ]);
    }

    public function destroy($id): void
    {
        // Cari data permohonan berdasarkan ID
        $permohonan = Permohonan::findOrFail($id);
        
        // Hapus data dari database
        $permohonan->delete();

        // Kirim notifikasi sukses menggunakan Flash Session bawaan Laravel
        session()->flash('success', 'Permohonan Waarmeking berhasil dihapus dari sistem.');

        // Refresh halaman secara halus agar tabel langsung ter-update otomatis
        $this->redirect('/permohonan/waarmeking', navigate: true);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // #[Layout('layouts.app')]
    // public function render()
    // {
    //     $daftar_waarmeking = Permohonan::where('jenis_naskah', 'waarmeking')
    //                                     ->latest()
    //                                     ->get();

    //     return view('livewire.form-waarmeking.permohonan.index', [
    //         'daftar_waarmeking' => $daftar_waarmeking
    //     ]);
    // }

    public function render()
    {
        // 5. Modifikasi query untuk memfilter data berdasarkan pencarian dan membaginya per halaman
        $daftar_waarmeking = Permohonan::where('jenis_naskah', 'waarmeking')
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('nama_pemohon', 'like', '%' . $this->search . '%')
                      ->orWhere('nik_pemohon', 'like', '%' . $this->search . '%')
                      ->orWhere('no_hp_pemohon', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10); // Menampilkan 10 data per halaman (bisa diubah sesuai kebutuhan)

        return view('livewire.form-waarmeking.permohonan.index', [
            'daftar_waarmeking' => $daftar_waarmeking
        ]);
    }
}