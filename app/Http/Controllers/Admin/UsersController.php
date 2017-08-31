<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Role;
use App\Models\RoleUser;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->get("phone")) {
            $users = User::where("FLOGIN", $request->get("phone"))->paginate(100);
            return view("admin.users.index", ["users" => $users]);
        }
        if ($request->get("name")) {
            $userIds = Profile::where('name', 'like', '%' . $request->input('name') . '%')->pluck('user_id');
            $users   = User::whereIn('FID', $userIds->all())->orWhere('FNAME', 'like', "%{$request->input('name')}%")->paginate(100);
            return view("admin.users.index", ["users" => $users]);
        }
        if ($request->get("FID")) {
            $users = User::where("FID", $request->get("FID"))->paginate(100);
            return view("admin.users.index", ["users" => $users]);
        }
        $users = User::paginate(100);
        return view("admin.users.index", ["users" => $users]);
    }

    public function show(Request $request, $id)
    {
        $user = User::where("FID", $id)->first();
        return view("admin.users.show", ["user" => $user]);
    }

    public function edit(Request $request, $id)
    {
        $user  = User::where("FID", $id)->first();
        $roles = Role::all();
        return view("admin.users.edit", ["user" => $user, "roles" => $roles]);
    }

    public function update(Request $request, $id)
    {
        $data['FSEX']  = $request->get("FSEX");
        $data['FNAME'] = $request->get("name");
        $user          = User::where("FID", $id)->first();
        if ($user) {
            $role_ids = $request->get("role_ids");
            //dd($role_ids);
            //增加人员角色每次编辑时都删除原始角色
            $role = RoleUser::where("user_id", $user->FID)->first();
            if ($role) {
                RoleUser::where("user_id", $user->FID)->delete();
            }
            if ($role_ids) {
                foreach ($role_ids as $role_id) {
                    Role::add_user($user->FID, $role_id);
                }
            }
            return redirect()->to("/admin/users")->with("message", "操作成功");
        }
    }

    public function search(Request $request)
    {
        $users = User::where('FPHONE', 'like', '%' . $request->input('query') . '%')->take(20)->get()->map(function (User $user) {
            return [
                'value' => $user->FNAME ?: '',
                'data'  => $user,
            ];
        });

        return response()->json(['suggestions' => $users, 'query' => $request->input('query')]);
    }
}
