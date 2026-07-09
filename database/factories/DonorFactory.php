<?php

namespace Database\Factories;

use App\Models\Donor;
use App\Models\Hospital;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonorFactory extends Factory
{
    protected $model = Donor::class;

    public function definition(): array
    {
        $surname = fake()->lastName();
        $givenName = fake()->firstName();
        $middleName = fake()->lastName();
        $age = fake()->numberBetween(18, 60);

        return [
            'tracking_code' => 'SAMPLE-'.strtoupper(fake()->bothify('????-####')),
            'donor_type' => fake()->randomElement(['student', 'employee', 'walk-in']),
            'id_number' => fake()->optional()->bothify('ID-####'),
            'full_name' => "$surname, $givenName $middleName",
            'email' => fake()->safeEmail(),
            'contact_number' => fake()->numerify('09#########'),
            'assigned_hospital_id' => Hospital::factory(),
            'data' => [
                'surname' => $surname,
                'given_name' => $givenName,
                'middle_name' => $middleName,
                'birthdate' => fake()->date(max: now()->subYears($age)),
                'age' => $age,
                'sex' => fake()->randomElement(['male', 'female']),
                'civil_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
                'blood_type' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-', 'Unknown']),
                'street' => fake()->streetAddress(),
                'barangay' => fake()->city(),
                'city_province' => fake()->city().', '.fake()->state(),
                'occupation' => fake()->jobTitle(),
                'contact_number' => fake()->numerify('09#########'),
                'email' => fake()->safeEmail(),
                'house_no' => fake()->buildingNumber(),
                'subdivision' => fake()->optional()->word(),
            ],
        ];
    }
}
