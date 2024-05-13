<?php

use App\Http\Controllers\CampaignApplicationController;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignMediaController;
use App\Http\Controllers\Mymapge\CampaignMypageController;
use App\Enums\Campaign\MediaEnum;
use App\Enums\RoleEnum;
use App\Enums\AdminRoleEnum;
use App\Http\Controllers\CampaignMediaContentController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

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
Route::get('/foo', function(){

});

Route::get('campaign_banner', function(Request $request){
    $filepath = "campaigns/1/7GMCs3UeUw1P3rXq7WGvLV4gc6TqvXz8paKGT865.png";
    $fileContents = Storage::disk('public')->get($filepath);
    $response = new Response($fileContents);
    $response->headers->set('Content-Type', Storage::disk('public')->mimeType($filepath));

    $bannerLog = new \App\Models\BannerLog;
    $bannerLog->create([
        'banner_id' => $request->input('id'),
        'referer' => $request->header('referer'),
        'ip_address' => $request->ip(),
    ]);

    return $response;
});

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaign.index');
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaign.show');

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

    Route::get('/campaigns/{campaign}/applications', [CampaignApplicationController::class, 'index'])->name('campaign.application.index');
    Route::get('/campaigns/{campaign}/applications/create', [CampaignApplicationController::class, 'create'])->name('campaign.application.create');
    Route::post('/campaigns/{campaign}/applications', [CampaignApplicationController::class, 'store'])->name('campaign.application.store');
    Route::get('/campaigns/{campaign}/applications/{campaignApplication}', [CampaignApplicationController::class, 'show'])->name('campaign.application.show');
    Route::get('/campaigns/{campaign}/applications/{campaignApplication}/edit', [CampaignApplicationController::class, 'edit'])->name('campaign.application.edit');
    Route::put('/campaigns/{campaign}/applications/{campaignApplication}', [CampaignApplicationController::class, 'update'])->name('campaign.application.update');
    Route::post('/campaigns/{campaign}/applications/{campaignApplication}/cancel', [CampaignApplicationController::class, 'cancel'])->name('campaign.application.cancel');

    Route::resource('/campaigns/{campaign}/media/{media}/content', CampaignMediaContentController::class)->names('campaign.media.content');


    Route::prefix('/mypage')->name('mypage.')->group(function(){
        Route::get('/campaigns', [CampaignMypageController::class, 'campaigns'])->name('campaign');

        Route::get('/favorites', [CampaignMypageController::class, 'favorites'])->name('favorite');

        Route::get('/reviews', function(){
            return view('mypage.reviews');
        })->name('review');

        Route::get('/messages', function(){
            return view('mypage.messages');
        })->name('message');

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
            $blog = auth()->user()->medias()->where('media', MediaEnum::NAVER_BLOG)->first();
            $instagram = auth()->user()->medias()->where('media', MediaEnum::INSTAGRAM)->first();
            $youtube = auth()->user()->medias()->where('media', MediaEnum::YOUTUBE)->first();
            return view('mypage.media', compact('blog', 'instagram', 'youtube'));
        })->name('media');

        Route::get('/penalty', function(){
            return view('mypage.panalty');
        })->name('penalty');

        Route::get('/point', function(){
            return view('mypage.point');
        })->name('point');
    });
});
