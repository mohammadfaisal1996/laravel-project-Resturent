<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AddOnsTitle;
use Faker\Generator as Faker;

$factory->define(AddOnsTitle::class, function (Faker $faker) {
    return [
        "add_ons_name_en" =>$faker->randomElement(['sauce','Hot mustarda sauce ','sweet sauce','garlic sauce']) ,
        "add_ons_name_ar" =>$faker->randomElement(['الجزر المبشور','الفانيليا','السكر','القرفة','الكاكاو','صودا الخبز']) ,
        "item_id" => rand(1,500),
        "min" => $faker->randomElement([-1,2,0,1,3,4,5,6]),
        "max" =>$faker->randomElement([-1,2,0,1,3,4,5,6]) 
    ];
});
