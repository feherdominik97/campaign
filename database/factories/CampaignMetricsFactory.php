<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CampaignMetrics>
 */
class CampaignMetricsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'impressions' => $this->faker->numberBetween(1000, 1000000),
            'clicks' => $this->faker->numberBetween(0, 100000),
            'spend' => $this->faker->randomFloat(2, 0, 10000),
            'conversions' => $this->faker->randomFloat(2, 0, 5000),
        ];
    }
}
