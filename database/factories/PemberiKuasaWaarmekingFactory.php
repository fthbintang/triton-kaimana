<?php

namespace Database\Factories;

use App\Models\PemberiKuasaWaarmeking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PemberiKuasaWaarmeking>
 */
class PemberiKuasaWaarmekingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama'              => $this->faker->name(),
            'nik'               => $this->faker->numerify('9102##############'), // Pola NIK Papua Barat / Kaimana
            'jenis_kelamin'     => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'agama'             => $this->faker->randomElement(['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Budha']),
            'pekerjaan'         => $this->faker->randomElement(['PNS', 'Karyawan Swasta', 'Wiraswasta', 'Petani', 'Nelayan']),
            'alamat'            => $this->faker->address(),
            'urutan_ahli_waris' => 'Ahli Waris ' . $this->faker->numberBetween(2, 5), // Ahli waris ke-2 dst yang absen
        ];
    }
}