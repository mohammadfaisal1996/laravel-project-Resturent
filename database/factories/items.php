<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ItemsList;
use Faker\Generator as Faker;

$factory->define(ItemsList::class, function (Faker $faker) {
    return [
            'category_id' =>rand(1,500),
            'item_name_en' => $this->faker->name,
            'item_name_ar' =>$faker->randomElement(['وانعكس الارتفاع غير العادي في الأسعار الدولية للحبوب فورا على أسعار المواد الغذائية.','وتشمل المراقبة أيضا كميات وأسعار المواد الغذائية المستوردة في إطار القرار.','وبالاضافة إلى ذلك، ينبغي السعي وراء الاستفادة من أي فرص لتحقيق مكاسب غير مباشرة، من قبيل دعم أسواق المنطقة من خلال المشتريات المحلية من الأصناف الغذائية.','وما برح الاعتماد على استيراد الأصناف الغذائية ذات القيمة الغذائية المحدودة يسهم في نقص الفيتامينات والمعادن.','وأُعلن أيضا خفض الضرائب على السلع الغذائية الأساسية المستوردة، وجرى فيما بعد تنفيذه.','ويطلب أيضا المستهلكون معلومات عن طريقة إنتاج المواد الغذائية، ويطالبون بأن يتبع الإنتاج مبادئ مقبولة معينة']),
            'item_price' => $faker->randomElement(['12.0','4','5.9','44','100','12','3','2','55','99','56','34','22.9','13.2']),
            'item_description_en' => $faker->realText(50), 
            'item_description_ar' => $faker->randomElement(['وبالاضافة إلى ذلك، ينبغي السعي وراء الاستفادة من أي فرص لتحقيق مكاسب غير مباشرة، من قبيل دعم أسواق المنطقة من خلال المشتريات المحلية من الأصناف الغذائية.','وما برح الاعتماد على استيراد الأصناف الغذائية ذات القيمة الغذائية المحدودة يسهم في نقص الفيتامينات والمعادن.','وأُعلن أيضا خفض الضرائب على السلع الغذائية الأساسية المستوردة، وجرى فيما بعد تنفيذه.','ويطلب أيضا المستهلكون معلومات عن طريقة إنتاج المواد الغذائية، ويطالبون بأن يتبع الإنتاج مبادئ مقبولة معينة']),          
            'item_status' => $faker->randomElement([1,2]) , 
            'item_image'=> $faker->randomElement(['https://elmqal.com/wp-content/uploads/2021/02/%D9%81%D8%AA%D8%A9-%D8%A8%D8%A7%D8%B0%D9%86%D8%AC%D8%A7%D9%86-%D9%88%D8%AD%D9%85%D8%B5.jpg','https://d1uz88p17r663j.cloudfront.net/resized/0af7aadf1ade6f23c55e42b5130d18f1_Fetteh-Eggplant-&-Humus_944_531.jpg','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJ-Hm05RSWdkDukODZQROopZbFqMPJYxvxzIKHCWQ8-gbDAEvBCSlAcDEhv22fDsUdwac&usqp=CAU','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSzCwbDAWt-kVgiea-MV0xwXtkk6MD20J-20gq_Sh0P3Y1p2zhyh2jyLvTAz4zWfIf8M1e_GquRkYTyag&usqp=CAU','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSQin5STQBfEfI1TMUh9rZgKVMIyJ6_Heg10A&usqp=CAU','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQRqPqdXFby054iSPxV6mZbFdm4-gRDN0Mbqg&usqp=CAU','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQihMTvUTGsce9CrTAja0kgwpOgE1bzGGEdig&usqp=CAU','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRWpT2KJT1JpdQy4HymTVTzpy-JUymY08EXrj5v5mmVBeQdnfed-7FXzJEmVjV-v6GsK9ZAKyStc8pNUw&usqp=CAU'])
    ];
});
