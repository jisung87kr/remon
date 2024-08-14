<?php

use App\Http\Controllers\Admin\GeneralUserAdminController;
use App\Http\Controllers\Admin\BusinessUserAdminController;
use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CampaignApplicationAdminController;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function(){
    Route::get('/', function(){
        return redirect()->route('admin.campaign.index');
    })->name('index');

    Route::resource('/campaigns', CampaignController::class)->names('campaign');
    Route::resource('/users/general', GeneralUserAdminController::class)->names("user.general")->parameters(['general' => 'user']);
    Route::resource('/users/business', BusinessUserAdminController::class)->names("user.business")->parameters(['business' => 'user']);
    Route::get('/applications', [CampaignApplicationAdminController::class, 'index'])->name('application.index');
    Route::post('/applications', [CampaignApplicationAdminController::class, 'updateStatus'])->name('application.updateStatus');
});
