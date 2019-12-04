<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Favorite::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\Models\User'),
        'favorable_type' => 'speeches',
        'favorable_id' => factory('App\Models\Speech'),
    ];
});
