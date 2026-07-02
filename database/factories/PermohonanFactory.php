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
        // ==========================================
        // DATA BAWAAN (DEFAULT): WAARMEKING
        // ==========================================
        $daftarBank = ['Bank Mandiri', 'BRI', 'BNI', 'BCA', 'Bank Papua'];
        $pekerjaan = ['PNS', 'Karyawan Swasta', 'Wiraswasta', 'Petani', 'Nelayan'];
        $agama = ['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha'];

        $daftarRekening = [];
        $jumlahRekening = fake()->numberBetween(1, 3);
        for ($i = 0; $i < $jumlahRekening; $i++) {
            $daftarRekening[] = [
                'nama_bank' => fake()->randomElement($daftarBank),
                'cabang_bank' => 'KCP Kaimana ' . fake()->city(),
                'nomor_rekening' => fake()->numerify('##########'),
                'nominal_angka' => fake()->numberBetween(5000000, 75000000),
            ];
        }

        $romawiAhliWaris = ['I', 'II', 'III', 'IV', 'V'];
        $pemohonTambahan = [];
        $jumlahTambahan = fake()->numberBetween(0, 2);
        for ($j = 0; $j < $jumlahTambahan; $j++) {
            $pemohonTambahan[] = [
                'nama' => fake()->name(),
                'nik' => fake()->numerify('9102############'),
                'urutan_ahli_waris' => 'Ahli Waris ' . ($romawiAhliWaris[$j] ?? 'I'),
                'tempat_lahir' => fake()->city(),
                'tanggal_lahir' => fake()->date('Y-m-d', '-20 years'),
                'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
                'agama' => fake()->randomElement($agama),
                'pekerjaan' => fake()->randomElement($pekerjaan),
                'alamat' => fake()->address(),
            ];
        }

        $dataSpesifikWaarmeking = [
            'urutan_ahli_waris' => fake()->randomElement(['Istri Pewaris', 'Suami Pewaris']),
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
            'data_spesifik' => $dataSpesifikWaarmeking,
            'created_at' => fake()->dateTimeBetween('-1 months', 'now'),
        ];
    }

    /**
     * State Khusus untuk Kuasa Insidentil
     */
    public function kuasaInsidentil(): static
    {
        return $this->state(function (array $attributes) {
            $pekerjaan = ['PNS', 'Karyawan Swasta', 'Wiraswasta', 'Petani', 'Nelayan'];
            $agama = ['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha'];
            $kedudukan = ['Penggugat', 'Tergugat', 'Pemohon', 'Termohon'];
            $hubungan = ['Anak Kandung', 'Istri Kandung', 'Suami Kandung', 'Saudara Kandung'];

            // Menyusun data spesifik sesuai struktur Array Save Kuasa Insidentil Anda
            $dataSpesifikKuasa = [
                'penerima' => [
                    'tempat_lahir'      => fake()->city(),
                    'tanggal_lahir'     => fake()->date('Y-m-d', '-25 years'),
                    'jenis_kelamin'     => fake()->randomElement(['Laki-laki', 'Perempuan']),
                    'agama'             => fake()->randomElement($agama),
                    'pekerjaan'         => fake()->randomElement($pekerjaan),
                    'alamat'            => fake()->address(),
                    'hubungan_keluarga' => fake()->randomElement($hubungan),
                ],
                'pemberi' => [
                    'nama'              => fake()->name(),
                    'nik'               => fake()->numerify('9102############'),
                    'tempat_lahir'      => fake()->city(),
                    'tanggal_lahir'     => fake()->date('Y-m-d', '-50 years'),
                    'jenis_kelamin'     => fake()->randomElement(['Laki-laki', 'Perempuan']),
                    'agama'             => fake()->randomElement($agama),
                    'pekerjaan'         => fake()->randomElement($pekerjaan),
                    'alamat'            => fake()->address(),
                    'hubungan_keluarga' => fake()->randomElement($hubungan),
                ],
                'perkara' => [
                    'tujuan_pimpinan'    => 'Ketua Pengadilan Negeri Kaimana',
                    'kedudukan_pemberi'  => fake()->randomElement($kedudukan),
                    'jenis_perkara'      => 'Gugatan Perdata Wanprestasi Nomor ' . fake()->numerify('##/Pdt.G/2026/PN Kmn'),
                    'alasan_tidak_hadir' => 'Sedang sakit keras dan menjalani perawatan intensif diluar kota',
                    'tujuan_kuasa'       => 'Mendampingi, menghadiri persidangan, membela hak-hak pemberi kuasa, menyerahkan bukti, dan menandatangani surat-surat terkait perkara',
                ]
            ];

            return [
                'jenis_naskah' => 'kuasa_insidentil',
                'data_spesifik' => $dataSpesifikKuasa,
            ];
        });
    }
}