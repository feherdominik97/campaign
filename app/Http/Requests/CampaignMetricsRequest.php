<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
        ];

        if ($this->is('api/campaigns/*/metrics')) {
            $rules['start'] = 'required|date';
            $rules['end'] = 'required|date|after_or_equal:start';
        }

        return $rules;
    }
}
