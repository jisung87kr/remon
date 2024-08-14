<?php

use App\Models\Campaign;
use App\Models\CampaignApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserShippingAddressApiController;
use App\Http\Controllers\Api\UserMediaApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Statistics\BusinessStatisticsController;
use App\Http\Controllers\Api\CommentApiController;


Route::middleware('auth:sanctum')->group(function(){
    Route::delete('campaigns/{campaign}', [\App\Http\Controllers\Internal\CampaignInternalController::class, 'destroy'])->name('campaign.destroy');
});
