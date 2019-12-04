<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Answer::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence,
        'speaker_id' => factory('App\Models\Speaker'),
        'question_id' => factory('App\Models\Question'),
    ];
});
