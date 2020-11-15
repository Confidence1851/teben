<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Referral;
use App\User;
use Faker\Generator as Faker;

$factory->define(Referral::class, function (Faker $faker) {
    return [
        "referrer_id" => 155,
        "user_id" =>   User::inRandomOrder()->value("id"),
        "parent_points" => 10,
        "my_points" => 2,
    ];
});
