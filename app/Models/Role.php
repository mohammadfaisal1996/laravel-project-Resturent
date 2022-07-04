<?php

namespace App\Models;

use App\UsersDashboard;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ["id","name"];
    protected $table = "admin_roles";
    public $timestamps = false;

    public function permissions(){
        return $this->belongsToMany(Permission::class, "admin_role_permission", "role_id", "permission_id");
    }

    public function users(){
        return $this->hasMany(UsersDashboard::class, "role_id", "id");
    }
}
