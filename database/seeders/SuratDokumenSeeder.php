<?php

namespace Database\Seeders;

use App\Models\SuratDokumen;
use Illuminate\Database\Seeder;

class SuratDokumenSeeder extends Seeder
{
    public function run(): void
    {
        SuratDokumen::factory()->count(20)->create();
    }
}
