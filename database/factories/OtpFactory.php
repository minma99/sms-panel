<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OtpFactory extends Factory
{
    public function definition(): array
    {
        return [
            'phone' => '09' . fake()->unique()->numerify('#########'),
            'code' => fake()->numerify('######'),
            'expires_at' => now()->addMinutes(rand(1, 5)),
        ];
    }
}
