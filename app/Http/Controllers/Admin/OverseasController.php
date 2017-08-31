<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MovieBasement;
use App\Models\Picture;
use Illuminate\Http\Request;

class OverseasController extends Controller
{
    //
    public function index(Request $request)
    {
        $title      = $request->get("title");
        $created_at = $request->get("created_at");
        if ($created_at) {
            $basements = MovieBasement::where("created_at", "like", "%" . $created_at . "%")->where("type","overseasRecord")->orderBy("sort",
                "desc")->paginate(20);
            return view("admin.overseas.index", compact("basements"));
        }
        if ($title) {
            $basements = MovieBasement::where("title", "like", "%" . $title . "%")->where("type","overseasRecord")->orderBy("sort",
                "desc")->paginate(20);
            return view("admin.overseas.index", compact("basements"));
        }

        $basements = MovieBasement::where('type','overseasRecord')->orderBy("sort", "desc")->paginate(20);
        return view("admin.overseas.index", compact("basements"));
    }

    public function create(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        return view("admin.overseas.create", compact('user_id'));
    }

    public function store(Request $request)
    {
        set_time_limit(0);
        $cover                      = $request->file("cover");
        $data['cover']              = Picture::upload("covers/" . time(), $cover);
        $data['title']              = $request->input("title");
        $data['type']               = $request->input("type");
        $data['sort']               = $request->input("sort");
        $data['introduction']       = $request->input("introduction");
        $data['content']            = $request->input('content');

        $basement = MovieBasement::create($data);

        $files   = $request->file("pic_url");
        if($files ) {
            foreach ($files as $key => $file) {
                if ($file) {
                    $picture              = new Picture;
                    $picture->url         = Picture::upload("pictures/" . $basement->id, $file);
                    $picture->basement_id = $basement->id;
                    $picture->save();
                }
            }
        }
        return redirect()->to("/admin/overseas/")->with("message", "创建成功");

    }

    public function edit($basementId, Request $request)
    {
        $basement = MovieBasement::find($basementId);
        $picurls  = Picture::where('basement_id',$basementId)->get();
        return view('admin.overseas.edit', compact('basement','picurls'));
    }
    public function update($basementId, Request $request)
    {
        $basement = MovieBasement::find($basementId);

        if ($basement) {
            $basement->update($request->only('title', 'content', 'introduction','sort'));
            if ($request->hasFile('cover')) {
                $basement->update(['cover' => Picture::upload("covers/" . time(), $request->file('cover'))]);
            }

            if ($request->hasFile('pictures')) {
                $basement->pictures()->delete();
                $pictureFiles =$request->file('pictures');
                foreach ($pictureFiles as $key => $pictureFile) {
                    if($pictureFile){
                        $picture             = new Picture;
                        $picture->url        = Picture::upload("pictures/" . $basement->id, $pictureFile);
                        $picture->basement_id = $basement->id;
                        $picture->save();
                    }

                }
            }
        }

        return redirect()->to("/admin/overseas");
    }
}
