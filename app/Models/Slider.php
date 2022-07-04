<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        "type", "navigate_id", "Status", "Silder_image", "created_at", "updated_at"
    ];
    protected $table="sliders";

    protected $appends = ["directory_path","img_path_url", "navigator_name_en", "navigator_name_ar"];


    public function getDirectoryPathAttribute(){
        return "uploads" . DS . "main-slider" . DS;
    }

    public function getImgPathUrlAttribute(){
        return "https://dashboard.fattehsanawbar.digisolapps.com/uploads/main-slider/";
    }

    public function navigator(){
        $navigate = $this->type == 1 ? CategoryList::class : ItemsList::class;
        return $this->hasOne($navigate, 'id','navigate_id');
    }

    public function getNavigatorNameEnAttribute(){
       return  $this->navigator()->exists() ?
           ($this->type == 1 ? $this->navigator->category_name_en : $this->navigator->item_name_en)
           : null;
    }
    public function getNavigatorNameArAttribute(){
        return  $this->navigator()->exists() ?
            ($this->type == 1 ? $this->navigator->category_name_ar : $this->navigator->item_name_ar)
            : null;
    }
}
