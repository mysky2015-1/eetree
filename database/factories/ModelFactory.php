<?php

$factory->define(App\Models\Admin::class, function (Faker\Generator $faker) {
    static $password;

    $name = $faker->firstName;
    return [
        'username' => $name,
        'name' => $name,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
