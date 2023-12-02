<?php

namespace Database\Factories;

use App\Models\Examination;
use App\Models\Pawn;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gold>
 */
class GoldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $examination = Examination::all()->random()->id;
        $pawn = Pawn::all()->random()->id;

        return [
            'pawn_id' => $pawn,
            'examination_id' => $examination,
            'weight' => fake()->randomFloat(2, 0.1, 10),
            'purity' => fake()->randomElement([40,50,80,90,96.5,99.9]),
            'image_path' => null,
            'status' => fake()->randomElement(['examining', 'verified', 'unverified','pawned', 'redeemed', 'unredeemed'])
        ];
    }
}
