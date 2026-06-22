<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Ubah nama tabel utama
        Schema::rename('surat_kuasa', 'surat_kuasa_waarmeking');

        // 2. Ubah nama tabel relasi (Pemberi Kuasa)
        Schema::rename('pemberi_kuasa', 'pemberi_kuasa_waarmeking');
        
        // 3. Ubah nama tabel relasi (Penerima Kuasa)
        Schema::rename('penerima_kuasa', 'penerima_kuasa_waarmeking');

        // 4. Sesuaikan nama kolom Foreign Key di dalam tabel relasi
        Schema::table('pemberi_kuasa_waarmeking', function (Blueprint $table) {
            $table->renameColumn('surat_kuasa_id', 'surat_kuasa_waarmeking_id');
        });

        Schema::table('penerima_kuasa_waarmeking', function (Blueprint $table) {
            $table->renameColumn('surat_kuasa_id', 'surat_kuasa_waarmeking_id');
        });
    }

    public function down(): void
    {
        // Kembalikan kolom Foreign Key ke nama semula jika di-rollback
        Schema::table('penerima_kuasa_waarmeking', function (Blueprint $table) {
            $table->renameColumn('surat_kuasa_waarmeking_id', 'surat_kuasa_id');
        });

        Schema::table('pemberi_kuasa_waarmeking', function (Blueprint $table) {
            $table->renameColumn('surat_kuasa_waarmeking_id', 'surat_kuasa_id');
        });

        // Kembalikan nama tabel ke semula
        Schema::rename('penerima_kuasa_waarmeking', 'penerima_kuasa');
        Schema::rename('pemberi_kuasa_waarmeking', 'pemberi_kuasa');
        Schema::rename('surat_kuasa_waarmeking', 'surat_kuasa');
    }
};