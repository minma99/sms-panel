<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'دوره لاراول',
            'دوره PHP',
            'دوره جاوااسکریپت',
            'دوره طراحی سایت',
            'دوره بوت استرپ',
            'دوره هوش مصنوعی',
            'دوره ICDL',
            'دوره اکسل پیشرفته',
        ];

        $startDate = fake()->dateTimeBetween('-2 months', '+2 months');
        $endDate = (clone $startDate)->modify('+' . fake()->numberBetween(15, 90) . ' days');

        return [
            'title' => fake()->randomElement($titles),
            'price' => fake()->numberBetween(1500000, 12000000),
            'duration' => fake()->numberBetween(10, 120),
            'capacity' => fake()->numberBetween(5, 40),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'start_date_shamsi' => null,
            'end_date_shamsi' => null,
            'description' => fake()->sentence(10),
        ];
    }
}
