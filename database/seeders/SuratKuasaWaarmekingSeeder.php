<?php

namespace Database\Seeders;

use App\Models\SuratKuasaWaarmeking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuratKuasaWaarmekingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kumpulan opsi status silsilah standar aplikasi
        $opsiSilsilah = ['Istri Pewaris', 'Ahli Waris I', 'Ahli Waris II', 'Ahli Waris III', 'Ahli Waris IV', 'Ahli Waris V'];

        // Membuat 25 data Surat Kuasa Tiruan dengan kombinasi acak
        for ($i = 0; $i < 25; $i++) {
            
            // 1. Buat data Induk Surat Kuasa
            $suratKuasa = SuratKuasaWaarmeking::create([
                'no_hp_pemohon' => '08' . fake()->numerify('##########'),
            ]);

            // 2. ACAK JUMLAH PEMBERI KUASA (1 sampai 3 orang)
            $jumlahPemberi = rand(1, 3);
            for ($j = 0; $j < $jumlahPemberi; $j++) {
                $suratKuasa->pemberiKuasa()->create([
                    'nama'              => fake()->name(),
                    'nik'               => fake()->numerify('9102############'),
                    'jenis_kelamin'     => fake()->randomElement(['Laki-laki', 'Perempuan']),
                    'agama'             => fake()->randomElement(['Islam', 'Kristen Protestan', 'Katolik']),
                    'pekerjaan'         => fake()->randomElement(['Wiraswasta', 'Petani', 'Ibu Rumah Tangga']),
                    'alamat'            => fake()->address(),
                    'urutan_ahli_waris' => $opsiSilsilah[$j] ?? 'Ahli Waris V',
                ]);
            }

            // 3. ACAK JUMLAH PENERIMA KUASA (1 sampai 3 orang)
            $jumlahPenerima = rand(1, 3);
            for ($k = 0; $k < $jumlahPenerima; $k++) {
                // Agar simulasi logis, penerima kuasa biasanya mengambil silsilah sisa dari yang belum dipakai pemberi
                $indexSilsilahPenerima = $jumlahPemberi + $k;

                $suratKuasa->penerimaKuasa()->create([
                    'nama'              => fake()->name(),
                    'nik'               => fake()->numerify('9102############'),
                    'jenis_kelamin'     => fake()->randomElement(['Laki-laki', 'Perempuan']),
                    'agama'             => fake()->randomElement(['Islam', 'Kristen Protestan', 'Katolik']),
                    'pekerjaan'         => fake()->randomElement(['PNS', 'Wiraswasta', 'Karyawan Swasta']),
                    'alamat'            => fake()->address(),
                    'urutan_ahli_waris' => $opsiSilsilah[$indexSilsilahPenerima] ?? 'Ahli Waris V',
                ]);
            }
        }
    }
}