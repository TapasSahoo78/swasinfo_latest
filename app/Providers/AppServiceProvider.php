<?php

namespace App\Providers;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Passport\Passport;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!Collection::hasMacro('paginate')) {
            Collection::macro(
                'paginate',
                function ($perPage = 14, $page = null, $options = []) {
                    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                    return (new LengthAwarePaginator(
                        $this->forPage($page, $perPage),
                        $this->count(),
                        $perPage,
                        $page,
                        $options
                    ))->withPath('');
                }
            );
        }

        View::composer(['frontend.layouts.partials.navbar','frontend.index'], function ($view) {
            $masterCategories = Category::whereNull('parent_id')->get();
            $view->with('masterCategories', $masterCategories);
        });

        View::composer('frontend.layouts.partials.footer', function ($view) {
            $pages = \App\Models\Menu::where('status', 1)->where('is_footer',true)->orderBy('id', 'asc')->get();
            $view->with(['pages' => $pages]);
        });

        View::composer(['frontend.layouts.partials.cart','frontend.layouts.partials.navbar'], function ($view) {
            $cartProducts = auth()->user()?->carts ?? session()->get('cart',[]);
            $view->with(['cartProducts' => $cartProducts]);
        });
    }
}
