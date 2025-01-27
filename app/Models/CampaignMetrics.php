<?php

namespace App\Models;

use Database\Factories\CampaignMetricsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CampaignMetrics",
 *     type="object",
 *     required={"date", "impressions", "clicks", "spend", "conversions"},
 *     @OA\Property(property="id", type="integer", example=1, description="Metric ID"),
 *     @OA\Property(property="date", type="string", format="date", example="2025-01-01", description="Date of the metric"),
 *     @OA\Property(property="impressions", type="integer", example=1000, description="Number of impressions"),
 *     @OA\Property(property="clicks", type="integer", example=150, description="Number of clicks"),
 *     @OA\Property(property="spend", type="number", format="float", example=75.50, description="Amount spent"),
 *     @OA\Property(property="conversions", type="number", format="float", example=10, description="Number of conversions"),
 *     @OA\Property(property="campaign_id", type="integer", example=1, description="ID of the associated campaign"),
 * )
 */
class CampaignMetrics extends Model
{
    /** @use HasFactory<CampaignMetricsFactory> */
    use HasFactory;

    protected $fillable = [
        'date',
        'impressions',
        'clicks',
        'spend',
        'conversions',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
