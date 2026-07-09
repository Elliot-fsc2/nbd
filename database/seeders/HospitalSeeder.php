<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        Hospital::create(['name' => 'Victoria Memorial Medical Center', 'code' => 'VMC']);
        Hospital::create(['name' => 'Philippine General Hospital', 'code' => 'PGH']);
    }
}
