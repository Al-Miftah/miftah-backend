<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Donation;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Donation::class, function (Faker $faker) {
    return [
        'status' => 'success',
        'gateway' => 'paystack',
        'transaction_reference' => Str::random(),
        'amount' => 500, //5 cedis equivalent. Lowest denomination
        'currency' => 'GHS',
        'channel' => 'mobile_money',
        'user_id' => factory('App\Models\User'),
        'organization_id' => factory('App\Models\Organization'),
        'additional_information' => $faker->sentence,
    ];
});
