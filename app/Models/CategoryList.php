<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryList extends Model
{
    protected $fillable = [
        'category_name_en', 'category_name_ar', 'category_image_url', 'category_status',
    ];
    protected $table = "category_list";

    protected $appends = ["directory_path","img_path_url"];
    public $timestamps = false;

    public function getDirectoryPathAttribute(){
        return "uploads" . DS . "categories" . DS;
    }

    public function getImgPathUrlAttribute(){
        return "https://dashboard.fattehsanawbar.digisolapps.com/uploads/categories/";
    }

    public function item(){
        return $this->belongsTo(ItemsList::class, 'category_id', 'id');
    }
}
