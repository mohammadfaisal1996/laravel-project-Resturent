<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AddOnsList;
use Faker\Generator as Faker;

$factory->define(AddOnsList::class, function (Faker $faker) {
    return [
        "add_ons_cat_id" =>rand(1,500),
        "add_ons_list_en" => $faker->randomElement(['BBQ sauce','Hot mustarda sauce ','sweet sauce','garlic sauce']) ,
        "add_ons_list_ar" => $faker->randomElement(['الجزر المبشور','الفانيليا','السكر','القرفة','الكاكاو','صودا الخبز']) ,
        "price" => $faker->randomElement([12,33,4.5,22,3.3,100,44,21,11]),
        "status" =>$faker->randomElement([1,2])
    ];
});
