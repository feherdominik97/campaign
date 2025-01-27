<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignMetricsRequest;
use App\Models\CampaignMetrics;
use Symfony\Component\HttpFoundation\Response;

class CampaignMetricsController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/campaign-metrics",
     *     summary="Create a new campaign metric",
     *     description="Store a newly created campaign metric in the database",
     *     operationId="storeCampaignMetric",
     *     tags={"Campaign Metrics"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CampaignMetricsRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Campaign metric created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CampaignMetrics")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "date": {"The date field is required."},
     *                     "impressions": {"The impressions field is required."},
     *                     "clicks": {"The clicks field is required."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function store(CampaignMetricsRequest $request): \Illuminate\Http\JsonResponse
    {
        $campaign = CampaignMetrics::query()->create($request->validated());

        return response()->json($campaign, Response::HTTP_CREATED);
    }
}
