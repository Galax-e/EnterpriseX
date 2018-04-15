<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Project::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->text(20),
        'organization_id' => $faker->numberBetween(1, 8),
        'client_id' => $faker->numberBetween(1, 25),
        'internal' => $faker->numberBetween(0, 1),
        'description' => $faker->sentence(10, true)
    ];
});