<?php

namespace Database\Seeders;

use App\Models\JadwalMengajar;
use Illuminate\Database\Seeder;

class JadwalMengajarSeeder extends Seeder
{
    public function run(): void
    {
        JadwalMengajar::factory()->count(15)->create();
    }
}
