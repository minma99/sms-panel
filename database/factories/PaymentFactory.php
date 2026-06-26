<?php

namespace Database\Factories;

use App\Models\Trainee;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'trainee_id' => Trainee::query()->inRandomOrder()->value('id'),
            'amount' => fake()->numberBetween(100000, 5000000),
            'remaining_after_payment' => fake()->numberBetween(0, 5000000),
            'payment_type' => fake()->randomElement(['full', 'installment']),
            'payment_method' => fake()->randomElement(['cash', 'card', 'online']),
            'tracking_code' => fake()->optional()->numerify('TRK######'),
            'payment_date' => fake()->date(),
            'payment_date_shamsi' => null,
            'note' => fake()->optional()->sentence(),
        ];
    }
}
