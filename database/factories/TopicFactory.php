<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    $title = $faker->word;
    $slug = str_slug($title);
    return [
        'title' => $title,
        'slug' => $slug,
    ];
});
