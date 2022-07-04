<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class RoleController extends Controller
{

    use Helper;

    public function index(){
        if(!hasPermissions("admin-control"))
            abort("401");

        $data['roles'] = Role::all();
        return view("roles.index",$data);
    }

    public function create(){
        if(!hasPermissions("admin-control"))
            abort("401");

        $data["permissions"]= Permission::all();
        if(Session::has("permissions")){
            $data["permissionsSelected"] = Session::get("permissions");
            Session::forget("permissions");
        }

        return view("roles.create",$data);
    }

    public function store(Request $request){
        if(!hasPermissions("admin-control"))
            abort("401");

        $valid = Validator::make($request->all(), ["name" => "required|max:255|unique:admin_roles"]);
        if($valid->fails()){
            Session::put("permissions",array_flip($request->permissions));
            return redirect()->route("roles.create")->withErrors($valid->errors())->withInput($request->all());
        }

        $role = new Role();
        $role->name = $request->name;
        $role->save();
        if($request->permissions)
            $role->permissions()->sync($request->permissions);
        $this->setPageMessage("The Role Has Been Created Successfully");
        return redirect()->route("roles.index");
    }

    public function edit($id){
        if(!hasPermissions("admin-control"))
            abort("401");

        $role = Role::findOrFail($id);
        $data["permissions"]= Permission::all();
        $rolePermissions = [];
        foreach ($role->permissions as $permission){
            $rolePermissions[$permission->id] = true;
        }

        if(Session::has("permissions")){
            $data["permissionsSelected"] = Session::get("permissions");
            Session::forget("permissions");
        }
        $data["rolePermissions"] = $rolePermissions;
        $data["role"] = $role;

        return view("roles.edit",$data);
    }

    public function update (Request $request, $id){
        if(!hasPermissions("admin-control"))
            abort("401");

        $role = Role::findOrFail($id);
        $rules = ["name" => "required|max:255"];
        if($role->name != $request->name)
            $rules = ["name" => "required|max:255|unique:admin_roles"];
        $valid = Validator::make($request->all(), $rules);
        if($valid->fails()){
            Session::put("permissions",array_flip($request->permissions));
            return redirect()->route("roles.edit",$role->id)->withErrors($valid->errors())->withInput($request->all());
        }

        $role->name = $request->name;
        $role->save();
        if($request->permissions)
            $role->permissions()->sync($request->permissions);
        $this->setPageMessage("The Role Has Been Updated Successfully");
        return redirect()->route("roles.index");
    }

    public function destroy(Request $request, $id){
        if(!hasPermissions("admin-control"))
            abort("401");

        Role::find($id)->delete();
        $this->setPageMessage("The Role Has Been Deleted Successfully",0);
        return redirect()->route("roles.index");
    }
}
