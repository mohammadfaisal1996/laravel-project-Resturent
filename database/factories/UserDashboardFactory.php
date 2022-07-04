<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\UsersDashboard;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(UsersDashboard::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' =>  "admin", // password
        'remember_token' => Str::random(10),
        "active" => 1
    ];
});
