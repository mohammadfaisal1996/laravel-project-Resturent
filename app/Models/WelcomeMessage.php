<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeMessage extends Model
{

    protected $fillable = ["TextMessage_En","TextMessage_Ar"];
    protected $table = "WelcomeMessage";



}