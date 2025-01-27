<?php

namespace Database\Seeders;

use App\Models\CampaignMetrics;
use Illuminate\Database\Seeder;

class CampaignMetricsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CampaignMetrics::factory()->count(10)->create();
    }
}
