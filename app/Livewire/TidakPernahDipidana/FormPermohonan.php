<?php

namespace App\Livewire\TidakPernahDipidana;

use Livewire\Component;
use App\Models\Permohonan; 
use Livewire\Attributes\Layout;

class FormPermohonan extends Component
{
    // Atribut Utama Tabel
    public string $nama_pemohon = '';
    public string $nik_pemohon = '';
    public string $no_hp_pemohon = '';

    // Atribut untuk JSON (data_spesifik)
    public string $tempat_lahir = '';
    public string $tanggal_lahir = '';
    public string $jenis_kelamin = '';
    public string $agama = '';
    public string $pekerjaan = '';
    public string $jabatan = '';
    public string $alamat = '';

    protected $rules = [
        'nama_pemohon'  => 'required|string|max:255',
        'nik_pemohon'   => 'required|numeric|digits:16',
        'no_hp_pemohon' => 'required|string|max:20',
        'tempat_lahir'  => 'required|string|max:100',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required',
        'agama'         => 'required|string',
        'pekerjaan'     => 'required|string',
        'jabatan'       => 'required|string|max:100',
        'alamat'        => 'required|string',
    ];

    public function simpanPermohonan()
    {
        $this->validate();

        try {
            // Menyusun data spesifik dalam bentuk array murni
            $dataSpesifik = [
                'tempat_lahir'  => $this->tempat_lahir,
                'tanggal_lahir' => $this->tanggal_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'agama'         => $this->agama,
                'pekerjaan'     => $this->pekerjaan,
                'jabatan'       => $this->jabatan,
                'alamat'        => $this->alamat,
            ];

            Permohonan::create([
                'jenis_naskah'  => 'sk_tidak_dipidana',
                'nama_pemohon'  => $this->nama_pemohon,
                'nik_pemohon'   => $this->nik_pemohon,
                'no_hp_pemohon' => $this->no_hp_pemohon,
                'data_spesifik' => $dataSpesifik, // json_encode dihapus agar dicast otomatis oleh Laravel Model
                'status'        => 'tunda'
            ]);

            session()->flash('success', 'Data berhasil dikirim ke TRITON! Petugas PTSP Hukum akan memproses dokumen Word Anda.');
            $this->reset(); 
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.tidak-pernah-dipidana.form-permohonan');
    }
}