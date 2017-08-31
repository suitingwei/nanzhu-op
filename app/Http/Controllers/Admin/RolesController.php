<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    //

    public function index()
    {
        $roles = Role::all();
        return view("admin.roles.index", ["roles" => $roles]);
    }

    public function create(Request $request)
    {
        return view("admin.roles.create");
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $role = Role::create($data);
        return redirect()->to("/admin/roles")->with("message", "创建成功");
    }



    public function edit(Request $request, $id)
    {
        $roles = Role::where("id",$id)->first();
        return view("admin.roles.edit", ["roles" => $roles]);
    }
    public function update(Request $request, $id)
    {
        $data = $request->except("_token","_method");
        $role = Role::where("id",$id)->first();
        if($role) {
            Role::where("id",$id)->update($data);
            return redirect()->to("/admin/roles")->with("message","修改成功");
        }
    }
    public function delete(Request $request)
    {
        $id = $_GET['id'];
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return redirect()->to("/admin/roles")->with("message","删除成功");
        }
    }

}

