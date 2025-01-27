<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignMetricsRequest;
use App\Models\CampaignMetrics;
use Symfony\Component\HttpFoundation\Response;

class CampaignMetricsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CampaignMetricsRequest $request): \Illuminate\Http\JsonResponse
    {
        $campaign = CampaignMetrics::query()->create($request->validated());

        return response()->json($campaign, Response::HTTP_CREATED);
    }
}
