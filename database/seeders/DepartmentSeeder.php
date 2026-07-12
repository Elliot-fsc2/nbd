<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Computer Studies'],
            ['name' => 'Business Administration'],
            ['name' => 'EdPsyComm'],
            ['name' => 'Criminal Justice'],
            ['name' => 'HTMD'],
            ['name' => 'Architecture'],
            ['name' => 'Engineering'],
            ['name' => 'Accounting'],
            ['name' => 'Real Estate Management'],
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate(['name' => $department['name']]);
        }
    }
}
