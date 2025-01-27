<?php

namespace App\Models;

use Database\Factories\CampaignMetricsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
