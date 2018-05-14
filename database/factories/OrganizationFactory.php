<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Organization::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->company,
        'user_id' => $faker->unique()->numberBetween(3, 150),
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'country' => $faker->country,
        'number_of_staff' => 1,
        'phone_number' => $faker->e164PhoneNumber,
        'description' => $faker->sentence(10, true),
    ];
});

$factory->define(App\Models\Client::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->company,
        'user_id' => $faker->unique()->numberBetween(3, 150),
        'organization_id' => $faker->numberBetween(1, 8),
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'country' => $faker->country,
        'email' => $faker->unique()->safeEmail,
        'number_of_staff' => 1,
        'phone_number' => $faker->e164PhoneNumber,
        'description' => $faker->sentence(10, true),
    ];
});