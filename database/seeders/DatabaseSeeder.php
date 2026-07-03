<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Payment;
use App\Models\SmsLog;
use App\Models\SmsSetting;
use App\Models\Trainee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        SmsSetting::updateOrCreate(
            ['provider' => 'test-provider'],
            [
                'sms_enabled' => true,
                'auto_sms_enabled' => true,
                'test_mode' => true,
                'provider' => 'test-provider',
                'api_key' => 'test-api-key',
                'sender_number' => '50004000',
                'base_url' => 'https://example.com/api',
            ]
        );

        User::updateOrCreate(
            ['phone' => '09109915180'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ]
        );

        User::factory()
            ->count(3)
            ->create([
                'role' => 'admin'
            ]);

        Course::factory()->count(10)->create();

        $trainees = Trainee::factory()->count(50)->create();

        $trainees->each(function ($trainee) {
            User::updateOrCreate(
                ['phone' => $trainee->phone],
                [
                    'name' => $trainee->full_name,
                    'password' => Hash::make('password'),
                    'role' => 'trainee',
                    'trainee_id' => $trainee->id,
                ]
            );
        });

        $trainees->each(function ($trainee) {
            $paymentCount = rand(0, 3);
            $remaining = (int) ($trainee->final_fee ?? 0);

            for ($i = 0; $i < $paymentCount; $i++) {
                if ($remaining <= 0) {
                    break;
                }

                $min = min(100000, $remaining);
                $max = min($remaining, 3000000);

                $amount = $min > $max
                    ? $remaining
                    : rand($min, $max);

                $remainingAfterPayment = max(0, $remaining - $amount);

                Payment::create([
                    'trainee_id' => $trainee->id,
                    'amount' => $amount,
                    'remaining_after_payment' => $remainingAfterPayment,
                    'payment_type' => $remainingAfterPayment == 0 ? 'full' : 'installment',
                    'payment_method' => fake()->randomElement([
                        'cash',
                        'card',
                        'online'
                    ]),
                    'tracking_code' => fake()->optional()->numerify('TRK######'),
                    'payment_date' => fake()->date(),
                    'payment_date_shamsi' => null,
                    'note' => fake()->optional()->sentence(),
                ]);

                $remaining = $remainingAfterPayment;
            }
        });

        $trainees->each(function ($trainee) {
            $examCount = rand(0, 4);

            for ($i = 0; $i < $examCount; $i++) {
                $examDate = fake()->dateTimeBetween('-1 year', '+3 months');

                Exam::create([
                    'trainee_id' => $trainee->id,
                    'exam_title' => fake()->randomElement([
                        'آزمون پایان دوره',
                        'آزمون میان‌دوره',
                        'آزمون فنی حرفه‌ای',
                        'آزمون داخلی',
                    ]),
                    'exam_date' => $examDate->format('Y-m-d'),
                    'start_time' => fake()->optional()->time('H:i'),
                    'end_time' => fake()->optional()->time('H:i'),
                    'exam_type' => fake()->randomElement([
                        'fanni-herfei',
                        'dakheli',
                        'miandore',
                        'payan_dore',
                    ]),
                    'location' => fake()->optional()->randomElement([
                        'آموزشگاه مرکزی',
                        'شعبه ۱',
                        'شعبه ۲',
                        'سالن آزمون',
                    ]),
                    'status' => fake()->randomElement([
                        'passed',
                        'failed',
                        'absent',
                        'pending',
                    ]),
                    'note' => fake()->optional()->sentence(),
                ]);
            }
        });

        SmsLog::factory()->count(20)->create();
    }
}
