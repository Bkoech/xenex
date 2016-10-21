<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Xenex\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\Xenex\Course\Course::class, function (Faker\Generator $faker) {
    $date = [
        $faker->date(), $faker->date(),
    ];

    return [
        'serial' => str_random(5),
        'name' => $faker->name,
        'start_at' => strtotime($date[0]) > strtotime($date[1]) ? $date[1] : $date[0],
        'end_at' => strtotime($date[0]) > strtotime($date[1]) ? $date[0] : $date[1],
    ];
});
