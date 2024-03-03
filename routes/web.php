<?php

use App\Http\Controllers\CampaignApplicationController;
use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CampaignController;

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

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
Route::get('/campaigns/{campaign}/application', [CampaignApplicationController::class, 'index'])->name('campaigns.application.index');

Route::get('/campaigns/{campaign}/applicants', function(Campaign $campaign){
    return view('campaign.applicants', compact('campaign'));
})->name('campaigns.applicants');

Route::get('/brandzone/{brandzone}', function($brandzone){
    return view('campaign.brandzone');
})->name('brandzone.show');

Route::get('/category', function($category){
    return view('campaign.index');
})->name('category.index');

Route::get('/category/오늘오픈', function(){
    $campaigns = [];
    $category = new \App\Models\Category();
    $category->name = '오늘오픈';
    $locationCategory = Category::filter(['name' => '지역'])->first();
    return view('campaign.index', compact('campaigns', 'category', 'locationCategory'));
})->name('category.show');

Route::get('/community/free', function(){
    return view('community.free');
})->name('community.free');

Route::get('/community/guide', function(){
    return view('community.guide');
})->name('community.guide');

Route::get('/community/neighbor', function(){
    return view('community.neighbor');
})->name('community.neighbor');

Route::get('/event', function(){
    return view('community.event');
})->name('event');

Route::get('/help/notice', function(){
    return view('help.notice');
})->name('help.notice');

Route::get('/help/inquiry', function(){
    return view('help.inquiry');
})->name('help.inquiry');

Route::get('/help/guide', function(){
    return view('help.guide');
})->name('help.guide');

Route::get('/help/contact', function(){
    return view('help.contact');
})->name('help.contact');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('/mypage')->name('mypage.')->group(function(){
        Route::get('/campaigns', function(){
            return view('mypage.campaigns');
        })->name('campaigns');

        Route::get('/favorites', function(){
            return view('mypage.favorites');
        })->name('favorites');

        Route::get('/reviews', function(){
            return view('mypage.reviews');
        })->name('reviews');

        Route::get('/messages', function(){
            return view('mypage.messages');
        })->name('messages');

        Route::get('/profile', function(){
            return view('mypage.profile');
        })->name('profile');

        Route::post('/profile', function(){
            return view('mypage.profile');
        })->name('profile');

        Route::get('/profile/information', function(){
            return view('mypage.profile-information');
        })->name('profile.information');

        Route::get('/media', function(){
            $blog = auth()->user()->medias()->where('media', \App\Enums\Campaign\MediaEnum::NAVER_BLOG)->first();
            $instagram = auth()->user()->medias()->where('media', \App\Enums\Campaign\MediaEnum::INSTAGRAM)->first();
            $youtube = auth()->user()->medias()->where('media', \App\Enums\Campaign\MediaEnum::YOUTUBE)->first();
            return view('mypage.media', compact('blog', 'instagram', 'youtube'));
        })->name('media');

        Route::get('/penalty', function(){
            return view('mypage.panalty');
        })->name('penalty');

        Route::get('/point', function(){
            return view('mypage.point');
        })->name('point');
    });

    Route::prefix('/admin')->name('admin.')->group(function(){
        Route::get('/', function(){
            return view('admin.index');
        })->name('index');

        Route::resource('/campaigns', CampaignController::class);
    });
});
