<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupUser;
use Illuminate\Http\Request;

class GroupUsersController extends Controller
{
    //

    public function index(Request $request)
    {
        $group_id    = $request->get("group_id");
        $group_users = GroupUser::where("FGROUP", $group_id)->paginate(15);
        return view("admin.group_users.index", ["group_users" => $group_users]);
    }
}
