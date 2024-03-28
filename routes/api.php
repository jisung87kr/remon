<?php

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserShippingAddressApiController;
use App\Http\Controllers\Api\UserMediaApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('user')->group(function(){
        // 배송지
        Route::get('shipping_addresses', [UserShippingAddressApiController::class, 'index']);
        Route::get('shipping_addresses/{userShippingAddress}', [UserShippingAddressApiController::class, 'show']);
        Route::post('shipping_addresses', [UserShippingAddressApiController::class, 'store']);
        Route::put('shipping_addresses/{userShippingAddress}', [UserShippingAddressApiController::class, 'update']);
        Route::delete('shipping_addresses/{userShippingAddress}', [UserShippingAddressApiController::class, 'destroy']);

        // 미디어
        Route::resource('media', UserMediaApiController::class)->parameters(['media' => 'userMedia']);

        //
        Route::post('/favorites/campaigns/{campaign}', function(Request $request, Campaign $campaign){
            $request->user()->campaignFavorites()->attach($campaign);
        });

        Route::delete('/favorites/campaigns/{campaign}', function(Request $request, Campaign $campaign){
            $request->user()->campaignFavorites()->wherePivot('campaign_id', $campaign->id)->detach();
        });
    });
});
