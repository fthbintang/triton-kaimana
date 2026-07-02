<?php

namespace App\Livewire\FormKuasaInsidentil;

use App\Models\Permohonan;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class FormPermohonan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Pengontrol Pencarian & Tampilan Halaman (Tabel vs Form)
    public string $search = '';
    public bool $isCreating = false;
    public ?int $permohonanId = null;
    public ?string $pesan_sukses = null;

    public $tujuan_pimpinan = 'Ketua';
    
    // Properti Utama Tabel Permohonan (Penerima Kuasa)
    public string $no_hp_pemohon = '';
    public string $nama_pemohon = ''; 
    public string $nik_pemohon = '';  

    // Properti Spesifik Penerima Kuasa (Detail Tambahan untuk JSON)
    public string $tempat_lahir_penerima = '';
    public string $tanggal_lahir_penerima = '';
    public string $jenis_kelamin_penerima = '';
    public string $agama_penerima = '';
    public string $pekerjaan_penerima = '';
    public string $alamat_penerima = '';
    public string $hubungan_penerima_ke_pemberi = ''; 

    // Properti Spesifik Pemberi Kuasa
    public string $nama_pemberi = '';
    public string $nik_pemberi = '';
    public string $tempat_lahir_pemberi = '';
    public string $tanggal_lahir_pemberi = '';
    public string $jenis_kelamin_pemberi = '';
    public string $agama_pemberi = '';
    public string $pekerjaan_pemberi = '';
    public string $alamat_pemberi = '';
    public string $hubungan_pemberi_ke_penerima = ''; 

    // Detail Perkara & Alasan Hukum Dinamis
    public string $kedudukan_pemberi = '';     
    public string $jenis_perkara = '';         
    public string $alasan_tidak_hadir = '';    
    public string $tujuan_kuasa = '';          

    public function mount($id = null)
    {
        // 1. Logika Deteksi URL Stream/Download PDF jika diperlukan ke depan
        if ($id && request()->is('*pdf*')) { 
            return $this->bikinPdfStream($id)->send();
        }

        // 2. Logika Router internal komponen
        if (request()->is('*tambah')) {
            $this->isCreating = true;
            $this->permohonanId = null;
            $this->inisialisasiFormKosong();
        } 
        elseif (request()->route('id') && request()->is('*edit*')) {
            $this->isCreating = true;
            $this->permohonanId = request()->route('id');
            $this->isiDataKeForm($this->permohonanId); 
        } 
        else {
            $this->isCreating = false;
        }
    }

    protected function rules()
    {
        return [
            'tujuan_pimpinan' => 'required|string',
            'no_hp_pemohon' => 'required|numeric|min_digits:10',
            'nama_pemohon' => 'required|string|max:255',
            'nik_pemohon' => 'required|numeric|digits:16',
            'tempat_lahir_penerima' => 'required|string|max:100',
            'tanggal_lahir_penerima' => 'required|date',
            'jenis_kelamin_penerima' => 'required|string',
            'agama_penerima' => 'required|string',
            'pekerjaan_penerima' => 'required|string|max:255',
            'alamat_penerima' => 'required|string',
            'hubungan_penerima_ke_pemberi' => 'required|string',
            'nama_pemberi' => 'required|string|max:255',
            'nik_pemberi' => 'required|numeric|digits:16',
            'tempat_lahir_pemberi' => 'required|string|max:100',
            'tanggal_lahir_pemberi' => 'required|date',
            'jenis_kelamin_pemberi' => 'required|string',
            'agama_pemberi' => 'required|string',
            'pekerjaan_pemberi' => 'required|string|max:255',
            'alamat_pemberi' => 'required|string',
            'hubungan_pemberi_ke_penerima' => 'required|string',
            'kedudukan_pemberi' => 'required|string',
            'jenis_perkara' => 'required|string|max:255',
            'alasan_tidak_hadir' => 'required|string',
            'tujuan_kuasa' => 'required|string',
        ];
    }

    protected function messages()
    {
        return [
            'required' => 'Kolom ini wajib diisi.',
            'numeric' => 'Kolom ini hanya boleh diisi dengan angka.',
            'string' => 'Inputan harus berupa teks.',
            'max' => 'Karakter terlalu panjang (Maksimal :max karakter).',
            'date' => 'Format tanggal tidak valid.',
            'nik_pemohon.digits' => 'NIK Penerima Kuasa harus tepat 16 digit.',
            'nik_pemberi.digits' => 'NIK Pemberi Kuasa harus tepat 16 digit.',
            'no_hp_pemohon.min_digits' => 'Nomor HP minimal berisi 10 digit.',
        ];
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
            'no_hp_pemohon', 'nama_pemohon', 'nik_pemohon',
            'tempat_lahir_penerima', 'tanggal_lahir_penerima', 'jenis_kelamin_penerima',
            'agama_penerima', 'pekerjaan_penerima', 'alamat_penerima', 'hubungan_penerima_ke_pemberi',
            'nama_pemberi', 'nik_pemberi', 'tempat_lahir_pemberi', 'tanggal_lahir_pemberi',
            'jenis_kelamin_pemberi', 'agama_pemberi', 'pekerjaan_pemberi', 'alamat_pemberi',
            'hubungan_pemberi_ke_penerima', 'kedudukan_pemberi', 'jenis_perkara',
            'alasan_tidak_hadir', 'tujuan_kuasa'
        ]);
        $this->tujuan_pimpinan = 'Ketua';
        $this->permohonanId = null;
    }

    public function isiDataKeForm($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $ds = $permohonan->data_spesifik;

        $this->permohonanId = $permohonan->id;
        $this->nama_pemohon = $permohonan->nama_pemohon;
        $this->nik_pemohon = $permohonan->nik_pemohon;
        $this->no_hp_pemohon = $permohonan->no_hp_pemohon;

        // Extract JSON data_spesifik Penerima
        $this->tempat_lahir_penerima = $ds['penerima']['tempat_lahir'] ?? '';
        $this->tanggal_lahir_penerima = $ds['penerima']['tanggal_lahir'] ?? '';
        $this->jenis_kelamin_penerima = $ds['penerima']['jenis_kelamin'] ?? '';
        $this->agama_penerima = $ds['penerima']['agama'] ?? '';
        $this->pekerjaan_penerima = $ds['penerima']['pekerjaan'] ?? '';
        $this->alamat_penerima = $ds['penerima']['alamat'] ?? '';
        $this->hubungan_penerima_ke_pemberi = $ds['penerima']['hubungan_keluarga'] ?? '';

        // Extract JSON data_spesifik Pemberi
        $this->nama_pemberi = $ds['pemberi']['nama'] ?? '';
        $this->nik_pemberi = $ds['pemberi']['nik'] ?? '';
        $this->tempat_lahir_pemberi = $ds['pemberi']['tempat_lahir'] ?? '';
        $this->tanggal_lahir_pemberi = $ds['pemberi']['tanggal_lahir'] ?? '';
        $this->jenis_kelamin_pemberi = $ds['pemberi']['jenis_kelamin'] ?? '';
        $this->agama_pemberi = $ds['pemberi']['agama'] ?? '';
        $this->pekerjaan_pemberi = $ds['pemberi']['pekerjaan'] ?? '';
        $this->alamat_pemberi = $ds['pemberi']['alamat'] ?? '';
        $this->hubungan_pemberi_ke_penerima = $ds['pemberi']['hubungan_keluarga'] ?? '';

        // Extract JSON data_spesifik Perkara
        $this->tujuan_pimpinan = $ds['perkara']['tujuan_pimpinan'] ?? 'Ketua';
        $this->kedudukan_pemberi = $ds['perkara']['kedudukan_pemberi'] ?? '';
        $this->jenis_perkara = $ds['perkara']['jenis_perkara'] ?? '';
        $this->alasan_tidak_hadir = $ds['perkara']['alasan_tidak_hadir'] ?? '';
        $this->tujuan_kuasa = $ds['perkara']['tujuan_kuasa'] ?? '';
    }

    // public function save()
    // {
    //     $this->validate();

    //     $dataSpesifik = [
    //         'penerima' => [
    //             'tempat_lahir'      => $this->tempat_lahir_penerima,
    //             'tanggal_lahir'     => $this->tanggal_lahir_penerima,
    //             'jenis_kelamin'     => $this->jenis_kelamin_penerima,
    //             'agama'             => $this->agama_penerima,
    //             'pekerjaan'         => $this->pekerjaan_penerima,
    //             'alamat'            => $this->alamat_penerima,
    //             'hubungan_keluarga' => $this->hubungan_penerima_ke_pemberi,
    //         ],
    //         'pemberi' => [
    //             'nama'              => $this->nama_pemberi,
    //             'nik'               => $this->nik_pemberi,
    //             'tempat_lahir'      => $this->tempat_lahir_pemberi,
    //             'tanggal_lahir'     => $this->tanggal_lahir_pemberi,
    //             'jenis_kelamin'     => $this->jenis_kelamin_pemberi,
    //             'agama'             => $this->agama_pemberi,
    //             'pekerjaan'         => $this->pekerjaan_pemberi,
    //             'alamat'            => $this->alamat_pemberi,
    //             'hubungan_keluarga' => $this->hubungan_pemberi_ke_penerima,
    //         ],
    //         'perkara' => [
    //             'tujuan_pimpinan'    => $this->tujuan_pimpinan,
    //             'kedudukan_pemberi'  => $this->kedudukan_pemberi,
    //             'jenis_perkara'      => $this->jenis_perkara,
    //             'alasan_tidak_hadir' => $this->alasan_tidak_hadir,
    //             'tujuan_kuasa'       => $this->tujuan_kuasa,
    //         ]
    //     ];

    //     // LOGIKA DUAL MODE: UPDATE atau CREATE
    //     if ($this->permohonanId) {
    //         $permohonan = Permohonan::findOrFail($this->permohonanId);
    //         $permohonan->update([
    //             'nama_pemohon' => $this->nama_pemohon,
    //             'nik_pemohon' => $this->nik_pemohon,
    //             'no_hp_pemohon' => $this->no_hp_pemohon,
    //             'data_spesifik' => $dataSpesifik,
    //         ]);
    //         $this->pesan_sukses = "Data permohonan " . $this->nama_pemohon . " berhasil diperbarui.";
    //     } else {
    //         Permohonan::create([
    //             'jenis_naskah' => 'kuasa_insidentil', // Disamakan dengan filter render
    //             'nama_pemohon' => $this->nama_pemohon,
    //             'nik_pemohon' => $this->nik_pemohon,
    //             'no_hp_pemohon' => $this->no_hp_pemohon,
    //             'data_spesifik' => $dataSpesifik,
    //         ]);
    //         $this->pesan_sukses = "Data permohonan baru berhasil ditambahkan.";
    //     }

    //     $this->dispatch('permohonan-sukses', nama: $this->nama_pemohon);
        
    //     $this->isCreating = false;
    //     $this->permohonanId = null;
    //     $this->inisialisasiFormKosong();
    // }

    public function save()
    {
        $this->validate();

        $dataSpesifik = [
            'penerima' => [
                'tempat_lahir'      => $this->tempat_lahir_penerima,
                'tanggal_lahir'     => $this->tanggal_lahir_penerima,
                'jenis_kelamin'     => $this->jenis_kelamin_penerima,
                'agama'             => $this->agama_penerima,
                'pekerjaan'         => $this->pekerjaan_penerima,
                'alamat'            => $this->alamat_penerima,
                'hubungan_keluarga' => $this->hubungan_penerima_ke_pemberi,
            ],
            'pemberi' => [
                'nama'              => $this->nama_pemberi,
                'nik'               => $this->nik_pemberi,
                'tempat_lahir'      => $this->tempat_lahir_pemberi,
                'tanggal_lahir'     => $this->tanggal_lahir_pemberi,
                'jenis_kelamin'     => $this->jenis_kelamin_pemberi,
                'agama'             => $this->agama_pemberi,
                'pekerjaan'         => $this->pekerjaan_pemberi,
                'alamat'            => $this->alamat_pemberi,
                'hubungan_keluarga' => $this->hubungan_pemberi_ke_penerima,
            ],
            'perkara' => [
                'tujuan_pimpinan'    => $this->tujuan_pimpinan,
                'kedudukan_pemberi'  => $this->kedudukan_pemberi,
                'jenis_perkara'      => $this->jenis_perkara,
                'alasan_tidak_hadir' => $this->alasan_tidak_hadir,
                'tujuan_kuasa'       => $this->tujuan_kuasa,
            ]
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
            
            // Disamakan agar memicu notifikasi flash dan pop-up cetak otomatis setelah edit
            session()->flash('success', 'Permohonan Kuasa Insidentil berhasil diperbarui.');
            session()->flash('cetak_id', $permohonan->id);
            session()->flash('cetak_nama', $this->nama_pemohon);
        } else {
            // JIKA DATA BARU -> CREATE SEPERTI BIASA
            $permohonan = Permohonan::create([
                'jenis_naskah'  => 'kuasa_insidentil',
                'nama_pemohon'  => $this->nama_pemohon,
                'nik_pemohon'   => $this->nik_pemohon,
                'no_hp_pemohon' => $this->no_hp_pemohon,
                'data_spesifik' => $dataSpesifik,
            ]);
            
            session()->flash('success', 'Permohonan Kuasa Insidentil berhasil didaftarkan.');
            session()->flash('cetak_id', $permohonan->id);
            session()->flash('cetak_nama', $this->nama_pemohon);
        }

        // SweetAlert atau event browser tetap dikirim jika dibutuhkan oleh template view Anda
        $this->dispatch('permohonan-sukses', nama: $this->nama_pemohon);
        
        // Reset State Form
        $this->isCreating = false;
        $this->permohonanId = null;
        $this->inisialisasiFormKosong();
    }

    public function destroy($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $nama = $permohonan->nama_pemohon;
        $permohonan->delete();

        // Kirim notifikasi sukses menggunakan Flash Session bawaan Laravel
        session()->flash('success', 'Permohonan Kuasa Insidentil berhasil dihapus dari sistem.');
    }

    private function bikinPdfStream($id)
    {
        // 1. Ambil data permohonan berdasarkan ID
        $permohonan = Permohonan::findOrFail($id);
        $dataSpesifik = $permohonan->data_spesifik;

        // 2. Ekstrak sub-array data untuk memudahkan pengecekan
        $penerima = $dataSpesifik['penerima'] ?? [];
        $pemberi   = $dataSpesifik['pemberi'] ?? [];
        $perkara  = $dataSpesifik['perkara'] ?? [];

        // =========================================================================
        // TRIK OTOMATISASI AGAR PAS & TIDAK JATUH NANGGUNG DI HALAMAN BERIKUTNYA
        // =========================================================================
        // Menghitung panjang karakter dari input naratif esai yang berpotensi sangat panjang
        $panjangTeksAlasan = strlen($perkara['alasan_tidak_hadir'] ?? '');
        $panjangTeksTujuan = strlen($perkara['tujuan_kuasa'] ?? '');
        $totalKarakterNaratif = $panjangTeksAlasan + $panjangTeksTujuan;

        // Nilai Standar Default (Sangat ideal jika alasan & tujuan padat/singkat)
        $fontSize = '12pt';
        $lineHeight = '1.5';
        $tableSpacing = '4px'; // Spasi antar baris di tabel identitas

        if ($totalKarakterNaratif > 250 && $totalKarakterNaratif <= 500) {
            // Cerita alasan/tujuan mulai agak panjang, ciutkan sedikit spasi dan font
            $fontSize = '11.5pt';
            $lineHeight = '1.4';
            $tableSpacing = '3px';
        } elseif ($totalKarakterNaratif > 500) {
            // Jika alasannya sangat panjang lebar, diketatkan maksimal agar dipaksa cukup
            $fontSize = '11pt';
            $lineHeight = '1.3';
            $tableSpacing = '2px';
        }

        // 3. Render view dengan payload data terstruktur sesuai key save()
        $pdf = Pdf::loadView('exports.pdf-permohonan-kuasa-insidentil', [
            'permohonan' => $permohonan,
            // Oper variabel styling otomatis ke Blade PDF
            'fontSize'     => $fontSize,
            'lineHeight'   => $lineHeight,
            'tableSpacing' => $tableSpacing
        ])->setPaper('f4', 'portrait'); // Menggunakan ukuran f4 / folio standar pengadilan

        // 4. Kembalikan response berupa stream preview di browser
        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Permohonan_Kuasa_Insidentil_'.str_replace(' ', '_', $permohonan->nama_pemohon).'.pdf"',
        ]);
    }

    public function bikinWordDownload($id)
    {
        // 1. Ambil data permohonan berdasarkan ID
        $permohonan = Permohonan::findOrFail($id);
        $dataSpesifik = $permohonan->data_spesifik;
        $perkara = $dataSpesifik['perkara'] ?? [];

        // 2. Samakan hitungan otomatisasi kerapatan karakter seperti versi PDF
        $panjangTeksAlasan = strlen($perkara['alasan_tidak_hadir'] ?? '');
        $panjangTeksTujuan = strlen($perkara['tujuan_kuasa'] ?? '');
        $totalKarakterNaratif = $panjangTeksAlasan + $panjangTeksTujuan;

        $fontSize = '12pt';
        $lineHeight = '1.5';
        $tableSpacing = '4px';

        if ($totalKarakterNaratif > 250 && $totalKarakterNaratif <= 500) {
            $fontSize = '11.5pt';
            $lineHeight = '1.4';
            $tableSpacing = '3px';
        } elseif ($totalKarakterNaratif > 500) {
            $fontSize = '11pt';
            $lineHeight = '1.3';
            $tableSpacing = '2px';
        }

        // Paksa lokal bahasa ke Indonesia untuk library Carbon di dalam blade
        \Carbon\Carbon::setLocale('id');

        // 3. Render view Blade PDF menjadi string HTML murni
        // Pastikan path view mengarah ke file blade yang baru saja kita perbarui (menggunakan font Arial dan tabel rapat)
        $htmlContent = view('exports.pdf-permohonan-kuasa-insidentil', [
            'permohonan'   => $permohonan,
            'fontSize'     => $fontSize,
            'lineHeight'   => $lineHeight,
            'tableSpacing' => $tableSpacing
        ])->render();

        // 4. Bungkus HTML dengan XML dokumen Word agar dibaca resmi sebagai halaman Portrait oleh MS Word
        $wordDocument = "
        <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
        <head>
            <meta charset='UTF-8'>
            <title>Export Word - Kuasa Insidentil</title>
            <style>
                @page Section1 {
                    size: 8.5in 13in; /* Ukuran F4 / Folio */
                    margin: 0.6in 0.8in 0.5in 0.8in;
                    mso-header-margin: 0.5in;
                    mso-footer-margin: 0.5in;
                    mso-paper-source: 0;
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

        // 5. Stream ke browser untuk langsung download berkas berkstensi .doc
        $filename = 'Permohonan_Kuasa_Insidentil_' . str_replace(' ', '_', $permohonan->nama_pemohon) . '.doc';

        return response($wordDocument, 200, [
            'Content-Type' => 'application/msword',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'private, max-age=0, must-revalidate',
        ]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $daftar_kuasa_insidentil = Permohonan::where('jenis_naskah', 'kuasa_insidentil')
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('nama_pemohon', 'like', '%' . $this->search . '%')
                        ->orWhere('nik_pemohon', 'like', '%' . $this->search . '%')
                        ->orWhere('no_hp_pemohon', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.form-kuasa-insidentil.permohonan.index', [
            'daftar_kuasa_insidentil' => $daftar_kuasa_insidentil
        ]);
    }
}