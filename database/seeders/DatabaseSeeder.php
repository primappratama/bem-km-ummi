<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KementerianSeeder::class,
            SettingsSeeder::class,
            UserSeeder::class,
            PengurusSeeder::class,
            ProgramKerjaSeeder::class,
        ]);
    }
}
