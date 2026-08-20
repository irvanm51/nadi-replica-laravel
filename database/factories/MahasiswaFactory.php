<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    public function definition(): array
    {
        $angkatan = fake()->numberBetween(2020, 2025);
        $programStudi = fake()->randomElement([
            'Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi',
        ]);

        return [
            'nim' => $angkatan.fake()->unique()->numerify('####'),
            'nama' => fake()->name(),
            'program_studi' => $programStudi,
            'angkatan' => $angkatan,
            'semester' => fake()->numberBetween(1, 8),
            'status' => fake()->randomElement(['aktif', 'aktif', 'aktif', 'cuti', 'lulus', 'DO']),
            'email' => fake()->unique()->safeEmail(),
            'no_hp' => fake()->numerify('08##########'),
        ];
    }
}
