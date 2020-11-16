<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Note;
use Faker\Generator as Faker;

$factory->define(Note::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 2, $max = 11),
        'note' => $faker->paragraph($nbSentences = 1, $variableNbSentences = true)
    ];
});
