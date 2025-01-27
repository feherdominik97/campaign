<?php

namespace Tests\Feature;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignApiTest extends TestCase
{
    use RefreshDatabase;
    public function test_store_campaign()
    {
        $data = [
            'name' => 'Summer Campaign',
            'start_date' => '2025-06-01',
            'end_date' => '2025-07-01',
            'daily_budget' => 20000.00,
        ];

        $response = $this->json('POST', '/api/campaigns', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Summer Campaign']);

        $this->assertDatabaseHas('campaigns', [
            'name' => 'Summer Campaign',
        ]);
    }

    public function test_show_campaign()
    {
        $campaign = Campaign::factory()->create();

        $response = $this->json('GET', "/api/campaigns/{$campaign->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $campaign->name]);

        $response->assertJson([
            'id' => $campaign->id,
            'name' => $campaign->name,
            'start_date' => $campaign->start_date,
            'end_date' => $campaign->end_date,
            'daily_budget' => $campaign->daily_budget,
        ]);
    }

    public function test_update_campaign()
    {
        $campaign = Campaign::factory()->create();

        $updatedData = [
            'name' => 'Updated Campaign Name',
            'start_date' => '2025-06-10',
            'end_date' => '2025-07-10',
            'daily_budget' => 30000.00,
        ];

        $response = $this->json('PUT', "/api/campaigns/{$campaign->id}", $updatedData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'name' => 'Updated Campaign Name',
            'daily_budget' => 30000.00,
        ]);
    }

    public function test_destroy_campaign()
    {
        $campaign = Campaign::factory()->create();

        $response = $this->json('DELETE', "/api/campaigns/{$campaign->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('campaigns', [
            'id' => $campaign->id,
        ]);
    }

    public function test_show_campaign_not_found()
    {
        $response = $this->json('GET', '/api/campaigns/999');

        $response->assertStatus(404);
    }

    public function test_store_campaign_validation_error()
    {
        $data = [
            'start_date' => '2025-06-01',
            'end_date' => '2025-07-01',
            'daily_budget' => 20000.00,
        ];

        $response = $this->json('POST', '/api/campaigns', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function it_returns_metrics_for_a_specific_campaign_within_a_date_range(): void
    {
        $campaign = Campaign::factory()->create([
            'name' => 'Test Campaign',
        ]);

        $metricsData = [
            ['date' => '2025-01-01', 'impressions' => 100, 'clicks' => 10, 'spend' => 50.0, 'conversions' => 5],
            ['date' => '2025-01-02', 'impressions' => 150, 'clicks' => 15, 'spend' => 75.0, 'conversions' => 8],
            ['date' => '2025-01-03', 'impressions' => 200, 'clicks' => 20, 'spend' => 100.0, 'conversions' => 12],
        ];

        foreach ($metricsData as $data) {
            $campaign->metrics()->create($data);
        }

        $startDate = '2025-01-01';
        $endDate = '2025-01-02';

        $response = $this->getJson(route('campaign.metrics', ['campaign' => $campaign->id, 'start' => $startDate, 'end' => $endDate]));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the response contains the campaign details and metrics
        $response->assertJsonFragment([
            'campaign_id' => $campaign->id,
            'campaign_name' => $campaign->name,
        ]);

        // Assert that only the metrics for the given date range are returned
        $response->assertJsonCount(2, 'metrics'); // 2 metrics should be returned for the 2025-01-01 and 2025-01-02 dates
    }

    public function it_returns_no_metrics_if_no_data_exists_for_the_given_date_range(): void
    {
        $campaign = Campaign::factory()->create([
            'name' => 'Test Campaign',
        ]);

        $startDate = '2025-02-01';
        $endDate = '2025-02-28';

        $response = $this->getJson(route('campaign.metrics', ['campaign' => $campaign->id, 'start' => $startDate, 'end' => $endDate]));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the metrics array is empty
        $response->assertJson([
            'campaign_id' => $campaign->id,
            'campaign_name' => $campaign->name,
            'metrics' => [],
        ]);
    }

    public function it_validates_the_request_data(): void
    {
        $campaign = Campaign::factory()->create();

        $response = $this->getJson(route('campaign.metrics', ['campaign' => $campaign->id]));

        // Assert that the response status is 422 (Unprocessable Entity)
        $response->assertStatus(422);

        // Assert that the response contains validation errors
        $response->assertJsonValidationErrors(['start', 'end']);
    }
}
