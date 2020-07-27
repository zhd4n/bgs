<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Participant;
use Faker\Generator as Faker;

$factory->define(Participant::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'email'      => $faker->unique()->safeEmail,
    ];
});
