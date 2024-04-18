<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = 'admin/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    protected $namespace = 'App\Http\Controllers';
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });

        $this->mapAuthRoutes();
        $this->mapAdminRoutes();
        $this->mapAjaxRoutes();
        $this->mapVendorRoutes();
        // $this->mapMfiRoutes();
        // $this->mapPageRoutes();
        $this->mapFrontendRoutes();
        // $this->mapCustomerRoutes();
        // $this->mapPaymentRoutes();
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */

    protected function mapAuthRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/auth.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('admin')
            ->group(base_path('routes/admin.php'));
    }

    protected function mapAjaxRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace . '\Ajax')
            ->prefix('ajax')
            ->group(base_path('routes/ajax.php'));
    }

    protected function mapVendorRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            // ->namespace($this->namespace . '\Vendor')
            ->prefix('vendor')
            ->group(base_path('routes/vendor.php'));
    }
    // protected function mapMfiRoutes()
    // {
    //     Route::middleware('web')
    //         ->namespace($this->namespace . '\Mfi')
    //         ->group(base_path('routes/mfi.php'));
    // }
    // protected function mapCustomerRoutes()
    // {
    //     Route::middleware('web')
    //         ->namespace($this->namespace . '\Customer')
    //         ->prefix('customer')
    //         ->group(base_path('routes/customer.php'));
    // }
    // protected function mapPaymentRoutes()
    // {
    //     Route::middleware('web')
    //         ->namespace($this->namespace . '\Customer')
    //         ->prefix('payment')
    //         ->group(base_path('routes/payment.php'));
    // }
    protected function mapPageRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/pages.php'));
    }

    protected function mapFrontendRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/frontend.php'));
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
