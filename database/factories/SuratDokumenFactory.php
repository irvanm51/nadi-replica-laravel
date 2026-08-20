<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\SuratDokumen>
 */
class SuratDokumenFactory extends Factory
{
    public function definition(): array
    {
        $mahasiswa = Mahasiswa::inRandomOrder()->first();

        return [
            'nomor_surat' => fake()->unique()->numerify('###/SK/ITTS/'.now()->year),
            'jenis_surat' => fake()->randomElement([
                'Surat Keterangan Aktif Kuliah', 'Surat Keterangan Lulus', 'Surat Permohonan Cuti',
                'Surat Rekomendasi Beasiswa', 'Surat Keterangan Penelitian',
            ]),
            'mahasiswa_id' => $mahasiswa?->id,
            'nama_pemohon' => $mahasiswa?->nama ?? fake()->name(),
            'tanggal_pengajuan' => fake()->dateTimeBetween('-6 months', 'now'),
            'status' => fake()->randomElement(['diajukan', 'diproses', 'selesai', 'ditolak']),
            'keterangan' => fake()->optional()->sentence(),
        ];
    }
}
