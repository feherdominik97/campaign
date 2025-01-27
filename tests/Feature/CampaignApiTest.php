<?php

namespace Tests\Feature;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CampaignApiTest extends TestCase
{
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
}
