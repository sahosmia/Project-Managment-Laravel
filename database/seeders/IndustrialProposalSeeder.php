<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\IndustrialProposal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class IndustrialProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $student = User::where('role', 'student')->first();
        $company = Company::first();
        $faculty_member = User::where('role', 'faculty_member')->first();

        if ($student && $company && $faculty_member) {
            for ($i = 0; $i < 5; $i++) {
                IndustrialProposal::create([
                    'user_id' => $student->id,
                    'skills' => implode(', ', $faker->words(3)),
                    'company' =>"abc",
                    'supervisor_id' => $faculty_member->id,
                    'status' => $faker->randomElement(['pending', 'inprogress', 'complete']),
                ]);
            }
        }
    }
}
