<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password = null;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => '09' . fake()->unique()->numerify('#########'),
            'password' => static::$password ??= Hash::make('password'),
            'otp' => null,
            'otp_expires_at' => null,
            'role' => 'admin',
            'trainee_id' => null,
            'remember_token' => Str::random(10),
        ];
    }

    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'phone' => '09109915180',
            'role' => 'super_admin',
        ]);
    }
}
