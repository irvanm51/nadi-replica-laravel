<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\BimbinganSkripsi>
 */
class BimbinganSkripsiFactory extends Factory
{
    public function definition(): array
    {
        $mahasiswa = Mahasiswa::inRandomOrder()->first();

        return [
            'mahasiswa_id' => $mahasiswa?->id,
            'nama_mahasiswa' => $mahasiswa?->nama ?? fake()->name(),
            'judul_skripsi' => fake()->randomElement([
                'Sistem Informasi Akademik Berbasis Web',
                'Implementasi Machine Learning untuk Prediksi Kelulusan Mahasiswa',
                'Rancang Bangun Aplikasi Presensi Berbasis QR Code',
                'Analisis Sentimen Media Sosial Menggunakan Naive Bayes',
                'Sistem Pendukung Keputusan Pemilihan Beasiswa',
            ]),
            'tanggal_bimbingan' => fake()->dateTimeBetween('-3 months', 'now'),
            'bimbingan_ke' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(['proses', 'revisi', 'acc_sidang', 'selesai']),
            'catatan' => fake()->optional()->sentence(8),
        ];
    }
}
