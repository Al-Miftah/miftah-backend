<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Speaker::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'bio' => $faker->sentence(),
        'avatar' => $faker->imageUrl(),
    ];
});
