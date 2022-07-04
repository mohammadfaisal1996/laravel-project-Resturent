<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddOnsOrder extends Model
{
    protected $table="order_addons";

    protected $fillable=['order_item_id','AddOns_Category_id','AddOns_Category_name'];



    public  function AddOnsTitle(){

        return $this->belongsTo(AddOnsTitle::class,"AddOns_Category_id", "id");

    }



}
