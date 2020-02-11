<?php

namespace App\Providers;

use App\Models\Arraysets\Lang;
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
        // my ip
        if(in_array(request()->getClientIp(), ['91.213.187.137', '77.123.43.236'])) {
            config(['app.debug' => true]);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*if(mb_stripos(request()->fullUrl(), '//amp.') !== false){
            \URL::forceRootUrl(config('app.url'));
        }*/

        foreach (Lang::$array as $lang){
            if(strpos(request()->getHost(), $lang.'.') !== false){
                app()->setLocale($lang);
            }
        }
    }
}
