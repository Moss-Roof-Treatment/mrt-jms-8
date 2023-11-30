<?php

namespace App\Providers;

use App\Http\View\Composers\IconMenuComposer;
use App\Http\View\Composers\MainMenuComposer;
use App\Http\View\Composers\ProfileIconMenuComposer;
use App\Http\View\Composers\NavigationBarComposer;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // Icon Menu.
        View::composer(['partials.iconMenu'], IconMenuComposer::class);

        // Main Menu.
        View::composer(['menu.index'], MainMenuComposer::class);

        // Profile Icon Menu.
        View::composer(['partials.profileIconMenu'], ProfileIconMenuComposer::class);

        // Navigation Bar.
        View::composer(['partials.nav'], NavigationBarComposer::class);

        // Prevent Lazy Loading on local server.
        // Model::preventLazyLoading(! app()->isProduction());
    }
}
