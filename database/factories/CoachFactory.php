<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Coach;
use Faker\Generator as Faker;

$factory->define(Coach::class, function (Faker $faker) {
    return [
        'user_id' => $faker->unique()->numberBetween($min = 2, $max = 11),
        'category_id' => $faker->numberBetween($min = 1, $max = 4),
        'price' => $faker->numberBetween($min = 20, $max = 40),
        'phone' => $faker->phoneNumber,
        'msg_title' => $faker->word,
        'msg_body' => $faker->paragraph($nbSentences = 5, $variableNbSentences = true)
    ];
});
