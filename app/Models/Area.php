<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ["area_name", "city_id"];
    protected $table = "cities_area";
    public $timestamps=false;


}
