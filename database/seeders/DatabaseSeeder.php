<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            SettingsSeeder::class,
            ProjectSeeder::class,
            CompanySeeder::class,
            IndustrialProposalSeeder::class,

        ]);
    }
}
