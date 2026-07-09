<?php

namespace App\Livewire\TidakPernahDipidana;

use App\Models\SuratKuasa;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;

class FormSuratKuasa extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $suratKuasaId;
    public $isCreating = false;

    // Properti Pencarian
    public string $search = '';
    
    // Properti khusus untuk Surat Kuasa Tidak Pernah Dipidana
    public $no_hp_pemohon;
    public $jenis_kuasa = 'tidak_pernah_dipidana'; // Terkunci otomatis ke tipe baru
    
    // Penampung data dinamis (Form Repeater)
    public $pemberi_kuasa = [];
    public $penerima_kuasa = [];
    
    public function render()
    {
        // Mengambil data surat kuasa khusus tipe 'tidak_pernah_dipidana' dengan relasinya
        $daftar_surat_kuasa = SuratKuasa::with(['pemberiKuasa', 'penerimaKuasa'])
            ->where('jenis_kuasa', 'tidak_pernah_dipidana')
            ->where(function ($query) {
                $query->whereHas('pemberiKuasa', function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('nik', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('penerimaKuasa', function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10); // Menampilkan 10 data per halaman

        return view('livewire.tidak-pernah-dipidana.surat-kuasa.index', [
            'daftar_surat_kuasa' => $daftar_surat_kuasa
        ]);
    }

    public function mount()
    {
        // 1. HUBUNGKAN DI SINI: Jika URL mengandung kata 'pdf', langsung panggil fungsinya
        if (request()->route('id') && request()->is('*pdf*')) { 
            $this->bikinPdfStream(request()->route('id')); 
        }

        // 2. Logika deteksi mode tambah / edit Anda yang sudah berjalan sebelumnya
        if (request()->is('*tambah')) {
            $this->isCreating = true;
            $this->suratKuasaId = null;
            $this->inisialisasiFormKosong();
        } 
        elseif (request()->route('id') && request()->is('*edit*')) {
            $this->isCreating = true;
            $this->suratKuasaId = request()->route('id');
            $this->isiDataKeForm($this->suratKuasaId);
        } 
        else {
            $this->isCreating = false;
        }
    }

    /**
     * Menginisialisasi baris pertama form repeater dengan data kosong
     */
    public function inisialisasiFormKosong()
    {
        $this->no_hp_pemohon = '';
        
        // Buat minimal 1 baris kosong untuk Pemberi Kuasa
        $this->pemberi_kuasa = [
            [
                'nama' => '', 
                'nik' => '', 
                'jenis_kelamin' => '', 
                'agama' => '', 
                'pekerjaan' => '', 
                'alamat' => '', 
                'urutan_ahli_waris' => null // Dipaksa null untuk case ini
            ]
        ];

        // Buat minimal 1 baris kosong untuk Penerima Kuasa
        $this->penerima_kuasa = [
            [
                'nama' => '', 
                'nik' => '', 
                'jenis_kelamin' => '', 
                'agama' => '', 
                'pekerjaan' => '', 
                'alamat' => '', 
                'urutan_ahli_waris' => null // Dipaksa null untuk case ini
            ]
        ];
    }

    /**
     * Mengambil data dari database dan memasukkannya ke dalam form properti Livewire
     */
    public function isiDataKeForm($id)
    {
        // Ambil data surat kuasa beserta relasi pemberi dan penerimanya
        $surat = SuratKuasa::with(['pemberiKuasa', 'penerimaKuasa'])
            ->where('jenis_kuasa', 'tidak_pernah_dipidana')
            ->findOrFail($id);

        $this->suratKuasaId = $surat->id;
        $this->no_hp_pemohon = $surat->no_hp_pemohon;
        
        // Sinkronisasi data relasi ke dalam array array biasa (toArray) agar terbaca oleh form repeater
        $this->pemberi_kuasa = $surat->pemberiKuasa->toArray();
        $this->penerima_kuasa = $surat->penerimaKuasa->toArray();
    }

    public function tambahPemberi()
    {
        $this->pemberi_kuasa[] = [
            'nama' => '', 
            'nik' => '', 
            'jenis_kelamin' => '', 
            'agama' => '', 
            'pekerjaan' => '', 
            'alamat' => '',
            'urutan_ahli_waris' => null, // Tetap sediakan struktur kolom dengan nilai null
        ];
    }

    public function hapusPemberi($index)
    {
        // Pastikan baris form tidak habis (minimal sisa 1)
        if (count($this->pemberi_kuasa) > 1) {
            unset($this->pemberi_kuasa[$index]);
            // Reset index array agar berurutan kembali (0, 1, 2, dst)
            $this->pemberi_kuasa = array_values($this->pemberi_kuasa);
            
            // NOTE: Loop pengisian 'Ahli Waris' dihapus karena kasus ini tidak menggunakan silsilah
        }
    }

    public function tambahPenerima()
    {
        $this->penerima_kuasa[] = [
            'nama' => '', 
            'nik' => '', 
            'jenis_kelamin' => '', 
            'agama' => '', 
            'pekerjaan' => '', 
            'alamat' => '',
            'urutan_ahli_waris' => null, // Samakan kolomnya dengan pemberi
        ];
    }

    public function hapusPenerima($index)
    {
        // Pastikan baris form tidak habis (minimal sisa 1)
        if (count($this->penerima_kuasa) > 1) {
            unset($this->penerima_kuasa[$index]);
            // Reset index array agar berurutan kembali (0, 1, 2, dst)
            $this->penerima_kuasa = array_values($this->penerima_kuasa);
            
            // NOTE: Loop pengisian 'Penerima Kuasa' atau 'status_penerima' dihapus demi kebersihan database
        }
    }

    public function save()
    {
        // 1. JALANKAN VALIDASI (Tanpa sifat_perkara)
        $this->validate([
            'no_hp_pemohon' => 'required|numeric',
            
            // Validasi Pemberi Kuasa
            'pemberi_kuasa.*.nama' => 'required',
            'pemberi_kuasa.*.nik' => 'required|numeric|digits:16',
            'pemberi_kuasa.*.jenis_kelamin' => 'required',
            
            // Validasi Penerima Kuasa
            'penerima_kuasa.*.nama' => 'required',
            'penerima_kuasa.*.nik' => 'required|numeric|digits:16',
        ], [
            'no_hp_pemohon.required' => 'Nomor HP wajib diisi.',
            
            'pemberi_kuasa.*.nama.required' => 'Nama pemberi kuasa wajib diisi.',
            'pemberi_kuasa.*.nik.required' => 'NIK pemberi kuasa wajib diisi.',
            'pemberi_kuasa.*.nik.digits' => 'NIK pemberi kuasa harus 16 digit.',
            'pemberi_kuasa.*.jenis_kelamin.required' => 'Jenis kelamin pemberi kuasa wajib dipilih.',
            
            'penerima_kuasa.*.nama.required' => 'Nama penerima kuasa wajib diisi.',
            'penerima_kuasa.*.nik.required' => 'NIK penerima kuasa wajib diisi.',
            'penerima_kuasa.*.nik.digits' => 'NIK penerima kuasa harus 16 digit.',
        ]);
        
        // 2. LOGIKA PINDAH CABANG: UPDATE ATAU CREATE INDUK
        if ($this->suratKuasaId) {
            $suratKuasa = \App\Models\SuratKuasa::findOrFail($this->suratKuasaId);
            $suratKuasa->update([
                'jenis_kuasa'   => $this->jenis_kuasa, // Bernilai 'tidak_pernah_dipidana'
                'no_hp_pemohon' => $this->no_hp_pemohon,
                // 'sifat_perkara' tidak disimpan karena kolomnya tidak dipakai/diisi null
            ]);

            // Bersihkan data relasi lama sebelum disimpan ulang
            $suratKuasa->pemberiKuasa()->delete();
            $suratKuasa->penerimaKuasa()->delete();

            session()->flash('success', 'Data Surat Kuasa Keterangan Tidak Pernah Dipidana berhasil diperbarui.');
        } else {
            $suratKuasa = \App\Models\SuratKuasa::create([
                'jenis_kuasa'   => $this->jenis_kuasa,
                'no_hp_pemohon' => $this->no_hp_pemohon,
            ]);

            session()->flash('success', 'Data Surat Kuasa Keterangan Tidak Pernah Dipidana berhasil didaftarkan.');
        }

        // 3. SIMPAN DATA ANAK
        foreach ($this->pemberi_kuasa as $pemberi) {
            $suratKuasa->pemberiKuasa()->create($pemberi);
        }

        foreach ($this->penerima_kuasa as $penerima) {
            $suratKuasa->penerimaKuasa()->create($penerima);
        }

        // 4. DISPATCH EVENT SUKSES & REDIRECT KE LAYANAN TERKAIT
        $this->dispatch('permohonan-sukses', nama: $this->pemberi_kuasa[0]['nama']);
        $this->redirect('/surat-kuasa/tidak-dipidana', navigate: true);
    }

    private function bikinPdfStream($id)
    {
        // Ambil data dari database beserta relasinya
        $suratKuasa = SuratKuasa::with(['pemberiKuasa', 'penerimaKuasa'])
            ->where('jenis_kuasa', 'tidak_pernah_dipidana')
            ->findOrFail($id);
        
        $namaPemohon = $suratKuasa->pemberiKuasa->first()?->nama ?? 'Surat_Kuasa';

        // 1. Buat instance DomPDF secara manual diarahkan ke view template baru pidana
        $pdf = Pdf::loadView('exports.pdf-surat-kuasa-tidak-pernah-dipidana', [
            'data'         => $suratKuasa,
            'fontSize'     => '12pt',
            'lineHeight'   => '1.5',
            'tableSpacing' => '15px'
        ])->setPaper('legal', 'portrait');

        // 2. Bersihkan output buffer bawaan PHP/Livewire agar tidak corrupt
        if (ob_get_contents()) ob_end_clean();

        // 3. Kirim Header HTTP Native ke Browser
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="Preview_Surat_Kuasa_Pidana_'.str_replace(' ', '_', $namaPemohon).'.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        // 4. Keluarkan isi PDF dan paksa hentikan script PHP saat itu juga
        echo $pdf->output();
        exit;
    }

    public function bikinWordDownload($id)
    {
        // 1. Ambil data dari database beserta relasinya
        $suratKuasa = SuratKuasa::with(['pemberiKuasa', 'penerimaKuasa'])
            ->where('jenis_kuasa', 'tidak_pernah_dipidana')
            ->findOrFail($id);
        
        $namaPemohon = $suratKuasa->pemberiKuasa->first()?->nama ?? 'Surat_Kuasa';

        // =========================================================================
        // TRIK OTOMATISASI UKURAN FONT & SPASI BERDASARKAN JUMLAH ORANG
        // =========================================================================
        $jumlahPemberi = $suratKuasa->pemberiKuasa->count();
        $jumlahPenerima = $suratKuasa->penerimaKuasa->count();
        $totalOrang = $jumlahPemberi + $jumlahPenerima;

        // Nilai Default (Sangat aman untuk dokumen standar yang pendek/sedikit orang)
        $fontSize = '12pt';
        $lineHeight = '1.5';
        $tableSpacing = '15px';

        if ($totalOrang >= 3 && $totalOrang <= 5) {
            $fontSize = '11pt';
            $lineHeight = '1.3';
            $tableSpacing = '10px';
        } elseif ($totalOrang > 5) {
            $fontSize = '11.5pt';
            $lineHeight = '1.4';
            $tableSpacing = '12px';
        }

        // 2. Render view Blade PDF menjadi string HTML murni (Menggunakan file blade pidana)
        $htmlContent = view('exports.pdf-surat-kuasa-tidak-pernah-dipidana', [
            'data'         => $suratKuasa,
            'fontSize'     => $fontSize,
            'lineHeight'   => $lineHeight,
            'tableSpacing' => $tableSpacing
        ])->render();

        // 3. Bungkus HTML dengan XML dokumen Word agar dibaca resmi sebagai halaman F4/Folio Portrait oleh MS Word
        $wordDocument = "
        <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
        <head>
            <title>Export Surat Kuasa Pidana Word</title>
            <style>
                @page Section1 {
                    size: 21.5cm 33.0cm;
                    margin: 1.5cm 2cm 1.5cm 2.5cm;
                }
                div.Section1 {
                    page: Section1;
                }
            </style>
        </head>
        <body>
            <div class='Section1'>
                {$htmlContent}
            </div>
        </body>
        </html>";

        // 4. Bersihkan output buffer bawaan PHP/Livewire agar file .doc tidak corrupt
        if (ob_get_contents()) ob_end_clean();

        // 5. Stream ke browser untuk langsung download berkas .doc dengan nama format baru
        $filename = 'Surat_Kuasa_Pidana_' . str_replace(' ', '_', $namaPemohon) . '.doc';

        return response($wordDocument, 200, [
            'Content-Type'        => 'application/msword',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'private, max-age=0, must-revalidate',
            'Pragma'              => 'public',
        ]);
    }

    // Reset halaman jika kata kunci pencarian berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function destroy($id): void
    {
        // Cari data surat kuasa berdasarkan ID
        $suratKuasa = SuratKuasa::findOrFail($id);
        
        // Hapus data dari database (Otomatis menghapus data anak karena DB Cascade)
        $suratKuasa->delete();

        // Kirim notifikasi sukses menggunakan Flash Session bawaan Laravel
        session()->flash('success', 'Data Surat Kuasa berhasil dihapus dari sistem TRITON.');

        // Refresh halaman secara halus agar tabel langsung ter-update otomatis
        $this->redirect('/surat-kuasa/tidak-dipidana', navigate: true);
    }
}