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
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();

            // Data Utama Pemohon (Diinput masyarakat dari HP)
            $table->string('jenis_naskah');
            $table->string('nama_pemohon');
            $table->string('nik_pemohon', 16);
            $table->string('no_hp_pemohon');
            
            // Data Spesifik (Tempat/tgl lahir, Agama, Pekerjaan dll)
            $table->json('data_spesifik')->nullable(); 
            
            // Status awal otomatis 'tunda' ketika masyarakat selesai mengisi form
            $table->string('status')->default('tunda'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan');
    }
};