<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Team::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->departmentName, //text(20),
        'project_id' => $faker->randomDigitNotNull,
    ];
});


$factory->define(App\TeamMember::class, function (Faker $faker) {
    return [
        //
        'member_id' => $faker->randomDigitNotNull,
        'team_id' => $faker->randomDigitNotNull,
    ];
});