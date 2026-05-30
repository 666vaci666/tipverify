<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'match_teams' => fake()->city() . ' vs ' . fake()->city(),
            'prediction'  => fake()->randomElement(['1', 'X', '2', 'Over 2.5', 'Under 2.5', 'BTTS']),
            'odds'        => fake()->randomFloat(2, 1.10, 10.00),
            'status'      => fake()->randomElement(['pending', 'win', 'loss', 'void']),
            'match_date'  => fake()->dateTimeBetween('-3 months', '+1 month')->format('Y-m-d'),
        ];
    }
}