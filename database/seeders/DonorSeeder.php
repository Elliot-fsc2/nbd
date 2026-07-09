<?php

namespace Database\Seeders;

use App\Models\Donor;
use Illuminate\Database\Seeder;

class DonorSeeder extends Seeder
{
    public function run(): void
    {
        $donors = [
            [
                'tracking_code' => 'TRC-000001',
                'donor_type' => 'student',
                'id_number' => '2024-001',
                'full_name' => 'Dela Cruz, Juan',
                'email' => 'juan@example.com',
                'contact_number' => '09171234567',
                'assigned_hospital_id' => 1,
                'data' => [
                    'surname' => 'Dela Cruz',
                    'given_name' => 'Juan',
                    'middle_name' => 'Santos',
                    'birthdate' => '2000-01-15',
                    'age' => 26,
                    'sex' => 'male',
                    'civil_status' => 'single',
                    'blood_type' => 'O+',
                    'occupation' => 'Student',
                    'email' => 'juan@example.com',
                    'contact_number' => '09171234567',
                ],
            ],
            [
                'tracking_code' => 'TRC-000002',
                'donor_type' => 'student',
                'id_number' => '2024-002',
                'full_name' => 'Santos, Maria',
                'email' => 'maria@example.com',
                'contact_number' => '09179876543',
                'assigned_hospital_id' => 2,
                'data' => [
                    'surname' => 'Santos',
                    'given_name' => 'Maria',
                    'middle_name' => 'Lopez',
                    'birthdate' => '2001-06-20',
                    'age' => 25,
                    'sex' => 'female',
                    'civil_status' => 'single',
                    'blood_type' => 'A+',
                    'occupation' => 'Student',
                    'email' => 'maria@example.com',
                    'contact_number' => '09179876543',
                ],
            ],
            [
                'tracking_code' => 'TRC-000003',
                'donor_type' => 'employee',
                'id_number' => 'EMP-001',
                'full_name' => 'Reyes, Pedro',
                'email' => 'pedro@example.com',
                'contact_number' => '09175551234',
                'assigned_hospital_id' => 1,
                'data' => [
                    'surname' => 'Reyes',
                    'given_name' => 'Pedro',
                    'middle_name' => 'Garcia',
                    'birthdate' => '1990-03-10',
                    'age' => 36,
                    'sex' => 'male',
                    'civil_status' => 'married',
                    'blood_type' => 'B+',
                    'occupation' => 'Teacher',
                    'email' => 'pedro@example.com',
                    'contact_number' => '09175551234',
                ],
            ],
        ];

        foreach ($donors as $donor) {
            Donor::create($donor);
        }
    }
}
