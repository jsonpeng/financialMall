<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \Carbon\Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('setting', 'App\Repositories\SettingRepository');
        $this->app->singleton('commonRepo', 'App\Repositories\CommonRepository');
        $this->app->singleton('cart','App\Repositories\CartRepository');

        //防止污染后台
        if(!empty($_SERVER['REQUEST_URI']) && substr($_SERVER['REQUEST_URI'], 0, 6) != '/admin'){
            View::composer(
                '*', 'App\Http\ViewComposers\BaseComposer'
            );
        }

    }
}
