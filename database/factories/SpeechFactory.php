<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Speech::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'summary' => $faker->sentence,
        'transcription' => $faker->sentence,
        'url' => $faker->url,
        'cover_photo' => $faker->imageUrl(),
        'speaker_id' => factory('App\Models\Speaker'),
        'topic_id' => factory('App\Models\Topic'),
    ];
});
