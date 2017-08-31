<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use App\Models\Profile;
use App\Models\Album;
use Illuminate\Http\Request;
use DB;


class ImageForAlbumController extends Controller
{
    //

    public function edit($id){

        $profile = Profile::find($id);

        return view('admin.profiles.editpic',compact('profile'));
    }
    public function update(Request $request,$id){
        $profile=Profile::find($id);
        $album1 = $request->file("album1");
        $this->create_ablum($album1, "形象照", $profile);
        $album2 = $request->file("album2");
        $this->create_ablum($album2, "剧照", $profile);
        return redirect()->to("/admin/profiles/")->with("message", "创建成功");
    }
    public function create_ablum($albums, $title, $profile)
    {
        Album::where("title", $title)->where("profile_id", $profile->id)->delete();

            if($albums) {
                $album             = new Album;
                $album->title      = $title;
                $album->color      = "#00FF00";
                $album->profile_id = $profile->id;
                $album->save();

                foreach($albums as $key => $alu) {
                    if($alu) {
                        $pictrue           = new Picture;
                        $pictrue->url      = Picture::upload("pictures/" . $profile->id, $alu);
                        $pictrue->album_id = $album->id;
                        $pictrue->save();
                    }
                }
            }

    }


}
