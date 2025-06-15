<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', '+1 year');
        $endDate = $this->faker->dateTimeBetween($startDate, '+2 years');

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->randomElement([
                'Service Agreement',
                'Consulting Contract',
                'Development Agreement',
                'Maintenance Contract',
                'Marketing Services'
            ]),
            'description' => $this->faker->paragraph(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement(['draft', 'active', 'expired', 'terminated']),
            'amount' => $this->faker->randomFloat(2, 1000, 50000),
            'terms' => $this->faker->paragraphs(3, true),
        ];
    }

    public function draft()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'draft',
            ];
        });
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
                'start_date' => now()->subDays($this->faker->numberBetween(1, 30)),
                'end_date' => now()->addDays($this->faker->numberBetween(60, 365)),
            ];
        });
    }

    public function expired()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'expired',
                'start_date' => now()->subDays($this->faker->numberBetween(400, 500)),
                'end_date' => now()->subDays($this->faker->numberBetween(30, 100)),
            ];
        });
    }

    public function terminated()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'terminated',
                'start_date' => now()->subDays($this->faker->numberBetween(100, 200)),
                'end_date' => now()->subDays($this->faker->numberBetween(1, 50)),
            ];
        });
    }
}
