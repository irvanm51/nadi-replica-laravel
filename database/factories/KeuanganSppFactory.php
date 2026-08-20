<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\KeuanganSpp>
 */
class KeuanganSppFactory extends Factory
{
    public function definition(): array
    {
        $mahasiswa = Mahasiswa::inRandomOrder()->first();
        $status = fake()->randomElement(['lunas', 'lunas', 'belum_lunas', 'cicilan']);

        return [
            'mahasiswa_id' => $mahasiswa?->id,
            'nama_mahasiswa' => $mahasiswa?->nama ?? fake()->name(),
            'semester' => fake()->randomElement(['Ganjil 2024/2025', 'Genap 2024/2025', 'Ganjil 2025/2026']),
            'nominal' => fake()->randomElement([3500000, 4000000, 4500000, 5000000]),
            'status_pembayaran' => $status,
            'tanggal_bayar' => $status === 'belum_lunas' ? null : fake()->dateTimeBetween('-6 months', 'now'),
            'metode_pembayaran' => $status === 'belum_lunas' ? null : fake()->randomElement(['Transfer Bank', 'Virtual Account', 'Kartu Debit']),
        ];
    }
}
