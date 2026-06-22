<?php

namespace App\Livewire\FormKuasaInsidentil;

use Livewire\Component;
use App\Models\Permohonan;
use Livewire\Attributes\Layout;

class FormPermohonan extends Component
{
    // Properti Utama Tabel Permohonan (Diambil dari data Penerima Kuasa)
    public string $no_hp_pemohon = '';
    public string $nama_pemohon = ''; // Akan diisi Nama Penerima Kuasa
    public string $nik_pemohon = '';  // Akan diisi NIK Penerima Kuasa

    // Properti Spesifik Pemberi Kuasa
    public string $nama_pemberi = '';
    public string $nik_pemberi = '';
    public string $jenis_kelamin_pemberi = '';
    public string $agama_pemberi = '';
    public string $alamat_pemberi = '';

    // Properti Spesifik Penerima Kuasa (Tambahan detail untuk JSON)
    public string $jenis_kelamin_penerima = '';
    public string $agama_penerima = '';
    public string $pekerjaan_penerima = '';
    public string $alamat_penerima = '';
    
    // Detail Perkara
    public string $hubungan_keluarga = '';
    public string $perkara_permohonan = '';

    protected function rules()
    {
        return [
            'no_hp_pemohon' => 'required|numeric',
            'nama_pemohon' => 'required|string|max:255',
            'nik_pemohon' => 'required|numeric|digits:16',
            'jenis_kelamin_penerima' => 'required|string',
            'agama_penerima' => 'required|string',
            'pekerjaan_penerima' => 'required|string|max:255',
            'alamat_penerima' => 'required|string',
            
            'nama_pemberi' => 'required|string|max:255',
            'nik_pemberi' => 'required|numeric|digits:16',
            'jenis_kelamin_pemberi' => 'required|string',
            'agama_pemberi' => 'required|string',
            'alamat_pemberi' => 'required|string',
            
            'hubungan_keluarga' => 'required|string',
            'perkara_permohonan' => 'required|string',
        ];
    }

    // UPDATE: Menambahkan pesan validasi kustom berbahasa Indonesia
    protected function messages()
    {
        return [
            // Pesan Global berdasarkan Aturan (Rule)
            'required' => 'Kolom ini wajib diisi.',
            'numeric' => 'Kolom ini hanya boleh diisi dengan angka.',
            'string' => 'Inputan harus berupa teks.',
            'max' => 'Karakter terlalu panjang (Maksimal :max karakter).',
            
            // Pesan Spesifik untuk NIK & Kontak
            'nik_pemohon.digits' => 'NIK Penerima Kuasa harus tepat 16 digit.',
            'nik_pemberi.digits' => 'NIK Pemberi Kuasa harus tepat 16 digit.',
            'no_hp_pemohon.numeric' => 'Nomor HP hanya boleh berisi angka.',
        ];
    }

    public function updated(string $propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function simpan()
    {
        $this->validate();

        // Menyusun data spesifik ke dalam JSON
        $dataSpesifik = [
            'pemberi' => [
                'nama' => $this->nama_pemberi,
                'nik' => $this->nik_pemberi,
                'jenis_kelamin' => $this->jenis_kelamin_pemberi,
                'agama' => $this->agama_pemberi,
                'alamat' => $this->alamat_pemberi,
            ],
            'penerima' => [
                'jenis_kelamin' => $this->jenis_kelamin_penerima,
                'agama' => $this->agama_penerima,
                'pekerjaan' => $this->pekerjaan_penerima,
                'alamat' => $this->alamat_penerima,
            ],
            'hubungan_keluarga' => $this->hubungan_keluarga,
            'perkara_permohonan' => $this->perkara_permohonan,
        ];

        Permohonan::create([
            'jenis_naskah' => 'surat_kuasa_insidentil',
            'nama_pemohon' => $this->nama_pemohon, // Penerima Kuasa
            'nik_pemohon' => $this->nik_pemohon,   // Penerima Kuasa
            'no_hp_pemohon' => $this->no_hp_pemohon,
            'status' => 'tunda',
            'data_spesifik' => $dataSpesifik,
        ]);

        $this->dispatch('permohonan-sukses', nama: $this->nama_pemohon);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.form-kuasa-insidentil.form-permohonan');
    }
}