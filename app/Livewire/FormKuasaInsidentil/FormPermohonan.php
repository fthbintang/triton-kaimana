<?php

namespace App\Livewire\FormKuasaInsidentil;

use App\Models\Permohonan;
use Livewire\Component;
use Livewire\Attributes\Layout;

class FormPermohonan extends Component
{
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
    public string $hubungan_penerima_ke_pemberi = ''; // Hubungan sudut pandang Penerima (Contoh: Anak Kandung)

    // Properti Spesifik Pemberi Kuasa
    public string $nama_pemberi = '';
    public string $nik_pemberi = '';
    public string $tempat_lahir_pemberi = '';
    public string $tanggal_lahir_pemberi = '';
    public string $jenis_kelamin_pemberi = '';
    public string $agama_pemberi = '';
    public string $pekerjaan_pemberi = '';
    public string $alamat_pemberi = '';
    public string $hubungan_pemberi_ke_penerima = ''; // Hubungan sudut pandang Pemberi (Contoh: Ibu Kandung)

    // Detail Perkara & Alasan Hukum Dinamis
    public string $kedudukan_pemberi = '';     // Dropdown: Pemohon / Penggugat / Tergugat
    public string $jenis_perkara = '';         // Contoh: Permohonan Pengesahan Anak
    public string $alasan_tidak_hadir = '';    // Contoh: bertempat tinggal di Jayapura dan telah cerai mati...
    public string $tujuan_kuasa = '';          // Contoh: demi kepentingan anak dari Pemberi Kuasa...

    protected function rules()
    {
        return [
            'tujuan_pimpinan' => 'required|string',
            
            // Validasi Penerima Kuasa (Pemohon)
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

            // Validasi Pemberi Kuasa
            'nama_pemberi' => 'required|string|max:255',
            'nik_pemberi' => 'required|numeric|digits:16',
            'tempat_lahir_pemberi' => 'required|string|max:100',
            'tanggal_lahir_pemberi' => 'required|date',
            'jenis_kelamin_pemberi' => 'required|string',
            'agama_pemberi' => 'required|string',
            'pekerjaan_pemberi' => 'required|string|max:255',
            'alamat_pemberi' => 'required|string',
            'hubungan_pemberi_ke_penerima' => 'required|string',
            
            // Validasi Kasus & Alasan
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

    public function simpan()
    {
        $this->validate();

        // Menyusun struktur data_spesifik baru berdasarkan pemetaan draf surat full
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

        Permohonan::create([
            'jenis_naskah' => 'surat_kuasa_insidentil',
            'nama_pemohon' => $this->nama_pemohon, 
            'nik_pemohon' => $this->nik_pemohon,   
            'no_hp_pemohon' => $this->no_hp_pemohon,
            'status' => 'tunda',
            'data_spesifik' => $dataSpesifik,
        ]);

        $this->dispatch('permohonan-sukses', nama: $this->nama_pemohon);

        // Reset semua input form ke kondisi awal bersih
        $this->reset();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.form-kuasa-insidentil.form-permohonan');
    }
}