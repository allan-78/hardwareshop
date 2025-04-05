<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use App\Services\CartService;
use App\View\Components\Icon;
use App\View\Components\Dropdown;
use App\View\Components\ApplicationLogo;
use App\View\Components\AppLayout;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CartService::class, function ($app) {
            return new CartService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        // Register components
        Blade::component('icon', Icon::class);
        Blade::component('dropdown', Dropdown::class);
        Blade::component('dropdown-link', 'components.dropdown-link');
        Blade::component('nav-link', 'components.nav-link');
        Blade::component('layouts.guest', Components\Layouts\Guest::class);
        Blade::component('application-logo', ApplicationLogo::class);
        Blade::component('app-layout', AppLayout::class);

        // Share categories with all views
        View::composer('*', function ($view) {
            $view->with('categories', Category::withCount('products')->orderBy('name')->get());
        });
    }
}
