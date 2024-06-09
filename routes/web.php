<?php

use App\Enums\TrackDelivery\TrackEventStatusCodeEnum;
use App\Exports\CampaignApplicationExport;
use App\Http\Controllers\CampaignApplicationController;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Category;
use App\Models\TrackerDeliverQueue;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
use App\Http\Controllers\BoardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CallbackController;

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
Route::get('/foo', function(\App\Libraries\TrackerDelivery $trackerDelivery){
    //dev.track.dummy
    //2024-06-09T03:00:00Z

//    $response = $trackerDelivery->carrierList(20);
//    $body = (string)$response->response->getBody();
//    dd(json_decode($body, true));

//    $response = $trackerDelivery->lastTrack('dev.track.dummy', '2024-06-09T03:00:00Z');
//    $body = (string)$response->response->getBody();
//    $result = json_decode($body, true);

//    $response = $trackerDelivery->registerTrackWebhook('dev.track.dummy', '2024-06-09T03:00:00Z', 'https://mangotree.co.kr/bbs/test', $trackerDelivery->makeExpireAt(0));
//    $body = (string)$response->response->getBody();
//    dd(json_decode($body, true));

//    $model = new TrackerDeliverQueue();
//    $result = $model->create([
//        'carrier_id' => '123',
//        'tracking_number' => '234',
//    ]);
});

Route::get('callback/tracker_delivery/{parcel}', [CallbackController::class, 'trackerDelivery'])->name('callback.tracker_delivery');

Route::get('campaign_banner', function(Request $request){
    $filepath = "campaigns/1/7GMCs3UeUw1P3rXq7WGvLV4gc6TqvXz8paKGT865.png";
    $fileContents = Storage::disk('public')->get($filepath);
    $response = new Response($fileContents);
    $response->headers->set('Content-Type', Storage::disk('public')->mimeType($filepath));

    $bannerLog = new \App\Models\BannerLog;
    $mediaContent = \App\Models\CampaignMediaContent::where('banner_id', $request->input('id'))->first();
    $bannerLog->create([
        'campaign_media_content_id' => $mediaContent->id,
        'referer' => $request->header('referer'),
        'ip_address' => $request->ip(),
    ]);

    return $response;
});

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaign.index');
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaign.show');

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

        Route::get('/reviews', function(Request $request){
            $size = $request->input('size', 10);
            $filter = [
                'status' => $request->input('status'),
                'keyword' => $request->input('keyword'),
            ];

            if($request->input('export')){
                $filename = "campaign_application_export_".time().".xlsx";
                return (new CampaignApplicationExport($filter))->download($filename);
            }

            $applications = auth()->user()->applications()->filter($filter)->with('user')->orderBy('id', 'desc')->paginate($size);
            return view('mypage.reviews', compact('applications'));
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
            $blog = auth()->user()->media()->where('media', MediaEnum::NAVER_BLOG)->first();
            $instagram = auth()->user()->media()->where('media', MediaEnum::INSTAGRAM)->first();
            $youtube = auth()->user()->media()->where('media', MediaEnum::YOUTUBE)->first();
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

Route::get('/mail/application/{status}', function($status){
    $application = CampaignApplication::find(1);
    switch ($status){
        case 'applied';
            //Mail::to('jisung87kr@gmail.com')->send(new \App\Mail\Campaign\Application\Applied($application));
            return (new \App\Mail\Campaign\Application\Applied($application))->render();
            break;
        case 'canceled';
            return (new \App\Mail\Campaign\Application\Canceled($application))->render();
            break;
        case 'approved';
            return (new \App\Mail\Campaign\Application\Approved($application))->render();
            break;
        case 'rejected';
            return (new \App\Mail\Campaign\Application\Rejected($application))->render();
            break;
        case 'pending';
            return (new \App\Mail\Campaign\Application\Pending($application))->render();
            break;
        case 'posted';
            return (new \App\Mail\Campaign\Application\Posted($application))->render();
            break;
        case 'completed';
            return (new \App\Mail\Campaign\Application\Completed($application))->render();
            break;
    }
});


Route::get('/page/terms', function(){
    return view('page.terms');
})->name('page.terms');

Route::get('/page/terms-location', function(){
    return view('page.terms-location');
})->name('page.terms_location');

Route::get('/page/policy', function(){
    return view('page.policy');
})->name('page.policy');
