<?php
namespace Imtiaz\Sslcommerz;

use Illuminate\Support\ServiceProvider;

class SslcommerzServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sslcommerz.php' => config_path('sslcommerz.php'),
        ], 'config');
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sslcommerz', function ($app) {
            return new Sslcommerz();
        });
        $this->mergeConfigFrom(__DIR__.'/../config/sslcommerz.php','sslcommerz');
    }

}