<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SmsLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'mobile' => '09' . fake()->numerify('#########'),
            'message' => fake()->sentence(8),
            'type' => fake()->randomElement(['manual', 'otp', 'notification']),
            'status' => fake()->randomElement(['pending', 'sent', 'failed']),
            'provider' => 'test-provider',
            'template_key' => fake()->optional()->word(),
            'provider_message_id' => fake()->optional()->uuid(),
            'response' => fake()->optional()->sentence(),
            'error_message' => fake()->optional()->sentence(),
            'user_id' => null,
            'related_type' => null,
            'related_id' => null,
            'sent_at' => fake()->optional()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
