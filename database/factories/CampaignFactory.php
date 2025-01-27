<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->title,
            'status' => $this->faker->randomElement(['active', 'paused', 'completed']),
            'daily_budget' => $this->faker->numberBetween(100000, 1000000),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
        ];
    }
}
