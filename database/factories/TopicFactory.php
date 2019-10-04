<?php
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    $title = $faker->word;
    $slug = Str::slug($title);
    return [
        'title' => $title,
        'slug' => $slug,
    ];
});
