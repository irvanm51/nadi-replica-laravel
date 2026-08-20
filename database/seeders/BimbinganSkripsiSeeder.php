<?php

namespace Database\Seeders;

use App\Models\BimbinganSkripsi;
use Illuminate\Database\Seeder;

class BimbinganSkripsiSeeder extends Seeder
{
    public function run(): void
    {
        BimbinganSkripsi::factory()->count(15)->create();
    }
}
