<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use App\Models\Profile;
use Illuminate\Http\Request;
use DB;

class ProfilesController extends Controller
{
    //
    public function index(Request $request)
    {
        $name = $request->get("name");
        $is_show=$request->get("is_show");
        $position=$request->get("position");
        if($name&&$position == 2){
            $profiles = Profile::where("name", "!=", "")->where("name", "like", "%" . $name . "%")->where("before_position", "!=", "")->where("behind_position", "=", "")->orderBy("updated_at","desc")->paginate(100);
            return view("admin.profiles.index", ["name" => $name,"is_show" => $is_show,"job" => $position,"profiles" => $profiles]);
        }
        if ($name) {
            $profiles = Profile::where("name", "!=", "")->where("name", "like", "%" . $name . "%")->orderBy("sort","desc")->paginate(100);
            return view("admin.profiles.index", ["name" => $name,"is_show" => $is_show,"job" => $position,"profiles" => $profiles]);
        }
        if ($is_show) {
            if($is_show==2){
                $profiles = Profile::where("name", "!=", "")->where("is_show",0)->orderBy("updated_at","desc")->paginate(100);
            }else{
                $profiles = Profile::where("is_show",$is_show)->orderBy("sort","desc")->paginate(100);
            }
            return view("admin.profiles.index", ["name" => $name,"is_show" => $is_show,"job" => $position,"profiles" => $profiles]);
        }
        if ($position) {
            if($position == 2){
                $profiles = Profile::where("before_position", "!=", "")->where("behind_position", "=", "")->orderBy("updated_at","desc")->paginate(100);
            }else{
                $profiles = Profile::where("behind_position", "!=", "")->orderBy("updated_at","desc")->paginate(100);
            }
            return view("admin.profiles.index", ["name" => $name,"is_show" => $is_show,"position" => $position,"profiles" => $profiles]);
        }
        $profiles = Profile::where("avatar", "!=", "")
                            ->where("name", "!=", "")
                            ->where("height", "!=", "")
                            ->where("weight", "!=", "")
                            ->where("gender", "!=", "")
                            ->where("birthday", "!=", "")
                            ->orderBy("updated_at", "desc")->paginate(15);
        return view("admin.profiles.index", ["name" => $name,"is_show" => $is_show,"position" => $position, "profiles" => $profiles]);
    }

    public function create(Request $request)
    {
        return view("admin.profiles.create");
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $file = $request->file("avatar");
        if ($file) {
            $data["avatar"] = Picture::upload("avatar", $file);
        }
        $type = $request->get("type");
        if ($type) {
            $data["type"] = implode(",", $type);
        }
        $before_position=$request->get("before_position");
        if ($before_position) {
            $data["before_position"] = implode(",", $before_position);
        }
        $behind_position=$request->get("behind_position");
        if ($behind_position) {
            $data["behind_position"] = implode(",", $behind_position);
        }
        $profile = Profile::create($data);
        return redirect()->to("/admin/profiles")->with("message", "创建成功");
    }

    public function edit(Request $request, $id)
    {
        $profile = Profile::find($id);
        return view("admin.profiles.edit", ["profile" => $profile]);
    }
    public function sorts(Request $request, $id)
    {

        $sorts=DB::select('select MAX(sort)+1 sort from profiles');

        DB::table('profiles')
            ->where('id', $id)
            ->update(['sort' => $sorts[0]->sort]);

        $profiles = Profile::where("name", "!=", "")->orderBy("sort","desc")->paginate(100);
        return view("admin.profiles.index", ["profiles" => $profiles]);
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::find($id);
        $data    = $request->except("avatar");
        $file    = $request->file("avatar");
        if ($file) {
            $data["avatar"] = Picture::upload("avatar", $file);
        }
        $type = $request->get("type");
        if ($type) {
            $data["type"] = implode(",", $type);
        }else{
            $data["type"] ="";
        }
        $before_position=$request->get("before_position");
        if ($before_position) {
            $data["before_position"] = implode(",", $before_position);
        }else{
            $data["before_position"] ="";
        }
        $behind_position=$request->get("behind_position");
        if ($behind_position) {
            $data["behind_position"] = implode(",", $behind_position);
        }else{
            $data["behind_position"] ="";
        }
        $profile->update($data);
        return redirect()->to("/admin/profiles")->with("message", "创建成功");
    }

    public function destroy($id)
    {
        $profile = Profile::find($id);
        if ($profile) {
            $profile->delete();
            return redirect()->to("/admin/profiles");
        }
    }
}
