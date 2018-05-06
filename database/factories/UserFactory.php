<?php

use Faker\Generator as Faker;

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
        'nickName'        => $faker->name,
        'email'           => $faker->email,
        'password'        => Hash::make('password'),
        'remember_token'  => str_random(10),
        'activation_code' => str_random(30) . time()
    ];
});
