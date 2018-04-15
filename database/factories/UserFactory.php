<?php

use Faker\Generator as Faker;
// use App\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'active' => 1,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});


// $users = User::all()->pluck('id')->toArray();
// use ($users)

$factory->define(App\Member::class, function (Faker $faker)  {
    return [
        'user_id' => $faker->unique()->numberBetween(3, 152), // randomElement($users), //  // 8567,
        'organization_id' => $faker->randomDigitNotNull,
        'client_id' => $faker->numberBetween(0, 25)
    ];
});