<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\LaporanAkademik>
 */
class LaporanAkademikFactory extends Factory
{
    public function definition(): array
    {
        return [
            'jenis_laporan' => fake()->randomElement([
                'Laporan IPK Semester', 'Laporan Kelulusan', 'Laporan Mahasiswa Aktif', 'Laporan Cuti Akademik',
            ]),
            'program_studi' => fake()->randomElement([
                'Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi',
            ]),
            'periode' => fake()->randomElement(['Ganjil 2024/2025', 'Genap 2024/2025', 'Ganjil 2025/2026']),
            'jumlah_mahasiswa' => fake()->numberBetween(30, 200),
            'rata_rata_ipk' => fake()->randomFloat(2, 2.75, 3.9),
            'status' => fake()->randomElement(['draft', 'final']),
        ];
    }
}
