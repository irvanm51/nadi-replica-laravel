<?php

namespace Database\Seeders;

use App\Models\LaporanAkademik;
use Illuminate\Database\Seeder;

class LaporanAkademikSeeder extends Seeder
{
    public function run(): void
    {
        LaporanAkademik::factory()->count(10)->create();
    }
}
