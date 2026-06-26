<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SmsSettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sms_enabled' => true,
            'auto_sms_enabled' => fake()->boolean(),
            'test_mode' => true,
            'provider' => 'test-provider',
            'api_key' => fake()->sha1(),
            'sender_number' => '50004000',
            'base_url' => 'https://example.com/api',
        ];
    }
}
