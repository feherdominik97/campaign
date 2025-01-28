<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignMetricsRequest;
use App\Http\Requests\DateRangeRequest;
use App\Models\CampaignMetrics;
use App\Services\MetricService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Campaign Metrics",
 *     description="Operations related to campaign metrics"
 * )
 */
class CampaignMetricsController extends Controller
{
    protected MetricService $metric_service;
    public function __construct(MetricService $metricService)
    {
        $this->metric_service = $metricService;
    }
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
    public function store(CampaignMetricsRequest $request): JsonResponse
    {
        $campaign = CampaignMetrics::query()->create($request->validated());

        return response()->json($campaign, Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *     path="/api/campaign-metrics/all",
     *     summary="Retrieve all campaign metrics within a date range",
     *     description="Retrieve all metrics for campaigns, optionally filtered by a start and end date.",
     *     operationId="getAllCampaignMetrics",
     *     tags={"Campaign Metrics"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DateRangeRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="All campaign metrics retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CampaignMetrics")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid date range",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid date range provided.")
     *         )
     *     )
     * )
     */
    public function getAllCampaignMetrics(DateRangeRequest $request): JsonResponse
    {
        $start = $request->input('start_date', false);
        $end = $request->input('end_date', false);
        $metrics = $this->metric_service->getAllCampaignMetrics($start, $end);

        return response()->json($metrics, Response::HTTP_OK);
    }
}
