<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CategoryList;
use Faker\Generator as Faker;

$factory->define(CategoryList::class, function (Faker $faker) {
    
    
    
    
    return [
        //
        'category_name_en'=>$this->faker->name,
        'category_name_ar'=>$faker->randomElement(['دجاج','سلطة','رفتة بمكدوس','فتة باذنجان','حمص']),
        'category_image_url'=>$faker->randomElement(['https://i0.wp.com/www.alsharqiacafes.com/wp-content/uploads/2020/01/81142973_829136794199508_3246887205457704022_n.jpg?w=810&ssl=1','https://i0.wp.com/www.alsharqiacafes.com/wp-content/uploads/2020/01/81783658_641797449691839_5222504402087232214_n.jpg?w=810&ssl=1','http://abu-jbara.net/wp-content/uploads/2013/04/%D8%AD%D9%85%D8%B5.jpg','https://www.justfood.tv/big/homos%20fatta.jpg','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMVNn78CoJe51nkGcxqnclvpaYI1A_YPsB8NTsG_W9Nls2MqhkzUH9RLrQBBk50W7Q4k3vADMm-EFl0A&usqp=CAU','https://www.alrakia.com/wp-content/uploads/2017/11/%D9%81%D8%AA%D8%A9-%D8%A7%D9%84%D8%A8%D8%A7%D8%B0%D9%86%D8%AC%D8%A7%D9%86.jpg','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTZkg4KkxOy9ubfDr6rqd1dasxDQ1tb4DDbX5wvOu5fLQD5t1fZfeWUfmnBKtcstR1Ux-xqMy34FSewRQ&usqp=CAU']),
        'category_status'=>$faker->randomElement([1,2])
        
    ];
              

    
});
