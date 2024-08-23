<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Internal\LinkInternalController;


Route::middleware('auth:sanctum')->group(function(){
    Route::delete('campaigns/{campaign}', [\App\Http\Controllers\Internal\CampaignInternalController::class, 'destroy'])->name('campaign.destroy');

    Route::post('links', [LinkInternalController::class, 'store'])->name('link.store');
    Route::put('links/{link}', [LinkInternalController::class, 'update'])->name('link.update');
    Route::delete('links/{link}', [LinkInternalController::class, 'destroy'])->name('link.destroy');
});
