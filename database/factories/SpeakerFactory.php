<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Speaker::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'password' => '$2y$10$F43PJA7B/5zHE8w0IsewiefgRsjeLscwBK0QrDH8/.YD9KTNs1n6.', //secret123
        'phone_number' => $faker->phoneNumber,
        'city' => $faker->city,
        'location_address' => $faker->address,
        'bio' => $faker->sentence(),
        'avatar' => $faker->imageUrl(),
    ];
});
