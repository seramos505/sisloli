<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Admin\Menu;

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
        // View::composer("theme.lte3.aside", function ($view) {
        //     $menus = Menu::getMenu(true);
        //     $view->with('menusComposer', $menus);
        // });
        Schema::defaultStringLength(191);
        View::share('theme', 'lte3');
    }
}
