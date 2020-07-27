<?php

namespace App\Providers;

use Yabacon\Paystack;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class PaystackServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('paystack', function($app){
            $paystack = new Paystack(config('services.paystack.secret_key'));
            $paystack->useGuzzle();
            return $paystack;
        });
    }
}
