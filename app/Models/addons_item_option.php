<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class addons_item_option extends Model
{
    //
        protected $fillable = ["OrderAddOnsID","AddOns_id", "AddOns_name", "AddOns_price"];
        protected $table = "order_addons_option";
}
