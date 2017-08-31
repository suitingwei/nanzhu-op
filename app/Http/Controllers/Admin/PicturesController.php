<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use Illuminate\Http\Request;
use Easemob\Easemob;

class PicturesController extends Controller
{
    public function index(Request $request)
    {
        $pictures   = Picture::orderby("id", "desc")->paginate(15);
        $profile_id = $request->get("profile_id");
        return view("admin.pictures.index", ["pictures" => $pictures, "profile_id" => $profile_id]);
    }

    public function create(Request $request)
    {
        return view("admin.pictures.create");
    }

    public function store(Request $request)
    {
        $file        = $request->file("url");
        $data['url'] = Picture::upload("pictures", $file);
		$data['is_startup'] = $request->get("is_startup");
        $data['jump_url'] = $request->get("jump_url");
        Picture::create($data);
        return redirect()->to("/admin/pictures")->with("message", "创建成功");
    }

    public function destroy(Request $request, $id)
    {
        $picture = Picture::find($id);
        $picture->delete();
        return redirect()->to("/admin/pictures")->with("message", "删除成功");
    }
}
