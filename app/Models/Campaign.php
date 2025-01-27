<?php

namespace App\Models;

use Database\Factories\CampaignFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Campaign",
 *     type="object",
 *     required={"name", "status", "start_date", "end_date", "daily_budget"},
 *     @OA\Property(property="id", type="integer", example=1, description="Campaign ID"),
 *     @OA\Property(property="name", type="string", example="Holiday Sales Campaign", description="Name of the campaign"),
 *     @OA\Property(property="status", type="string", example="active", description="Status of the campaign (active/inactive)"),
 *     @OA\Property(property="start_date", type="string", format="date", example="2025-01-01", description="Start date of the campaign"),
 *     @OA\Property(property="end_date", type="string", format="date", example="2025-01-10", description="End date of the campaign"),
 *     @OA\Property(property="daily_budget", type="number", format="float", example=100.50, description="Daily budget for the campaign"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01T12:00:00Z", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-02T12:00:00Z", description="Last updated timestamp"),
 * )
 */
class Campaign extends Model
{
    /** @use HasFactory<CampaignFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'start_date',
        'end_date',
        'daily_budget',
    ];

    public function metrics(): HasMany
    {
        return $this->hasMany(CampaignMetrics::class);
    }
}
