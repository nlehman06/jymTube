<?php

use Faker\Generator as Faker;

$factory->define(App\Video::class, function (Faker $faker) {
    return [
        'provider'             => $faker->randomElement(['youtube', 'facebook']),
        'provider_id'          => $faker->randomNumber(9),
        'title'                => $faker->sentence,
        'description'          => $faker->paragraph,
        'permalink_url'        => $faker->url,
        'length'               => $faker->time(),
        'picture'              => $faker->url,
        'created_time'         => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        'from_id'              => $faker->randomNumber(9),
        'from_name'            => $faker->name(),
        'from_profile'         => $faker->url,
        'submitted_by_user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'submitted_date'       => $faker->dateTimeThisYear(),
        'status'               => 'submitted'
    ];
});
