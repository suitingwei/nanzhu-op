<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use App\Models\Video;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return view("admin.videos.index", ["videos" => $videos]);
    }

    public function create(Request $request)
    {
        return view("admin.videos.create");
    }

    public function store(Request $request)
    {
        $data          = $request->all();
        $data["cover"] = Picture::upload($request->file("cover"), "/uploads/videos/");
        $video         = Video::create($data);
        return redirect()->to("/admin/videos")->with("message", "创建成功");
    }

    public function destroy($id)
    {
        $video = Video::find($id);
        if ($video) {
            $video->delete();
            //删除feed

            return redirect()->to("/admin/videos")->with("message", "删除成功");
        }
    }

}
