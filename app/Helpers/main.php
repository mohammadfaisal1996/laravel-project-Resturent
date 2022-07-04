<?php

use Illuminate\Support\Facades\Gate;

function gateCRUDPermissions($mainName){
    return Gate::check("view-" . $mainName) || Gate::check("create-" . $mainName)
        || Gate::check("update-" . $mainName) || Gate::check("delete-" . $mainName);
}

function getAllCuurentYearMonthsUntilCurrentMonth(){
    $cuurentMonth = date("n",time());
    for ($month=1; $month <= $cuurentMonth ; $month++) {
        $months_number[] = $month;
        $months_name[] = date("F", mktime(0,0,0,$month,10));
    }
    return ["months_number" => $months_number, "months_name" => $months_name];
}

function is_work($permissions){
    $user = Auth::user();
    return Gate::allows($permissions);
}

function hasPermissions($permissions){
    $user = Auth::user();
    if($permissions == "admin-control"){
        if($user->is_admin == 1)
            return true;
        return false;
    }

    if($user->is_admin == 1)
        return true;

    if(is_array($permissions)){
        foreach ($permissions as $permission){
            if(Gate::allows($permission)){
                return true;
            }
        }
    }else{
        if(Gate::allows($permissions)){
            return true;
        }
    }
    return false;
}
