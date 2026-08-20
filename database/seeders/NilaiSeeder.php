<?php

namespace Database\Seeders;

use App\Models\Nilai;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        Nilai::factory()->count(40)->create();
    }
}
