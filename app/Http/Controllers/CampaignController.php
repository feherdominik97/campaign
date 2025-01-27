<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignRequest;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Campaign::all(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CampaignRequest $request): JsonResponse
    {
        $campaign = Campaign::query()->create($request->validated());

        return response()->json($campaign, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $campaign = Campaign::query()->findOrFail($id);

        return response()->json($campaign, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CampaignRequest $request, $id): JsonResponse
    {
        $campaign = Campaign::query()->findOrFail($id);

        $campaign = array_merge($campaign->toArray(), $request->validated());

        Campaign::query()->where('id', $id)->update($campaign);

        return response()->json($campaign, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $deleted = Campaign::destroy($id);

        return response()->json($deleted, Response::HTTP_OK); // returning the number of deleted records
    }
}
