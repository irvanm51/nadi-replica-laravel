<?php

namespace Database\Seeders;

use App\Models\KeuanganSpp;
use Illuminate\Database\Seeder;

class KeuanganSppSeeder extends Seeder
{
    public function run(): void
    {
        KeuanganSpp::factory()->count(30)->create();
    }
}
