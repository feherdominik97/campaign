<?php

namespace App\Models;

use Database\Factories\CampaignFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->hasMany(CampaignMetric::class);
    }
}
