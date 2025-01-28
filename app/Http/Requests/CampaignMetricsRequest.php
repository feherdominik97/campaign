<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CampaignMetricsRequest",
 *     type="object",
 *     required={"date", "impressions", "clicks", "spend", "conversions"},
 *     @OA\Property(property="date", type="string", format="date", description="Date of the metrics", example="2025-01-01"),
 *     @OA\Property(property="impressions", type="integer", description="Number of impressions", example=1000),
 *     @OA\Property(property="clicks", type="integer", description="Number of clicks", example=50),
 *     @OA\Property(property="spend", type="number", format="float", description="Spend on the campaign", example=200.5),
 *     @OA\Property(property="conversions", type="number", format="float", description="Number of conversions", example=10)
 * )
 */
class CampaignMetricsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'date' => 'required|date',
            'impressions' => 'required|integer|min:0',
            'clicks' => 'required|integer|min:0',
            'spend' => 'required|numeric|min:0',
            'conversions' => 'required|numeric|min:0',
            'campaign_id' => 'required|numeric|min:1',
        ];

        if ($this->is('api/campaign-metrics/analytics/*')) {
            $rules['start_date'] = 'date';
            $rules['end_date'] = 'date|after_or_equal:start';
        }

        return $rules;
    }
}
