<?php

namespace Database\Factories;

use App\Models\PenerimaKuasaWaarmeking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PenerimaKuasaWaarmeking>
 */
class PenerimaKuasaWaarmekingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama'            => $this->faker->name(),
            'nik'             => $this->faker->numerify('9102##############'),
            'jenis_kelamin'   => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'agama'           => $this->faker->randomElement(['Islam', 'Kristen Protestan', 'Katolik']),
            'pekerjaan'       => $this->faker->randomElement(['PNS', 'Wiraswasta', 'Advokat']),
            'alamat'          => $this->faker->address(),
            'status_penerima' => $this->faker->randomElement(['Ahli Waris 1 (Perwakilan Keluarga)', 'Kuasa Hukum / Pengacara']),
        ];
    }
}