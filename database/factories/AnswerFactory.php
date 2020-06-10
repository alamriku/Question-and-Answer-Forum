<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'user_id'=>App\User::pluck('id')->random(),
        'body'=>$faker->paragraphs(rand(3,7),true),
        'votes_count'=>rand(-3,10),
    ];
});
