<?php

use App\Http\Controllers\Admin\GeneralUserAdminController;
use App\Http\Controllers\Admin\BusinessUserAdminController;
use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CampaignApplicationAdminController;

Route::get('/', function(){
    return view('admin.index');
})->name('index');

Route::resource('/campaigns', CampaignController::class)->names('campaign');
Route::resource('/users/general', GeneralUserAdminController::class)->names("user.general")->parameters(['general' => 'user']);
Route::resource('/users/business', BusinessUserAdminController::class)->names("user.business")->parameters(['business' => 'user']);
Route::get('/applications', [CampaignApplicationAdminController::class, 'index'])->name('application.index');
