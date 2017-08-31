<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Picture;
use Illuminate\Http\Request;

class AlbumsController extends Controller
{
    public function index(Request $request)
    {
        $profile_id = $request->get("profile_id");
        $albums     = Album::where("profile_id", $profile_id)->get();
        return view("admin.albums.index", ["albums" => $albums, "profile_id" => $profile_id]);
    }

    public function create(Request $request)
    {
        $profile_id = $request->get("profile_id");
        return view("admin.albums.create", ["profile_id" => $profile_id]);
    }

    public function store(Request $request)
    {
        $data  = $request->except("pic_url");
        $album = Album::create($data);
        $files = $request->file("pic_url");
        foreach ($files as $key => $file) {
            if ($file) {
                $picture           = new Picture;
                $picture->url      = Picture::upload("albums/" . $album->id, $file);
                $picture->album_id = $album->id;
                $picture->save();
            }
        }

        return redirect()->to("/admin/albums?profile_id=" . $album->profile_id)->with("message", "创建成功");
    }

    public function destroy(Request $request, $id)
    {

        $album      = Album::find($id);
        $profile_id = $album->profile_id;
        if ($album) {
            $album->delete();
        }
        return redirect()->to("/admin/albums?profile_id=" . $profile_id)->with("message", "创建成功");
    }
}
