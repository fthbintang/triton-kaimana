<?php

namespace App\Livewire\FormKuasaInsidentil;

use App\Models\SuratKuasa;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;
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
    
    public $no_hp_pemohon;
    public $sifat_perkara;
    public $jenis_kuasa = 'kuasa_insidentil';
    public $pemberi_kuasa = [];
    public $penerima_kuasa = [];

    /**
     * MODIFIKASI MOUNT: Agar bisa menerima trigger wire:click dari baris tabel index
     */
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

    // Helper sederhana untuk mengubah angka menjadi Romawi (I, II, III, dst)
    private function keRomawi($angka)
    {
        $map = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X'];
        return $map[$angka] ?? $angka;
    }

    /**
     * HELPER 1: INISIALISASI BARIS KOSONG PERTAMA (TAMBAH DATA)
     */
    private function inisialisasiFormKosong()
    {
        $this->sifat_perkara = '';
        $this->no_hp_pemohon = '';
        
        $this->pemberi_kuasa = [];
        $this->pemberi_kuasa[] = [
            'nama' => '', 
            'nik' => '', 
            'jenis_kelamin' => '', 
            'agama' => '', 
            'pekerjaan' => '', 
            'alamat' => '',
        ];
        
        $this->penerima_kuasa = [];
        $this->penerima_kuasa[] = [
            'nama' => '', 
            'nik' => '', 
            'jenis_kelamin' => '', 
            'agama' => '', 
            'pekerjaan' => '', 
            'alamat' => '',
        ];
    }

    /**
     * HELPER 2: AMBIL DATA LAMA DARI DATABASE (MODE EDIT)
     */
    public function isiDataKeForm($id)
    {
        $suratKuasa = SuratKuasa::with(['pemberiKuasa', 'penerimaKuasa'])
            ->where('jenis_kuasa', 'kuasa_insidentil')
            ->findOrFail($id);
        
        $this->jenis_kuasa = $suratKuasa->jenis_kuasa;
        $this->no_hp_pemohon = $suratKuasa->no_hp_pemohon;
        $this->sifat_perkara = $suratKuasa->sifat_perkara;
        $this->pemberi_kuasa = [];
        $this->penerima_kuasa = [];

        // 1. Memetakan data Pemberi Kuasa (Sudah Sesuai)
        foreach ($suratKuasa->pemberiKuasa as $pemberi) {
            $this->pemberi_kuasa[] = [
                'nama'              => $pemberi->nama,
                'nik'               => $pemberi->nik,
                'jenis_kelamin'     => $pemberi->jenis_kelamin,
                'agama'             => $pemberi->agama,
                'pekerjaan'         => $pemberi->pekerjaan,
                'alamat'            => $pemberi->alamat,
            ];
        }

        // 2. Memetakan data Penerima Kuasa (DISESUAIKAN)
        foreach ($suratKuasa->penerimaKuasa as $penerima) {
            $this->penerima_kuasa[] = [
                'nama'              => $penerima->nama,
                'nik'               => $penerima->nik,
                'jenis_kelamin'     => $penerima->jenis_kelamin,
                'agama'             => $penerima->agama,
                'pekerjaan'         => $penerima->pekerjaan,
                'alamat'            => $penerima->alamat,
            ];
        }
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
        ];
    }

    public function hapusPemberi($index)
    {
        if (count($this->pemberi_kuasa) > 1) {
            unset($this->pemberi_kuasa[$index]);
            $this->pemberi_kuasa = array_values($this->pemberi_kuasa);
            
            foreach ($this->pemberi_kuasa as $key => $value) {
                $this->pemberi_kuasa[$key]['urutan_ahli_waris'] = 'Ahli Waris ' . ($key + 1);
            }
        }
    }

    public function tambahPenerima()
    {
        $this->penerima_kuasa[] = [
            'nama' => '', 'nik' => '', 'jenis_kelamin' => '', 
            'agama' => '', 'pekerjaan' => '', 'alamat' => ''
        ];
    }

    public function hapusPenerima($index)
    {
        if (count($this->penerima_kuasa) > 1) {
            unset($this->penerima_kuasa[$index]);
            $this->penerima_kuasa = array_values($this->penerima_kuasa);
            
            foreach ($this->penerima_kuasa as $key => $value) {
                $this->penerima_kuasa[$key]['status_penerima'] = 'Penerima Kuasa ' . ($key + 1);
            }
        }
    }

    public function save()
    {
        // 1. JALANKAN VALIDASI
        $this->validate([
            'no_hp_pemohon' => 'required|numeric',
            'sifat_perkara' => 'required',
            
            // Validasi Pemberi Kuasa
            'pemberi_kuasa.*.nama' => 'required',
            'pemberi_kuasa.*.nik' => 'required|numeric|digits:16',
            'pemberi_kuasa.*.jenis_kelamin' => 'required',
            
            // Validasi Penerima Kuasa
            'penerima_kuasa.*.nama' => 'required',
            'penerima_kuasa.*.nik' => 'required|numeric|digits:16',
        ], [
            'no_hp_pemohon.required' => 'Nomor HP wajib diisi.',
            'sifat_perkara.required' => 'Sifat Kuasa wajib dipilih.',
            
            'pemberi_kuasa.*.nama.required' => 'Nama pemberi kuasa wajib diisi.',
            'pemberi_kuasa.*.nik.required' => 'NIK wajib diisi.',
            'pemberi_kuasa.*.nik.digits' => 'NIK harus 16 digit.',
            'pemberi_kuasa.*.jenis_kelamin.required' => 'Jenis kelamin pemberi kuasa wajib dipilih.',
            
            'penerima_kuasa.*.nama.required' => 'Nama penerima kuasa wajib diisi.',
            'penerima_kuasa.*.nik.required' => 'NIK wajib diisi.',
            'penerima_kuasa.*.nik.digits' => 'NIK harus 16 digit.',
        ]);
        
        // 2. LOGIKA PINDAH CABANG: UPDATE ATAU CREATE INDUK
        if ($this->suratKuasaId) {
            $suratKuasa = SuratKuasa::findOrFail($this->suratKuasaId);
            $suratKuasa->update([
                'jenis_kuasa'   => $this->jenis_kuasa,
                'no_hp_pemohon' => $this->no_hp_pemohon,
                'sifat_perkara' => $this->sifat_perkara
            ]);

            // Bersihkan data relasi lama sebelum disimpan ulang
            $suratKuasa->pemberiKuasa()->delete();
            $suratKuasa->penerimaKuasa()->delete();

            session()->flash('success', 'Data Surat Kuasa Insidentil berhasil diperbarui.');
        } else {
            $suratKuasa = SuratKuasa::create([
                'jenis_kuasa'   => $this->jenis_kuasa, // <-- WAJIB: Menyimpan string 'Insidentil' ke database induk
                'no_hp_pemohon' => $this->no_hp_pemohon,
                'sifat_perkara' => $this->sifat_perkara
            ]);

            session()->flash('success', 'Data Surat Kuasa Insidentil berhasil didaftarkan.');
        }

        // 3. SIMPAN DATA ANAK
        foreach ($this->pemberi_kuasa as $pemberi) {
            $suratKuasa->pemberiKuasa()->create($pemberi);
        }

        foreach ($this->penerima_kuasa as $penerima) {
            $suratKuasa->penerimaKuasa()->create($penerima);
        }

        // 4. DISPATCH EVENT SUKSES & REDIRECT
        $this->dispatch('permohonan-sukses', nama: $this->pemberi_kuasa[0]['nama']);
        $this->redirect('/surat-kuasa/kuasa-insidentil', navigate: true);
    }

    /**
     * Fungsi untuk melakukan stream PDF menggunakan DomPDF
     */
    private function bikinPdfStream($id)
    {
        // Ambil data dari database
        $suratKuasa = SuratKuasa::with(['pemberiKuasa', 'penerimaKuasa'])->findOrFail($id);
        
        $namaPemohon = $suratKuasa->pemberiKuasa->first()?->nama ?? 'Surat_Kuasa';

        // 1. Buat instance DomPDF secara manual
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.pdf-surat-kuasa-insidentil', [
            'data'         => $suratKuasa,
            'fontSize'     => '12pt',
            'lineHeight'   => '1.5',
            'tableSpacing' => '15px'
        ])->setPaper('legal', 'portrait');

        // 2. Bersihkan output buffer bawaan PHP/Livewire agar tidak corrupt
        if (ob_get_contents()) ob_end_clean();

        // 3. Kirim Header HTTP Native ke Browser
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="Preview_Surat_Kuasa_'.str_replace(' ', '_', $namaPemohon).'.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        // 4. Keluarkan isi PDF dan paksa hentikan script PHP saat itu juga
        echo $pdf->output();
        exit;
    }

    public function bikinWordDownload($id)
    {
        // 1. Ambil data dari database beserta relasinya
        $suratKuasa = SuratKuasa::with(['pemberiKuasa', 'penerimaKuasa'])->findOrFail($id);
        
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
            // Data mulai padat, ciutkan spasi sedikit agar muat rapi
            $fontSize = '11pt';
            $lineHeight = '1.3';
            $tableSpacing = '10px';
        } elseif ($totalOrang > 5) {
            // Jika orangnya sangat banyak (melebar ke halaman berikutnya), 
            // gunakan ukuran proporsional agar tidak terlalu nanggung di halaman baru
            $fontSize = '11.5pt';
            $lineHeight = '1.4';
            $tableSpacing = '12px';
        }

        // 2. Render view Blade PDF menjadi string HTML murni (Menggunakan file blade yang sama)
        $htmlContent = view('exports.pdf-surat-kuasa', [
            'data'         => $suratKuasa,
            'fontSize'     => $fontSize,
            'lineHeight'   => $lineHeight,
            'tableSpacing' => $tableSpacing
        ])->render();

        // 3. Bungkus HTML dengan XML dokumen Word agar dibaca resmi sebagai halaman F4/Folio Portrait oleh MS Word
        // Catatan: @page diatur ke ukuran 21.5cm x 33cm (Standar F4 Indonesia)
        $wordDocument = "
        <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
        <head>
            <title>Export Surat Kuasa Word</title>
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

        // 5. Stream ke browser untuk langsung download berkas .doc
        $filename = 'Surat_Kuasa_Insidentil_' . str_replace(' ', '_', $namaPemohon) . '.doc';

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
        session()->flash('success', 'Data Surat Kuasa Insidentil berhasil dihapus dari sistem TRITON.');

        // Refresh halaman secara halus agar tabel langsung ter-update otomatis
        $this->redirect('/surat-kuasa/kuasa-insidentil', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        // Modifikasi query untuk memfilter data berdasarkan pencarian dan membaginya per halaman
        $daftar_surat_kuasa = SuratKuasa::with(['pemberiKuasa', 'penerimaKuasa'])
            ->where('jenis_kuasa', 'kuasa_insidentil') // <-- KUNCI DI SINI: Menyaring khusus data Kuasa Insidentil
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('no_hp_pemohon', 'like', '%' . $this->search . '%')
                        ->orWhereHas('pemberiKuasa', function($subQuery) {
                            $subQuery->where('nama', 'like', '%' . $this->search . '%')
                                    ->orWhere('nik', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('penerimaKuasa', function($subQuery) {
                            $subQuery->where('nama', 'like', '%' . $this->search . '%')
                                    ->orWhere('nik', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest()
            ->paginate(10); 

        return view('livewire.form-kuasa-insidentil.surat-kuasa.index', [
            'daftar_surat_kuasa' => $daftar_surat_kuasa
        ]);
    }
}