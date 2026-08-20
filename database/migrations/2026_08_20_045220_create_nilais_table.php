<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->nullable()->constrained('mahasiswas')->nullOnDelete();
            $table->string('nama_mahasiswa');
            $table->string('mata_kuliah');
            $table->decimal('nilai_tugas', 5, 2);
            $table->decimal('nilai_uts', 5, 2);
            $table->decimal('nilai_uas', 5, 2);
            $table->string('nilai_akhir', 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
