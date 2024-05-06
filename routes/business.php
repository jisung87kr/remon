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
Route::get('/dashboard', [CampaignBusinessController::class, 'dashboard'])->name('dashboard');
Route::get('/campaigns', [CampaignBusinessController::class, 'index'])->name('campaign.index');
Route::get('/campaigns/{campaign}', [CampaignBusinessController::class, 'show'])->name('campaign.show');
Route::get('/campaigns/{campaign}/report', [CampaignBusinessController::class, 'report'])->name('campaign.report');
