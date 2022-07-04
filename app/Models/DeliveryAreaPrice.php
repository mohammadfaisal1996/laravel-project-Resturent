<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryAreaPrice extends Model
{
    protected $fillable = ["country", "governorate","locality", "sub_locality", "neighborhood", "price", "supported"];
    protected $table = "delivery_areas_price";
    public $timestamps=false;


}
