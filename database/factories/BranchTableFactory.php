<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BranchTable;
use Faker\Generator as Faker;

$factory->define(BranchTable::class, function (Faker $faker) {
    return [
      "store_name" => $this->faker->name,
      "latitude" =>$faker->randomElement([31.969080802594192,34.969080802594192,33.969080802594192,31.559080802594192,38.969080802594192,32.969080802594192,34.339080802594192]) ,
      "longitude" => $faker->randomElement([35.969080802594192,33.969080802594192,32.969080802594192,31.889080802594192,32.966080802594192,32.969080802594192]),
      "img_url" => 'https://dashboard.goldenmealpro.digisolapps.com/uploads/logo-blue.png', 
      "phone_number" =>$faker->phoneNumber
    ];
});
