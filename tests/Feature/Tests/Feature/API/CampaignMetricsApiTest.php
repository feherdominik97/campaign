<?php

namespace Tests\Feature\API;

use App\Models\Campaign;
use App\Models\CampaignMetrics;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignMetricsApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    /** @test */
    public function it_creates_a_new_campaign_metric()
    {
        $campaign = Campaign::factory()->create();

        $data = [
            'campaign_id' => $campaign->id,
            'date' => now()->toDateString(),
            'impressions' => 1000,
            'clicks' => 50,
            'spend' => 25.00,
            'conversions' => 100,
        ];

        $response = $this->postJson('/api/campaign-metrics', $data);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'campaign_id' => $campaign->id,
            'date' => $data['date'],
            'impressions' => $data['impressions'],
            'clicks' => $data['clicks'],
            'spend' => $data['spend'],
            'conversions' => $data['conversions'],
        ]);

        // Check the database
        $this->assertDatabaseHas('campaign_metrics', $data);
    }

    /** @test */
    public function it_requires_valid_data_to_create_a_campaign_metric()
    {
        $data = [
            'date' => '',
            'impressions' => '',
            'clicks' => '',
        ];

        $response = $this->postJson('/api/campaign-metrics', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['date', 'impressions', 'clicks']);
    }

    /** @test */
    public function it_validates_the_date_range_when_retrieving_campaign_metrics()
    {
        $response = $this->getJson(route('campaign-metrics.analytics', [
            'start_date' => 'invalid-date',
            'end_date' => '2025-01-05',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['start_date']);
    }

    /** @test */
    public function it_handles_empty_results_when_retrieving_campaign_metrics()
    {
        $response = $this->getJson(route('campaign-metrics.analytics', [
            'start_date' => '2025-01-01',
            'end_date' => '2025-01-05',
        ]));

        $response->assertStatus(200);
        $response->assertJson([]);
    }
}
