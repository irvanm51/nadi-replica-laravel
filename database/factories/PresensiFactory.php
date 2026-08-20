<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Presensi>
 */
class PresensiFactory extends Factory
{
    public function definition(): array
    {
        $mahasiswa = Mahasiswa::inRandomOrder()->first();
        $status = fake()->randomElement(['hadir', 'hadir', 'hadir', 'izin', 'sakit', 'alpa']);

        return [
            'mahasiswa_id' => $mahasiswa?->id,
            'nama_mahasiswa' => $mahasiswa?->nama ?? fake()->name(),
            'mata_kuliah' => fake()->randomElement([
                'Pemrograman Web', 'Basis Data', 'Struktur Data', 'Kecerdasan Buatan', 'Jaringan Komputer',
            ]),
            'tanggal' => fake()->dateTimeBetween('-2 months', 'now'),
            'status_kehadiran' => $status,
            'keterangan' => $status === 'hadir' ? null : fake()->optional()->sentence(4),
        ];
    }
}
