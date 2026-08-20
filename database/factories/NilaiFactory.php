<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Nilai>
 */
class NilaiFactory extends Factory
{
    public function definition(): array
    {
        $mahasiswa = Mahasiswa::inRandomOrder()->first();
        $tugas = fake()->numberBetween(60, 100);
        $uts = fake()->numberBetween(55, 100);
        $uas = fake()->numberBetween(55, 100);
        $akhir = ($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4);

        return [
            'mahasiswa_id' => $mahasiswa?->id,
            'nama_mahasiswa' => $mahasiswa?->nama ?? fake()->name(),
            'mata_kuliah' => fake()->randomElement([
                'Pemrograman Web', 'Basis Data', 'Struktur Data', 'Kecerdasan Buatan', 'Jaringan Komputer',
            ]),
            'nilai_tugas' => $tugas,
            'nilai_uts' => $uts,
            'nilai_uas' => $uas,
            'nilai_akhir' => match (true) {
                $akhir >= 85 => 'A',
                $akhir >= 75 => 'B',
                $akhir >= 65 => 'C',
                $akhir >= 50 => 'D',
                default => 'E',
            },
        ];
    }
}
