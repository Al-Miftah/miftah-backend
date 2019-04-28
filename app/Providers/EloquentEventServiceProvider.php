<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{Topic, Speech};
use App\Observers\{TopicObserver, SpeechObserver};

class EloquentEventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Topic::observe(TopicObserver::class);
        Speech::observe(SpeechObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
