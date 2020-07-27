<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'title'     => $faker->company.' Event',
        'city'      => $faker->city,
        'starts_at' => $faker->dateTimeBetween('now', '+1 year'),
    ];
});
