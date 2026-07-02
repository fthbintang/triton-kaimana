<?php

namespace Database\Seeders;

use App\Models\Permohonan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat 50 data tiruan permohonan waarmeking sekaligus
        Permohonan::factory()->count(40)->create();

        Permohonan::factory(40)->kuasaInsidentil()->create();
    }
}