<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\JadwalMengajar>
 */
class JadwalMengajarFactory extends Factory
{
    public function definition(): array
    {
        $jamMulai = fake()->randomElement(['07:30', '09:00', '10:30', '13:00', '14:30', '16:00']);

        return [
            'dosen_id' => User::where('role', 'dosen')->inRandomOrder()->value('id'),
            'mata_kuliah' => fake()->randomElement([
                'Pemrograman Web', 'Basis Data', 'Struktur Data', 'Kecerdasan Buatan',
                'Jaringan Komputer', 'Rekayasa Perangkat Lunak', 'Sistem Operasi', 'Statistika',
            ]),
            'kelas' => fake()->randomElement(['TI-1A', 'TI-1B', 'SI-2A', 'SI-2B', 'TI-3A']),
            'hari' => fake()->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']),
            'jam_mulai' => $jamMulai,
            'jam_selesai' => date('H:i', strtotime($jamMulai) + 5400),
            'ruangan' => fake()->randomElement(['A101', 'A102', 'B201', 'B202', 'Lab Komputer 1']),
            'sks' => fake()->randomElement([2, 3]),
        ];
    }
}
