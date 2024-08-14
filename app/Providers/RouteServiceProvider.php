<?php

namespace App\Providers;

use App\Enums\AdminRoleEnum;
use App\Enums\RoleEnum;
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
     *
     * see RedirectIfAuthenticated::class
     */
    public const HOME = '/';
    public const ADMIN_HOME = '/admin';
    public const BUSINESS_HOME = '/business';

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

            Route::middleware('api')
                ->prefix('internal')
                ->name('internal.')
                ->group(base_path('routes/internal.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            $adminRole      = AdminRoleEnum::ADMIN->value;
            $superAdminRole = AdminRoleEnum::SUPER_ADMIN->value;
            $businessRole = RoleEnum::BUSINESS_USER->value;
            Route::middleware(['web', "role:{$adminRole}|{$superAdminRole}"])
                ->prefix('/admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            Route::middleware(['web', "role:{$adminRole}|{$superAdminRole}|{$businessRole}"])
                ->prefix('/business')
                ->name('business.')
                ->group(base_path('routes/business.php'));

            Route::middleware(['web'])
                ->prefix('/boards')
                ->name('board.')
                ->group(base_path('routes/board.php'));
        });
    }
}
