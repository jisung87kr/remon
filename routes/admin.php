<?php

use App\Http\Controllers\Admin\CampaignAdminController;
use App\Http\Controllers\Admin\GeneralUserAdminController;
use App\Http\Controllers\Admin\BusinessUserAdminController;
use App\Http\Controllers\Admin\WithdrawalRequestAdminController;
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

    Route::resource('/campaigns', CampaignController::class)->names('campaign')->except('index');
    Route::get('/campaigns', [CampaignAdminController::class, 'index'])->name('campaign.index');
    Route::resource('/users/general', GeneralUserAdminController::class)->names("user.general")->parameters(['general' => 'user']);
    Route::post('/users/general/{user}/deduct-point', [GeneralUserAdminController::class, 'deductPoint'])->name('user.general.deduct-point');
    Route::resource('/users/business', BusinessUserAdminController::class)->names("user.business")->parameters(['business' => 'user']);
    Route::get('/applications', [CampaignApplicationAdminController::class, 'index'])->name('application.index');
    Route::post('/applications', [CampaignApplicationAdminController::class, 'updateStatus'])->name('application.updateStatus');

    Route::get('/withdrawal-requests', [WithdrawalRequestAdminController::class, 'index'])->name('withdrawal-request.index');
    Route::get('/withdrawal-requests/create', [WithdrawalRequestAdminController::class, 'create'])->name('withdrawal-request.create');
    Route::post('/withdrawal-requests', [WithdrawalRequestAdminController::class, 'store'])->name('withdrawal-request.store');
    Route::post('/withdrawal-requests/{withdrawalRequest}/approve', [WithdrawalRequestAdminController::class, 'approve'])->name('withdrawal-request.approve');
    Route::post('/withdrawal-requests/{withdrawalRequest}/reject', [WithdrawalRequestAdminController::class, 'reject'])->name('withdrawal-request.reject');
    Route::post('/withdrawal-requests/{withdrawalRequest}/complete', [WithdrawalRequestAdminController::class, 'complete'])->name('withdrawal-request.complete');
});
