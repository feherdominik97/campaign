<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignMetricsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('campaigns', CampaignController::class);
    Route::get('campaigns/{campaign}/metrics', [CampaignController::class, 'metrics'])
        ->name('campaign.metrics');
});

Route::post('campaign-metrics', [CampaignMetricsController::class, 'store']);
