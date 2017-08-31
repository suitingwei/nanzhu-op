<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ProfileRecordsController extends Controller
{

    public function index(Request $request)
    {
        $profile_id = $request->get("profile_id");

        $users = DB::table('profile_records')
                   ->leftJoin('t_sys_user', 'profile_records.user_id', '=', 't_sys_user.FID')
                   ->select('t_sys_user.FNAME', 't_sys_user.FLOGIN', 'profile_records.created_at')
                   ->where('profile_records.profile_id', $profile_id)
                   ->orderBy("profile_records.created_at", "desc")
                   ->get();


        return view("admin.profilerecords.index", ["users" => $users]);
    }

}
