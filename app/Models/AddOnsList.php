<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddOnsList extends Model
{
    protected $fillable = ["add_ons_cat_id","add_ons_list_en", "add_ons_list_ar", "price", "status"];
    protected $table = "add_ons_list";
    public $timestamps=false;


    public function addOnsTitle(){
        return $this->belongsTo(AddOnsTitle::class,"add_ons_cat_id", "id");
    }
}
