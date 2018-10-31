<?php

use Faker\Generator as Faker;

$factory->define(App\QuestionAnswer::class, function (Faker $faker) {
    return [
        'question_id' => 4,
        'answer' => $faker->text(10),
        'correct' => 0
    ];
});
