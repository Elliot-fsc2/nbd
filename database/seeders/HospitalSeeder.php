<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        Hospital::firstOrCreate(['code' => 'VMMC'], ['name' => 'Veterans Memorial Medical Center']);
        Hospital::firstOrCreate(['code' => 'PGH'], ['name' => 'Philippine General Hospital']);
        Hospital::firstOrCreate(['code' => 'RedCross'], ['name' => 'Red Cross']);
        Hospital::firstOrCreate(['code' => 'UMC'], ['name' => 'De la Salle University Medical Center']);
    }
}
