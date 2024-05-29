<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\CampaignBusinessController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function(){
    Route::get('/dashboard', [CampaignBusinessController::class, 'dashboard'])->name('dashboard');
    Route::get('/campaigns', [CampaignBusinessController::class, 'index'])->name('dashboard.campaign.index');
    Route::get('/campaigns/{campaign}', [CampaignBusinessController::class, 'show'])->name('dashboard.campaign.show');
    Route::get('/campaigns/{campaign}/report', [CampaignBusinessController::class, 'report'])->name('dashboard.campaign.report');
});
