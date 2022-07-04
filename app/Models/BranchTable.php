<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchTable extends Model
{
    protected $imgDirectoryPath = "uploads" . DS . "branches" . DS;
    protected $appends = ["imgPath","imgPathUrl"];
    protected $fillable = ["store_name","latitude", "longitude", "img_url", "phone_number","location_name_ar","location_name_en","tax"];
    protected $table = "branch_table";
    public $timestamps = false;

    public function getImgPathAttribute(){
        return $this->imgDirectoryPath;
    }
    public function getImgPathUrlAttribute(){
        return "https://dashboard.fattehsanawbar.digisolapps.com/uploads/branches/";
    }


    public function sliders(){
        return $this->hasMany(BranchTableImages::class, "branch_id", "id");
    }


}
