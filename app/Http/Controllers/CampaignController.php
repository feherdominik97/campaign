<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignRequest;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(
 *     title="Campaign API",
 *     version="1.0.0",
 *     description="API documentation for managing campaigns and their metrics."
 * )
 * @OA\Tag(
 *     name="Campaign",
 *     description="Operations related to campaigns"
 * )
 * @OA\Server(
 *     url="http://localhost/api",
 *     description="Local Development Server"
 * )
 */
class CampaignController extends Controller
{
    /**
     * Display a listing of the campaigns.
     *
     * @OA\Get(
     *     path="/campaigns",
     *     summary="Get all campaigns",
     *     tags={"Campaign"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of campaigns",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Campaign"))
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(Campaign::all(), Response::HTTP_OK);
    }

    /**
     * Store a newly created campaign.
     *
     * @OA\Post(
     *     path="/campaigns",
     *     summary="Create a new campaign",
     *     tags={"Campaign"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CampaignRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Campaign created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Campaign")
     *     )
     * )
     */
    public function store(CampaignRequest $request): JsonResponse
    {
        $campaign = Campaign::query()->create($request->validated());

        return response()->json($campaign, Response::HTTP_CREATED);
    }

    /**
     * Display a specific campaign.
     *
     * @OA\Get(
     *     path="/campaigns/{id}",
     *     summary="Get a specific campaign",
     *     tags={"Campaign"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the campaign",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaign details",
     *         @OA\JsonContent(ref="#/components/schemas/Campaign")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaign not found"
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $campaign = Campaign::query()->findOrFail($id);

        return response()->json($campaign, Response::HTTP_OK);
    }

    /**
     * Update a specific campaign.
     *
     * @OA\Put(
     *     path="/campaigns/{id}",
     *     summary="Update a specific campaign",
     *     tags={"Campaign"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the campaign to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CampaignRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaign updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Campaign")
     *     )
     * )
     */
    public function update(CampaignRequest $request, $id): JsonResponse
    {
        $campaign = Campaign::query()->findOrFail($id);
        $campaign = array_merge($campaign->toArray(), $request->validated());
        Campaign::query()->where('id', $id)->update($campaign);

        return response()->json($campaign, Response::HTTP_OK);
    }

    /**
     * Remove a specific campaign.
     *
     * @OA\Delete(
     *     path="/campaigns/{id}",
     *     summary="Delete a specific campaign",
     *     tags={"Campaign"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the campaign to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaign deleted successfully"
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        $deleted = Campaign::destroy($id);
        return response()->json($deleted, Response::HTTP_OK);
    }

    /**
     * Retrieve metrics for a specific campaign.
     *
     * @OA\Get(
     *     path="/campaigns/{id}/metrics",
     *     summary="Get metrics for a campaign",
     *     tags={"Campaign"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the campaign",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="start",
     *         in="query",
     *         required=true,
     *         description="Start date for filtering metrics",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="end",
     *         in="query",
     *         required=true,
     *         description="End date for filtering metrics",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Metrics retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CampaignMetrics"))
     *     )
     * )
     */
    public function metrics(CampaignRequest $request, $campaignId): JsonResponse
    {
        $validated = $request->validated();

        $campaign = Campaign::query()->findOrFail($campaignId);
        $campaign = new Campaign($campaign);

        $metrics = $campaign->metrics()
            ->whereBetween('date', [$validated['start'], $validated['end']])
            ->get();

        return response()->json([
            'campaign_id' => $campaign->id,
            'campaign_name' => $campaign->name,
            'metrics' => $metrics,
        ]);
    }
}
