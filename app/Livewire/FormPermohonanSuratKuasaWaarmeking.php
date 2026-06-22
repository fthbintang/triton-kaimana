<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SuratKuasaWaarmeking;
use Livewire\Attributes\Layout;

class FormPermohonanSuratKuasaWaarmeking extends Component
{
    public $no_hp_pemohon;
    public $pemberi_kuasa = [];
    public $penerima_kuasa = [];

    public function mount()
    {
        $this->pemberi_kuasa[] = [
            'nama' => '', 'nik' => '', 'jenis_kelamin' => '', 
            'agama' => '', 'pekerjaan' => '', 'alamat' => '',
            'urutan_ahli_waris' => 'Ahli Waris 1'
        ];

        $this->penerima_kuasa[] = [
            'nama' => '', 'nik' => '', 'jenis_kelamin' => '', 
            'agama' => '', 'pekerjaan' => '', 'alamat' => '',
            'status_penerima' => 'Penerima Kuasa 1'
        ];
    }

    public function tambahPemberi()
    {
        $nomorUrut = count($this->pemberi_kuasa) + 1;
        $this->pemberi_kuasa[] = [
            'nama' => '', 'nik' => '', 'jenis_kelamin' => '', 
            'agama' => '', 'pekerjaan' => '', 'alamat' => '',
            'urutan_ahli_waris' => 'Ahli Waris ' . $nomorUrut
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
        $nomorUrut = count($this->penerima_kuasa) + 1;
        $this->penerima_kuasa[] = [
            'nama' => '', 'nik' => '', 'jenis_kelamin' => '', 
            'agama' => '', 'pekerjaan' => '', 'alamat' => '',
            'status_penerima' => 'Penerima Kuasa ' . $nomorUrut
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

    public function simpan()
    {
        $this->validate([
            'no_hp_pemohon' => 'required|numeric',
            'pemberi_kuasa.*.nama' => 'required',
            'pemberi_kuasa.*.nik' => 'required|numeric|digits:16',
            'penerima_kuasa.*.nama' => 'required',
            'penerima_kuasa.*.nik' => 'required|numeric|digits:16',
        ], [
            'no_hp_pemohon.required' => 'Nomor HP wajib diisi.',
            'pemberi_kuasa.*.nama.required' => 'Nama ahli waris wajib diisi.',
            'pemberi_kuasa.*.nik.required' => 'NIK wajib diisi.',
            'pemberi_kuasa.*.nik.digits' => 'NIK harus 16 digit.',
            'penerima_kuasa.*.nama.required' => 'Nama penerima kuasa wajib diisi.',
            'penerima_kuasa.*.nik.required' => 'NIK wajib diisi.',
            'penerima_kuasa.*.nik.digits' => 'NIK harus 16 digit.',
        ]);

        $suratKuasa = SuratKuasaWaarmeking::create([
            'no_hp_pemohon' => $this->no_hp_pemohon
        ]);

        foreach ($this->pemberi_kuasa as $pemberi) {
            $suratKuasa->pemberiKuasa()->create($pemberi);
        }

        foreach ($this->penerima_kuasa as $penerima) {
            $suratKuasa->penerimaKuasa()->create($penerima);
        }

        $this->dispatch('permohonan-sukses', nama: $this->pemberi_kuasa[0]['nama']);
    }

    #[Layout('layouts.app_waarmeking')]
    public function render()
    {
        return view('livewire.form-permohonan-surat-kuasa-waarmeking');
    }
}