<?php

use Faker\Generator as Faker;

$factory->define(App\Quiz::class, function (Faker $faker) {
    return [
        'title' => $faker->text(20),
        'user_id' => 1,
        'answers_count' => 4
    ];
});
