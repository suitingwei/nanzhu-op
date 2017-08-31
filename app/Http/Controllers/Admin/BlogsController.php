<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Message;
use App\Models\Picture;
use App\Models\PushRecord;
use App\User;
use DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Log;


class BlogsController extends Controller
{
    //
    public function index(Request $request)
    {

        $type        = $request->get("type");
        $type_arr    = Blog::type_arr()[$type];
        $name        = $request->get("title");
        $is_approved = $request->get("is_approved");
        $type_value  = $request->get("type_value");
        $created_at  = $request->get("created_at");
        $appends     = ["type"        => $type,
                        "name"        => $name,
                        "is_approved" => $is_approved,
                        "type_value"  => $type_value,
                        "created_at"  => $created_at
        ];
        if ($name) {
            $blogs = Blog::where("title", "like", "%" . $name . "%")->where("type", $type)->orderBy("created_at",
                                                                                                    "desc")->paginate(100);
            return view("admin.blogs.index",
                        ["blogs" => $blogs, "type" => $type, "type_arr" => $type_arr, "appends" => $appends]);
        }
        if ($type_value) {
            $blogs = Blog::where("type_value", $type_value)->where("type", $type)->orderBy("created_at",
                                                                                           "desc")->paginate(100);
            return view("admin.blogs.index",
                        ["blogs" => $blogs, "type" => $type, "type_arr" => $type_arr, "appends" => $appends]);
        }
        if ($is_approved) {
            $blogs = Blog::where("is_approved", $is_approved)->where("type", $type)->orderBy("created_at",
                                                                                             "desc")->paginate(100);
            return view("admin.blogs.index",
                        ["blogs" => $blogs, "type" => $type, "type_arr" => $type_arr, "appends" => $appends]);
        }
        if ($created_at) {
            $blogs = Blog::where("created_at", "like", $created_at . "%")->where("type", $type)->orderBy("created_at",
                                                                                                         "desc")->paginate(100);
            return view("admin.blogs.index",
                        ["blogs" => $blogs, "type" => $type, "type_arr" => $type_arr, "appends" => $appends]);
        }
        $blogs = Blog::where("is_approved", 0)->where("type", $type)->orderBy("created_at", "desc")->paginate(20);

        return view("admin.blogs.index",
                    ["blogs" => $blogs, "type" => $type, "type_arr" => $type_arr, "appends" => $appends]);
    }

    public function edit(Request $request, $id)
    {
        $blog     = Blog::find($id);
        $type_arr = Blog::type_arr()[$blog->type];
        return view("admin.blogs.edit", ["blog" => $blog, "type_arr" => $type_arr]);

    }

    public function update(Request $request, $id)
    {

        $blog = Blog::find($id);
        $data = $request->all();
        if ($blog->is_approved == 0 && $data['is_approved'] == 1 && $data['author_id'] != "") {
            $user = User::where("FID", $data['author_id'])->first();
            if ($user && $user->FALIYUNTOKEN) {
                $mdata['title']     = "审核通过";
                $mdata['content']   = "审核通过" . $data["approved_opinion"];
                $mdata['type']      = "SYSTEM";
                $mdata['scope']     = 1;
                $mdata['scope_ids'] = $data["author_id"];
                $message            = Message::create($mdata);
                $uri                = $request->root() . "/mobile/messages/" . $message->id;
                $mdata['uri']       = $uri;
                $message->update($mdata);
                $extra = ["uri" => $uri];
                PushRecord::send($user->FALIYUNTOKEN, $message->title, $message->content, $message->title, $extra,
                                 false);
            }
        }
        if ($blog->is_approved == 0 && $data['is_approved'] == 2 && $data['author_id'] != "") {
            $user = User::where("FID", $data['author_id'])->first();
            if ($user && $user->FALIYUNTOKEN) {
                $mdata['title']     = "审核未通过";
                $mdata['content']   = "审核未通过" . $data["approved_opinion"];
                $mdata['type']      = "SYSTEM";
                $mdata['scope']     = 1;
                $mdata['scope_ids'] = $data["author_id"];
                $message            = Message::create($mdata);
                $uri                = $request->root() . "/mobile/messages/" . $message->id;
                $mdata['uri']       = $uri;
                $message->update($mdata);
                $extra = ["uri" => $uri];
                PushRecord::send($user->FALIYUNTOKEN, $message->title, $message->content, $message->title, $extra,
                                 false);
            }
        }
        // 上传本地文件
        $files  = $request->file("pic_url");
        $picids = $request->get("pic_ids");
        $pics   = Picture::where("blog_id", $blog->id)->get();
        foreach ($files as $key => $file) {
            $del=$key+1;
            if ($file) {
                if (isset($pics[$key])) {
                    $url = Picture::upload("pictures/" . $blog->id, $file);
                    DB::table('pictures')
                      ->where('id', $picids[$key])
                      ->update(['url' => $url]);
                    continue;
                }
                $picture          = new Picture;
                $picture->url     = Picture::upload("pictures/" . $blog->id, $file);
                $picture->blog_id = $blog->id;
                $picture->save();
            }

            $pic_del=$request->get("pic_del_".$del);
            if($pic_del){
                DB::table('pictures')->where('id', $picids[$key])->delete();
                continue;
            }

        }
        $is_trend_cover=$request->get("is_trend_cover");
        if($is_trend_cover){
            $trend_cover = $request->file("trend_cover");
            if($trend_cover){
                $url = Picture::upload("trend_cover/" . $blog->id, $trend_cover);
                DB::table('blogs')
                    ->where('id', $blog->id)
                    ->update(['trend_cover' => $url]);
            }
        }

        $trend_cover_del=$request->get("trend_cover_del");
        if($trend_cover_del){
            DB::table('blogs')
                ->where('id', $blog->id)
                ->update(['trend_cover' => '']);
        }

        $blog->update($data);
        DB::table('blogs')
          ->where('id', $blog->id)
          ->update(['created_at' => date('Y-m-d H:i:s')]);
        return redirect()->to("/admin/blogs?type=" . $blog->type)->with("message", "创建成功");
    }

    public function destroy(Request $request, $id)
    {
        $blog = Blog::find($id);
        $type = $blog->type;
        if ($blog) {
            $blog->delete();
            return redirect()->to("/admin/blogs?type=" . $type);
        }
    }

    public function create(Request $request)
    {

        $type     = $request->get("type");
        $type_arr = Blog::type_arr()[$type];
        return view("admin.blogs.create", ["type" => $type, "type_arr" => $type_arr]);
    }

    public function store(Request $request)
    {
        $files = $request->file("pic_url");
        $data  = $request->except("pic_url");
        $blog  = Blog::create($data);
        $is_trend_cover=$request->get("is_trend_cover");
        if($is_trend_cover){
            $trend_cover = $request->file("trend_cover");
            if($trend_cover){
                $url = Picture::upload("trend_cover/" . $blog->id, $trend_cover);
                DB::table('blogs')
                    ->where('id', $blog->id)
                    ->update(['trend_cover' => $url]);
            }
        }
        // 上传本地文件
        foreach ($files as $key => $file) {
            if ($file) {
                $picture          = new Picture;
                $picture->url     = Picture::upload("pictures/" . $blog->id, $file);
                $picture->blog_id = $blog->id;
                $picture->save();
            }
        }

        return redirect()->to("/admin/blogs?type=" . $blog->type)->with("message", "创建成功");

    }

    public function clearCache(Blog $blog)
    {
    }
}
