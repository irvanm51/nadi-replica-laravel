<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan_spps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->nullable()->constrained('mahasiswas')->nullOnDelete();
            $table->string('nama_mahasiswa');
            $table->string('semester');
            $table->decimal('nominal', 12, 2);
            $table->enum('status_pembayaran', ['lunas', 'belum_lunas', 'cicilan'])->default('belum_lunas');
            $table->date('tanggal_bayar')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan_spps');
    }
};
