<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Otp;
use App\Models\Payment;
use App\Models\SmsLog;
use App\Models\SmsSetting;
use App\Models\Trainee;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // SMS Setting
        SmsSetting::factory()->create([
            'sms_enabled' => true,
            'auto_sms_enabled' => true,
            'test_mode' => true,
            'provider' => 'test-provider',
            'api_key' => 'test-api-key',
            'sender_number' => '50004000',
            'base_url' => 'https://example.com/api',
        ]);

        // Super Admin
        User::factory()->superAdmin()->create([
            'name' => 'Super Admin',
            'password' => 'password',
        ]);

        // Admins
        User::factory()->count(3)->create([
            'role' => 'admin',
        ]);

        // Courses
        Course::factory()->count(10)->create();

        // Trainees
        Trainee::factory()->count(50)->create();

        // Payments for trainees
        Trainee::all()->each(function ($trainee) {
            $paymentCount = rand(0, 3);
            $remaining = $trainee->final_fee;

            for ($i = 0; $i < $paymentCount; $i++) {
                if ($remaining <= 0) {
                    break;
                }

                $min = min(100000, $remaining);
                $max = min($remaining, 3000000);

                if ($min > $max) {
                    $amount = $remaining;
                } else {
                    $amount = rand($min, $max);
                }

                $remainingAfterPayment = max(0, $remaining - $amount);

                Payment::create([
                    'trainee_id' => $trainee->id,
                    'amount' => $amount,
                    'remaining_after_payment' => $remainingAfterPayment,
                    'payment_type' => $remainingAfterPayment == 0 ? 'full' : 'installment',
                    'payment_method' => fake()->randomElement(['cash', 'card', 'online']),
                    'tracking_code' => fake()->optional()->numerify('TRK######'),
                    'payment_date' => fake()->date(),
                    'payment_date_shamsi' => null,
                    'note' => fake()->optional()->sentence(),
                ]);

                $remaining = $remainingAfterPayment;
            }
        });

        // OTPs
        Otp::factory()->count(10)->create();

        // SMS Logs
        SmsLog::factory()->count(20)->create();
    }
}
