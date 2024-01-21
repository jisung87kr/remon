<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/campaigns/{campaign}', function($campaign){
    return view('campaign.show');
})->name('campaigns.show');

Route::get('/campaigns/{campaign}/applicants', function($campaign){
    return view('campaign.applicants');
})->name('campaigns.applicants');

Route::get('/brandzone/{brandzone}', function($brandzone){
    return $brandzone;
})->name('brandzone.show');

Route::get('/category', function($category){
    return  $category;
})->name('category.index');

Route::get('/category/{category}', function($category){
   return  $category;
})->name('category.show');

Route::get('/community/free', function(){
    return 'community/free';
})->name('community.free');

Route::get('/community/guide', function(){
    return 'community/guide';
})->name('community.guide');

Route::get('/community/neighbor', function(){
    return 'community/neighbor';
})->name('community.neighbor');

Route::get('/event', function(){
   return 'event';
})->name('event');

Route::get('/help/notice', function(){
    return 'help/notice';
})->name('help.notice');

Route::get('/help/inquiry', function(){
    return 'help/inquiry';
})->name('help.inquiry');

Route::get('/help/faq', function(){
    return 'help.faq';
})->name('help.faq');

Route::get('/help/contact', function(){
    return 'help.contact';
})->name('help.contact');

Route::prefix('/mypage')->name('maypage.')->group(function(){
    Route::get('/campaigns', function(){
        return '/maypage/campaigns';
    })->name('campaigns');

    Route::get('/reviews', function(){
       return '/mypage/reviews';
    })->name('reviews');

    Route::get('/messages', function(){
        return '/mypage/messages';
    })->name('messages');

    Route::get('/profile', function(){
        return '/mypage/profile';
    })->name('profile');

    Route::get('/profile/information', function(){
        return '/mypage/profile/information';
    })->name('profile.information');

    Route::get('/media', function(){
        return '/mypage/media';
    })->name('media');

    Route::get('/penalty', function(){
        return '/mypage/penalty';
    })->name('penalty');

    Route::get('/point', function(){
        return '/mypage/point';
    })->name('point');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
