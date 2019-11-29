<?php
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    $title = $faker->sentence;
    return [
        'title' => $title,
        'description' => $faker->sentence
    ];
});
