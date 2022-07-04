<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ["city_name"];
    protected $table = "cities";
    public $timestamps=false;


    public function areas(){
        return $this->hasMany(Area::class, 'city_id', 'id');
    }

}
