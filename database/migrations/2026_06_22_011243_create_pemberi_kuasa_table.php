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
        Schema::create('pemberi_kuasa', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel utama, data otomatis terhapus jika induk dihapus
            $table->foreignId('surat_kuasa_id')->constrained('surat_kuasa')->onDelete('cascade');
            
            $table->string('nama');
            $table->string('nik', 16);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('agama');
            $table->string('pekerjaan');
            $table->text('alamat');
            $table->string('urutan_ahli_waris'); // Otomatis terisi: "Ahli Waris 1", "Ahli Waris 2", dst.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberi_kuasa');
    }
};