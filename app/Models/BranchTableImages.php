<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchTableImages extends Model
{
    protected $fillable = ["branch_id","image_url"];
    protected $table = "branch_table_images";
    public $timestamps = false;
    protected $appends = ["directory_path","img_path_url"];


    public function branch(){
        return $this->belongsTo(BranchTable::class, "branch_id", "id");
    }

    public function getDirectoryPathAttribute(){
        return "uploads" . DS . "sliders_branches" . DS . $this->branch_id . DS;
    }

    public function getImgPathUrlAttribute(){
    return "https://dashboard.fattehsanawbar.digisolapps.com/uploads/sliders_branches/" . $this->branch_id . "/";
    }
}
