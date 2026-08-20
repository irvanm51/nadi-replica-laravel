<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Demo accounts with usable local passwords only make sense outside
        // production now that all real access goes through Teleport.
        if (! app()->environment(['local', 'testing'])) {
            return;
        }

        User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'staf@nadi.ac.id',
            'password' => Hash::make('password'),
            'role' => 'staf',
        ]);

        User::factory()->create([
            'name' => 'Dr. Siti Aminah',
            'email' => 'dosen@nadi.ac.id',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        User::factory()->count(4)->create(['role' => 'dosen']);
    }
}
