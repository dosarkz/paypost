<?php
/**
 * Created by PhpStorm.
 * User: dosar
 * Date: 27.11.2018
 * Time: 10:56
 */

namespace Dosarkz\PayPost\ServiceProviders;


use Dosarkz\PayPost\Facade\PayPost;
use Dosarkz\PayPost\PayPostService;
use Illuminate\Support\ServiceProvider;

class PayPostServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/paypost.php' => config_path('paypost.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(PayPost::class, function ($app) {
            return new PayPostService();
        });
    }

}