<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            HospitalSeeder::class,
            DepartmentSeeder::class,
            CourseSeeder::class,
            UserSeeder::class,
            BloodDonationEventSeeder::class,
            DonorSeeder::class,
            EventRegistrationSeeder::class,
        ]);
    }
}
