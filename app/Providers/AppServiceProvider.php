<?php

namespace App\Providers;

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
        View::composer('layouts.nav', function ($view) {
            $navs = \App\Models\Category::getTree();
            $view->with('navs', \App\Models\Category::getTree()->toArray());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // \DB::enableQueryLog();
        // dd(\DB::getQueryLog());
        //
    }
}
