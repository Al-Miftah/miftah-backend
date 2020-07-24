<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Organization;
use Faker\Generator as Faker;

$factory->define(Organization::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'digital_address' => $faker->postcode,
        'active' => true,
        'about' => $faker->sentence,
        'phone_number' => $faker->phoneNumber,
        'logo_url' => $faker->imageUrl(100, 100),
        'creator_id' => factory('App\Models\User'),
    ];
});
