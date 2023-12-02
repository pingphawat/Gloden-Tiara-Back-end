<?php

namespace Database\Factories;

use App\Models\Examination;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pawn>
 */
class PawnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = User::where('role', 'customer')->get()->random()->national_id;
        $examination = Examination::all()->random()->id;

        return [
            'customer_id' => $customer,
            'examination_id' => $examination,
            'contract_date' => fake()->dateTimeBetween('-1 years'),
            'expiry_date' => fake()->dateTimeBetween('-1 years','+1 years'),
            'interest_rate' => fake()->randomElement([0.1,0.5,0.75]),

            'total_term' => fake()->numberBetween(1,6),
            'fine' => 500,
            'shop_payout_status' => fake()->randomElement(['pending', 'paid']),
            // 'shop_payout_type' => fake()->randomElement(['cash', 'transaction']),
            // 'customer_account' => fake()->numerify('#############'),

            'loan_amount' => fake()->randomFloat(2, 0, 100000),
            'paid_amount' => fake()->randomFloat(2, 0, 100000),
            'paid_term' => fake()->numberBetween(0,6),
            'next_payment' => fake()->dateTimeBetween('-1 years','+1 years'),
            'status' => fake()->randomElement(['finish', 'active'])
        ];
    }
}
