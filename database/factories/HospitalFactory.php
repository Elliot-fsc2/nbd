<?php

namespace Database\Factories;

use App\Models\Hospital;
use Illuminate\Database\Eloquent\Factories\Factory;

class HospitalFactory extends Factory
{
    protected $model = Hospital::class;

    private static array $codes = ['VMMC', 'PGH', 'RedCross', 'UMC'];

    public function definition(): array
    {
        $code = fake()->randomElement(static::$codes);

        return [
            'name' => fake()->company(),
            'code' => $code,
        ];
    }

    public function withCode(string $code): static
    {
        return $this->state(fn () => [
            'code' => $code,
            'name' => match ($code) {
                'VMMC' => 'Veterans Memorial Medical Center',
                'PGH' => 'Philippine General Hospital',
                'RedCross' => 'Red Cross',
                'UMC' => 'De la Salle University Medical Center',
                default => fake()->company(),
            },
        ]);
    }
}
