<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{Topic, Speech, Tag};
use App\Observers\{TopicObserver, SpeechObserver, TagObserver};

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
        Tag::observe(TagObserver::class);
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
