<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class EloquentModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'speeches' => 'App\Models\Speech',
            'speakers' => 'App\Models\Speaker',
            'topics' => 'App\Models\Topic',
            'questions' => 'App\Models\Question',
            'answers' => 'App\Models\Answer'
        ]);
    }
}
