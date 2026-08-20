<?php

namespace Database\Seeders;

use App\Models\Presensi;
use Illuminate\Database\Seeder;

class PresensiSeeder extends Seeder
{
    public function run(): void
    {
        Presensi::factory()->count(60)->create();
    }
}
