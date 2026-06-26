<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class TraineeFactory extends Factory
{
    public function definition(): array
    {
        $firstNames = ['علی', 'رضا', 'محمد', 'حسین', 'مهدی', 'زهرا', 'فاطمه', 'مریم', 'نگار', 'سارا'];
        $lastNames = ['محمدی', 'حسینی', 'رضایی', 'کریمی', 'مرادی', 'جعفری', 'صادقی', 'امینی', 'قاسمی', 'عباسی'];
        $fatherNames = ['اکبر', 'حسن', 'کریم', 'جواد', 'علی', 'محمد', 'رضا'];

        $totalFee = fake()->numberBetween(2000000, 15000000);
        $discountPercent = fake()->randomElement([0, 5, 10, 15, 20]);

        return [
            'course_id' => Course::query()->inRandomOrder()->value('id'),
            'first_name' => fake()->randomElement($firstNames),
            'last_name' => fake()->randomElement($lastNames),
            'father_name' => fake()->optional()->randomElement($fatherNames),
            'national_code' => fake()->unique()->numerify('##########'),
            'phone' => '09' . fake()->unique()->numerify('#########'),
            'birth_date' => fake()->date('Y-m-d', '-18 years'),
            'registration_status' => fake()->randomElement([
                'ثبت نام شده',
                'انصراف داده',
                'تکمیل شده'
            ]),
            'exam_status' => fake()->randomElement([
                'قبول',
                'رد',
                'در انتظار',
                null
            ]),
            'certificate_status' => fake()->randomElement([
                'صادر شده',
                'صادر نشده',
                'در انتظار',
                null
            ]),
            'total_fee' => $totalFee,
            'discount_percent' => $discountPercent,
            'exam_fee' => fake()->numberBetween(0, 1000000),
            'exam_date' => fake()->optional()->date(),
            'exam_date_shamsi' => null,
            'image' => null,
            'file' => null,
            'note' => fake()->optional()->sentence(),
        ];
    }
}
