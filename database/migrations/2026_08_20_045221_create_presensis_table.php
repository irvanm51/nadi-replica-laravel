<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->nullable()->constrained('mahasiswas')->nullOnDelete();
            $table->string('nama_mahasiswa');
            $table->string('mata_kuliah');
            $table->date('tanggal');
            $table->enum('status_kehadiran', ['hadir', 'izin', 'sakit', 'alpa'])->default('hadir');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
