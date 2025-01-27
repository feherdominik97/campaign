<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CampaignRequest",
 *     type="object",
 *     required={"name", "start_date", "end_date", "daily_budget"},
 *     @OA\Property(property="name", type="string", description="Name of the campaign", example="New Year Sale"),
 *     @OA\Property(property="start_date", type="string", format="date", description="Start date of the campaign", example="2025-01-01"),
 *     @OA\Property(property="end_date", type="string", format="date", description="End date of the campaign", example="2025-01-31"),
 *     @OA\Property(property="daily_budget", type="number", format="float", description="Daily budget for the campaign", example=150.75)
 * )
 */
class CampaignRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'daily_budget' => 'required|numeric|min:0',
        ];
    }
}
