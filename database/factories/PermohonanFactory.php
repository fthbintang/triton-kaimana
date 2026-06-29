<?php

namespace Database\Factories;

use App\Models\Permohonan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Permohonan>
 */
class PermohonanFactory extends Factory
{
    protected $model = Permohonan::class;

    public function definition(): array
    {
        // Menyusun daftar bank tiruan
        $daftarBank = ['Bank Mandiri', 'BRI', 'BNI', 'BCA', 'Bank Papua'];
        $pekerjaan = ['PNS', 'Karyawan Swasta', 'Wiraswasta', 'Petani', 'Nelayan'];
        $agama = ['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha'];

        // Buat array dinamis untuk daftar_rekening (1 sampai 3 rekening acak)
        $daftarRekening = [];
        $jumlahRekening = fake()->numberBetween(1, 3);
        for ($i = 0; $i < $jumlahRekening; $i++) {
            $daftarRekening[] = [
                'nama_bank' => fake()->randomElement($daftarBank),
                'cabang_bank' => 'KCP Kaimana ' . fake()->city(),
                'nomor_rekening' => fake()->numerify('##########'),
                'nominal_angka' => fake()->numberBetween(5000000, 75000000), // Angka murni sesuai validasi
            ];
        }

        // Array pemetaan angka romawi untuk urutan anak (ahli waris tambahan)
        $romawiAhliWaris = ['I', 'II', 'III', 'IV', 'V'];

        // Buat array dinamis untuk pemohon_tambahan (opsional, 0 sampai 2 orang)
        $pemohonTambahan = [];
        $jumlahTambahan = fake()->numberBetween(0, 2);
        for ($j = 0; $j < $jumlahTambahan; $j++) {
            $pemohonTambahan[] = [
                'nama' => fake()->name(),
                'nik' => fake()->numerify('9102############'), // Pola NIK Papua Barat
                'urutan_ahli_waris' => 'Ahli Waris ' . ($romawiAhliWaris[$j] ?? 'I'), // <--- TAMBAHAN: Otomatis Ahli Waris I, II, dst.
                'tempat_lahir' => fake()->city(),
                'tanggal_lahir' => fake()->date('Y-m-d', '-20 years'),
                'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
                'agama' => fake()->randomElement($agama),
                'pekerjaan' => fake()->randomElement($pekerjaan),
                'alamat' => fake()->address(),
            ];
        }

        // Struktur JSON data_spesifik
        $dataSpesifik = [
            'urutan_ahli_waris' => fake()->randomElement(['Istri Pewaris', 'Suami Pewaris']), // <--- TAMBAHAN: Untuk Pemohon Utama
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->date('Y-m-d', '-30 years'),
            'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'pekerjaan' => fake()->randomElement($pekerjaan),
            'agama' => fake()->randomElement($agama),
            'alamat' => fake()->address(),
            'nama_pewaris' => fake()->name('male'),
            'daftar_rekening' => $daftarRekening,
            'pemohon_tambahan' => $pemohonTambahan,
        ];

        return [
            'jenis_naskah' => 'waarmeking',
            'nama_pemohon' => fake()->name(),
            'nik_pemohon' => fake()->numerify('9102############'),
            'no_hp_pemohon' => fake()->numerify('081###########'),
            'data_spesifik' => $dataSpesifik, // Laravel otomatis mengubah array ini ke JSON saat saves
            'created_at' => fake()->dateTimeBetween('-1 months', 'now'),
        ];
    }
}