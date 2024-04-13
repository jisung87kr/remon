<?php

namespace App\Providers;

use App\Enums\AdminRoleEnum;
use App\Models\CampaignApplication;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/mypage/campaigns';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            $adminRole      = AdminRoleEnum::ADMIN->value;
            $superAdminRole = AdminRoleEnum::SUPER_ADMIN->value;
            Route::middleware(['web', "role:{$adminRole}|{$superAdminRole}"])
                ->prefix('/admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        });
    }
}
