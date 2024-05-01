<?php

namespace App\Providers;

use App\Enums\Campaign\ApplicationStatus;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Campaign;
use App\Models\CampaignMediaContent;


class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('layouts.app', function ($view) {
            $view->with('influencerCount', User::all()->count());
            $view->with('campaignCount', Campaign::all()->count());
            $view->with('contentCount', CampaignMediaContent::all()->count());
        });
    }
}
