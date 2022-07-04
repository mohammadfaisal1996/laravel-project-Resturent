<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = ["whats_app_number","whats_app_message","phone_number",
                            "web_url", "facebook_url", "instagram_url", 
                            "google_play_url", "app_store_url","minimum_order"];
    protected $table = "app_settings";
    public $timestamps=false;
    
    
}
