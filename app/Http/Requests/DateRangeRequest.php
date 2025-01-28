<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="DateRangeRequest",
 *     type="object",
 *     required={"start_date", "end_date"},
 *     @OA\Property(
 *         property="start_date",
 *         type="string",
 *         format="date",
 *         example="2025-01-01",
 *         description="The start date for the date range"
 *     ),
 *     @OA\Property(
 *         property="end_date",
 *         type="string",
 *         format="date",
 *         example="2025-01-31",
 *         description="The end date for the date range. Must be equal to or after the start_date."
 *     )
 * )
 */
class DateRangeRequest extends FormRequest
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
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start',
        ];
    }
}
