<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CampaignController;
use App\Http\Controllers\API\CampaignMetricsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('campaigns')->group(function () {
        Route::apiResource('', CampaignController::class);
        Route::get('{id}/metrics', [CampaignController::class, 'metrics'])
            ->name('campaign.metrics');
    });

    Route::prefix('campaign-metrics')->group(function () {
        Route::get('analytics', [CampaignMetricsController::class, 'getAllCampaignMetrics'])
            ->name('campaign-metrics.analytics');
        Route::post('', [CampaignMetricsController::class, 'store']);
    });
});


