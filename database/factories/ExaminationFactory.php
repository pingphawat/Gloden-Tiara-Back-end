<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Examination>
 */
class ExaminationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = User::where('role', 'customer')->get()->random()->national_id;

        return [
            'customer_id' => $customer,
            'contract_date' => fake()->dateTimeBetween('-1 years'),
            'status' => fake()->randomElement(['inprogress', 'finish'])
        ];
    }
}
