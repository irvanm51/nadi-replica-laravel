<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_akademiks', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_laporan');
            $table->string('program_studi');
            $table->string('periode');
            $table->unsignedInteger('jumlah_mahasiswa')->default(0);
            $table->decimal('rata_rata_ipk', 3, 2)->nullable();
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_akademiks');
    }
};
