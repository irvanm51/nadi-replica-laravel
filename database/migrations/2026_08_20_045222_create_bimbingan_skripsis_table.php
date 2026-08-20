<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bimbingan_skripsis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->nullable()->constrained('mahasiswas')->nullOnDelete();
            $table->string('nama_mahasiswa');
            $table->string('judul_skripsi');
            $table->date('tanggal_bimbingan');
            $table->unsignedTinyInteger('bimbingan_ke');
            $table->enum('status', ['proses', 'revisi', 'acc_sidang', 'selesai'])->default('proses');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bimbingan_skripsis');
    }
};
