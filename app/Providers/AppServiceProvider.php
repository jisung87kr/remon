<?php

namespace App\Providers;

use App\Libraries\TrackerDelivery;
use App\Util\AsyncHttpClient;
use GuzzleHttp\Client;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Http\Responses\CustomRegisterResponse;
use App\Models\CampaignApplication;
use App\Policies\CampaignApplicationPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(TrackerDelivery::class, function(){
            return new TrackerDelivery(env('TRACKER_DELIVERY_CLIENT_ID'), env('TRACKER_DELIVERY_SECRET'), new AsyncHttpClient(new Client()));
        });

        app()->singleton(RegisterResponse::class, CustomRegisterResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(CampaignApplication::class, CampaignApplicationPolicy::class);
    }
}
