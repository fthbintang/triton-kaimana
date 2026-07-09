<?php

namespace Database\Seeders;

use App\Models\SuratKuasa;
use App\Models\PemberiKuasa;
use App\Models\PenerimaKuasa;
use Illuminate\Database\Seeder;

class SuratKuasaSeeder extends Seeder
{
    public function run(): void
    {
        // Kumpulan opsi status silsilah standar aplikasi (hanya untuk waarmeking)
        $opsiSilsilah = ['Istri Pewaris', 'Ahli Waris I', 'Ahli Waris II', 'Ahli Waris III', 'Ahli Waris IV', 'Ahli Waris V'];

        // Membuat total 45 data tiruan agar sebaran 3 jenis dokumen ini merata
        for ($i = 0; $i < 45; $i++) {
            
            // Sekarang mengacak 3 pilihan jenis kuasa sekaligus
            $jenisKuasa = fake()->randomElement(['waarmeking', 'kuasa_insidentil', 'tidak_pernah_dipidana']);

            // 1. Buat data Induk Surat Kuasa
            $suratKuasa = SuratKuasa::create([
                'jenis_kuasa'   => $jenisKuasa,
                'no_hp_pemohon' => '08' . fake()->numerify('##########'),
            ]);

            // 2. Buat Data Pemberi Kuasa (1 sampai 3 orang)
            $jumlahPemberi = rand(1, 3);
            for ($j = 0; $j < $jumlahPemberi; $j++) {
                
                // Urutan ahli waris hanya berlaku untuk waarmeking, selain itu null
                $urutanPemberi = ($jenisKuasa === 'waarmeking') 
                    ? ($opsiSilsilah[$j] ?? 'Ahli Waris V')
                    : null;

                $suratKuasa->pemberiKuasa()->create(
                    PemberiKuasa::factory()->make([
                        'urutan_ahli_waris' => $urutanPemberi
                    ])->toArray()
                );
            }

            // 3. Buat Data Penerima Kuasa (1 sampai 3 orang)
            $jumlahPenerima = rand(1, 3);
            for ($k = 0; $k < $jumlahPenerima; $k++) {
                $indexSilsilahPenerima = $jumlahPemberi + $k;
                
                // Urutan ahli waris hanya berlaku untuk waarmeking, selain itu null
                $urutanPenerima = ($jenisKuasa === 'waarmeking') 
                    ? ($opsiSilsilah[$indexSilsilahPenerima] ?? 'Ahli Waris V')
                    : null;

                $suratKuasa->penerimaKuasa()->create(
                    PenerimaKuasa::factory()->make([
                        'urutan_ahli_waris' => $urutanPenerima
                    ])->toArray()
                );
            }
        }
    }
}