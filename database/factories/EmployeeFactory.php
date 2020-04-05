<?php

use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->tollFreePhoneNumber,
        'address' => $faker->streetAddress,
        'city' => 'Sydney',
        'region' => $faker->state,
        'country' => 'AU',
        'postal_code' => $faker->postcode,
    ];
});
