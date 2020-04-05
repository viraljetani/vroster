<?php

use Faker\Generator as Faker;

$factory->define(App\Organization::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->companyEmail,
        'phone' => $faker->tollFreePhoneNumber,
        'address' => $faker->streetAddress,
        'city' => 'Sydney',
        'region' => $faker->state,
        'country' => 'AU',
        'postal_code' => $faker->postcode,
    ];
});
