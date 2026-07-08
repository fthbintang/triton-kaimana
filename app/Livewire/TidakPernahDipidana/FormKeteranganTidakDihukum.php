<?php

namespace App\Livewire\TidakPernahDipidana;

use App\Models\Permohonan; 
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class FormKeteranganTidakDihukum extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // 1. Deklarasikan properti search di sini
    public $search = '';

    public $pesan_sukses = null;
    
    // State Router Komponen
    public bool $isCreating = false;
    public ?int $keterangantidakdihukumId = null;

    // Atribut Utama Tabel
    public string $jenis_naskah = 'pernyataan_tidak_dihukum';
    public string $nama_pemohon = '';
    public string $nik_pemohon = '';
    public string $no_hp_pemohon = '';

    // Atribut untuk JSON (data_spesifik Pemohon)
    public string $tempat_lahir = '';
    public string $tanggal_lahir = '';
    public string $jenis_kelamin = '';
    public string $agama = '';
    public string $jabatan = '';
    public string $pekerjaan = '';
    public string $alamat = '';

    protected function rules()
    {
        return [
            'nama_pemohon'  => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama'         => 'required|string|max:50',
            'pekerjaan'     => 'required|string|max:150',
            'jabatan'       => 'required|string|max:150',
            'no_hp_pemohon' => 'required|string|max:20',
            'alamat'        => 'required|string',
        ];
    }

    protected function messages()
    {
        return [
            // Nama Pemohon
            'nama_pemohon.required'  => 'Nama lengkap wajib diisi.',
            'nama_pemohon.string'    => 'Nama lengkap harus berupa teks.',
            'nama_pemohon.max'       => 'Nama lengkap maksimal 255 karakter.',

            // Jenis Kelamin
            'jenis_kelamin.required' => 'Silakan pilih jenis kelamin Anda.',
            'jenis_kelamin.in'       => 'Pilihan jenis kelamin tidak valid.',

            // Tempat & Tanggal Lahir
            'tempat_lahir.required'  => 'Tempat lahir wajib diisi.',
            'tempat_lahir.max'       => 'Tempat lahir maksimal 100 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',

            // Agama
            'agama.required'         => 'Agama wajib diisi.',

            // Pekerjaan & Jabatan
            'pekerjaan.required'     => 'Pekerjaan wajib diisi.',
            'jabatan.required'       => 'Jabatan wajib diisi (isi tanda "-" jika tidak ada).',

            // No HP
            'no_hp_pemohon.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'no_hp_pemohon.max'      => 'Nomor HP maksimal 20 karakter.',

            // Alamat
            'alamat.required'        => 'Alamat lengkap sesuai KTP wajib diisi.',
        ];
    }

    public function mount($id = null)
    {
        // 1. Logika Deteksi URL Stream/Download PDF jika diperlukan ke depan
        if ($id && request()->is('*pdf*')) { 
            return $this->bikinPdfStream($id)->send();
        }

        // 2. Logika Router internal komponen
        if (request()->is('*tambah')) {
            $this->isCreating = true;
            $this->keterangantidakdihukumId = null;
            $this->inisialisasiFormKosong();
        } 
        elseif (request()->route('id') && request()->is('*edit*')) {
            $this->isCreating = true;
            $this->keterangantidakdihukumId = request()->route('id');
            $this->isiDataKeForm($this->keterangantidakdihukumId); 
        } 
        else {
            $this->isCreating = false;
        }
    }

    public function updated(string $propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function inisialisasiFormKosong()
    {
        $this->reset([
            'nama_pemohon', 'nik_pemohon', 'no_hp_pemohon',
            'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'pekerjaan', 'alamat'
        ]);
        
        $this->jenis_naskah = 'pernyataan_tidak_dihukum';
        $this->keterangantidakdihukumId = null;
    }

    public function isiDataKeForm($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $ds = $permohonan->data_spesifik;

        $this->keterangantidakdihukumId = $permohonan->id;
        $this->nama_pemohon             = $permohonan->nama_pemohon;
        $this->no_hp_pemohon            = $permohonan->no_hp_pemohon;

        // Extract JSON data_spesifik Pemohon sesuai properti atas
        $this->tempat_lahir  = $ds['pemohon']['tempat_lahir'] ?? '';
        $this->tanggal_lahir = $ds['pemohon']['tanggal_lahir'] ?? '';
        $this->jenis_kelamin = $ds['pemohon']['jenis_kelamin'] ?? '';
        $this->jabatan       = $ds['pemohon']['jabatan'] ?? '';
        $this->pekerjaan     = $ds['pemohon']['pekerjaan'] ?? '';
        $this->agama         = $ds['pemohon']['agama'] ?? '';
        $this->alamat        = $ds['pemohon']['alamat'] ?? '';
    }

    public function save()
    {
        $this->validate();

        // Menyusun kembali struktur JSON data spesifik pemohon (Termasuk Agama & Jabatan)
        $dataSpesifik = [
            'pemohon' => [
                'tempat_lahir'  => $this->tempat_lahir,
                'tanggal_lahir' => $this->tanggal_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'agama'         => $this->agama,
                'pekerjaan'     => $this->pekerjaan,
                'jabatan'       => $this->jabatan,
                'alamat'        => $this->alamat,
            ]
        ];

        // LOGIKA PINDAH CABANG: UPDATE ATAU CREATE
        if ($this->keterangantidakdihukumId) {
            // JIKA SEDANG MODE EDIT -> UPDATE DATA LAMA
            $permohonan = Permohonan::findOrFail($this->keterangantidakdihukumId);
            $permohonan->update([
                'nama_pemohon'  => $this->nama_pemohon,
                'no_hp_pemohon' => $this->no_hp_pemohon,
                'data_spesifik' => $dataSpesifik,
            ]);
            
            session()->flash('success', 'Permohonan Keterangan Tidak Dihukum berhasil diperbarui.');
            session()->flash('cetak_id', $permohonan->id);
            session()->flash('cetak_nama', $this->nama_pemohon);
        } else {
            // JIKA DATA BARU -> CREATE SEPERTI BIASA
            $permohonan = Permohonan::create([
                'jenis_naskah'  => $this->jenis_naskah,
                'nama_pemohon'  => $this->nama_pemohon,
                'no_hp_pemohon' => $this->no_hp_pemohon,
                'data_spesifik' => $dataSpesifik,
            ]);
            
            session()->flash('success', 'Permohonan Pernyataan Tidak Pernah Dihukum berhasil didaftarkan.');
            session()->flash('cetak_id', $permohonan->id);
            session()->flash('cetak_nama', $this->nama_pemohon);
        }

        // Event browser untuk SweetAlert / UI trigger
        $this->dispatch('permohonan-sukses', nama: $this->nama_pemohon);
        
        // Reset State Form kembali ke awal
        $this->isCreating = false;
        $this->keterangantidakdihukumId = null;
        $this->inisialisasiFormKosong();
    }

    public function destroy($id): void
    {
        // Cari data permohonan berdasarkan ID
        $permohonan = Permohonan::findOrFail($id);
        
        // Hapus data dari database
        $permohonan->delete();

        // Kirim notifikasi sukses menggunakan Flash Session bawaan Laravel
        session()->flash('success', 'Data berhasil dihapus dari sistem.');

        // Refresh halaman secara halus agar tabel langsung ter-update otomatis
        $this->redirect('/layanan/tidak-dipidana', navigate: true);
    }

    private function bikinPdfStream($id)
    {
        // Ambil data dari database permohonan tidak dihukum
        $permohonan = Permohonan::findOrFail($id);
        
        // Memastikan data_spesifik berwujud array
        if (is_string($permohonan->data_spesifik)) {
            $permohonan->data_spesifik = json_decode($permohonan->data_spesifik, true);
        }

        $namaPemohon = $permohonan->nama_pemohon ?? 'Pernyataan';

        // 1. Buat instance DomPDF secara manual dengan kertas F4 (215mm x 330mm)
        $pdf = Pdf::loadView('exports.pdf-pernyataan-tidak-dihukum', [
            'permohonan'   => $permohonan,
            'fontSize'     => '11pt', // Arial sedikit lebih besar dari Times New Roman, 11pt sangat pas
            'lineHeight'   => '1.6',
            'tableSpacing' => '12px'
        ])->setPaper([0, 0, 609.45, 935.43], 'portrait'); // Konversi mm ke poin standar F4

        // 2. Bersihkan output buffer bawaan PHP/Livewire agar tidak corrupt
        if (ob_get_contents()) ob_end_clean();

        // 3. Kirim Header HTTP Native ke Browser (Inline Preview)
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="Preview_Surat_Pernyataan_'.str_replace(' ', '_', $namaPemohon).'.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        // 4. Keluarkan isi PDF dan paksa hentikan script PHP saat itu juga
        echo $pdf->output();
        exit;
    }

    public function bikinWordDownload($id)
    {
        // 1. Ambil data dari database permohonan tidak dihukum
        $permohonan = Permohonan::findOrFail($id);
        
        // Memastikan data_spesifik berwujud array jika belum dicast otomatis di model
        if (is_string($permohonan->data_spesifik)) {
            $permohonan->data_spesifik = json_decode($permohonan->data_spesifik, true);
        }

        $namaPemohon = $permohonan->nama_pemohon ?? 'Pernyataan';

        // Gunakan setelan ukuran & spasi rapat yang pas untuk 1 halaman Arial
        $fontSize = '11pt';
        $lineHeight = '1.6';
        $tableSpacing = '12px';

        // 2. Render view Blade PDF menjadi string HTML murni (Menggunakan file blade yang sama)
        $htmlContent = view('exports.pdf-pernyataan-tidak-dihukum', [
            'permohonan'   => $permohonan,
            'fontSize'     => $fontSize,
            'lineHeight'   => $lineHeight,
            'tableSpacing' => $tableSpacing
        ])->render();

        // 3. Bungkus HTML dengan XML dokumen Word agar dibaca resmi sebagai halaman F4/Folio Portrait oleh MS Word
        // Catatan: @page diatur ke ukuran 21.5cm x 33cm (Standar F4 Indonesia)
        $wordDocument = "
        <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
        <head>
            <meta charset='UTF-8'>
            <title>Export Surat Pernyataan Word</title>
            <style>
                @page Section1 {
                    size: 21.5cm 33.0cm;
                    margin: 2cm 2cm 2cm 2.5cm; /* Menyesuaikan margin cetakan PDF sebelumnya */
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
        $filename = 'Surat_Pernyataan_Tidak_Dihukum_' . str_replace(' ', '_', $namaPemohon) . '.doc';

        return response($wordDocument, 200, [
            'Content-Type'        => 'application/msword',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'private, max-age=0, must-revalidate',
            'Pragma'              => 'public',
        ]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.tidak-pernah-dipidana.pernyataan-tidak-dihukum.index', [
            'daftar_tidak_dihukum' => Permohonan::query()
                ->where('jenis_naskah', 'pernyataan_tidak_dihukum')
                ->where(function ($query) {
                    $query->where('nama_pemohon', 'like', '%' . $this->search . '%')
                            ->orWhere('nik_pemohon', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate(10)
        ]);
    }
}