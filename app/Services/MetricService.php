<?php
namespace App\Services;

use App\Models\CampaignMetrics;
use App\Helpers\DateRangeHelper;

class MetricService
{
    /**
     * Get all metrics for all campaigns between the specified date range.
     *
     * @param $start_date
     * @param $end_date
     * @return array
     */
    public function getAllCampaignMetrics($start_date, $end_date): array
    {
        $campaign_metrics_collection = CampaignMetrics::query();
        $campaign_metrics_collection = DateRangeHelper::appendRangeFilter($campaign_metrics_collection, $start_date, $end_date);
        $campaign_metrics_collection = $campaign_metrics_collection->get();

        $result = [
            'total_impressions' => $campaign_metrics_collection->sum('impressions'),
            'total_clicks' => $campaign_metrics_collection->sum('clicks'),
            'total_conversions' => $campaign_metrics_collection->sum('conversions'),
            'total_spend' => $campaign_metrics_collection->sum('spend'),
        ];

        $ctr = $this->calculateCTR($result['total_clicks'], $result['total_impressions']);
        $conversionRate = $this->calculateConversionRate($result['total_conversions'], $result['total_clicks']);

        $result['ctr'] = $ctr;
        $result['conversion_rate'] = $conversionRate;

        return $result;
    }

    /**
     * Calculate CTR (Click-Through Rate).
     *
     * @param int $clicks
     * @param int $impressions
     * @return float
     */
    private function calculateCTR(int $clicks, int $impressions): float
    {
        if ($impressions == 0) {
            return 0.0;
        }

        return ($clicks / $impressions) * 100;
    }

    /**
     * Calculate Conversion Rate.
     *
     * @param int $conversions
     * @param int $clicks
     * @return float
     */
    private function calculateConversionRate(int $conversions, int $clicks): float
    {
        if ($clicks == 0) {
            return 0.0;
        }

        return ($conversions / $clicks) * 100;
    }
}
