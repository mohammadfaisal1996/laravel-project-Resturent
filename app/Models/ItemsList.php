<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsList extends Model
{
    protected $fillable = [
        'category_id', 'item_name_en', 'item_name_ar', 'item_price', 'item_description_en', 'item_description_ar',
        'item_status', 'item_image','selling_count'
    ];
    protected $table="items_list";
    public $timestamps=false;

    protected $appends = ["directory_path","img_path_url"];


    public function getDirectoryPathAttribute(){
        return "uploads" . DS . "items" . DS;
    }

    public function getImgPathUrlAttribute(){
        return "https://dashboard.fattehsanawbar.digisolapps.com/uploads/items/";
    }


    public function category(){
        return $this->hasOne(CategoryList::class,  'id','category_id');
    }

    public function OrderItem(){
        return $this->hasMany(OrderItem::class, "item_id", "id");

    }

//    public function sliders(){
//        return $this->belongsTo(Slider::class, )
//    }


}
