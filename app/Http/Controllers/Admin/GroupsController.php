<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function index(Request $request)
    {
        $movie_id = $request->input("movie_id");
		$appends = [];
        if (!$movie_id) {
            $movie_id = 0;
        }

		$appends = ["movie_id" => $movie_id];
        $groups = Group::where("FMOVIE", $movie_id)->paginate(50);
        return view("admin.groups.index", ["groups" => $groups,"appends" => $appends]);
    }

    public function create(Request $request)
    {

        return view("admin.groups.create");
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $data['FNEWDATE'] = date('Y-m-d H:i:s');
        $data['FID']      = Group::max("FID") + 1;
        Group::create($data);
        return redirect()->to("/admin/groups");
    }
}
