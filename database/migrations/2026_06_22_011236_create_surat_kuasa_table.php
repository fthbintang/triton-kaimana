<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_kuasa', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kuasa');
            $table->string('no_hp_pemohon'); // Kontak utama pengisi formulir
            $table->timestamps(); // Mencatat pendaftar terbaru secara otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_kuasa');
    }
};