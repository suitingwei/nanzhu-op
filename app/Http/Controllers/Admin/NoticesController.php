<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Notice;
use App\Models\NoticeExcel;
use App\Models\Picture;
use Illuminate\Http\Request;


class NoticesController extends Controller
{
    public function create(Request $request)
    {
        $movie_id = $request->get("movie_id");
        if ($movie_id) {
            $movie         = Movie::where("FID", $movie_id)->first();
            $notice_excels = Notice::where("FMOVIEID", $movie_id)->get();
            return view("admin.notices.create", ["movie" => $movie, "notice_excels" => $notice_excels]);
        }
    }

    public function store(Request $request)
    {
        $files                    = $request->file("url");
        $current                  = date('Y-m-d H:i:s', time());
        $notice                   = new Notice;
        $notice->FID              = Notice::max("FID") + 1;
        $notice->FNOTICEEXCELTYPE = $request->get("FNOTICEEXCELTYPE");
        $notice->FDATE            = $request->get("name");
        $notice->FNEWDATE         = $current;
        $notice->FEDITDATE        = $current;
        $notice->FNAME            = $request->get("name");
        $movie_id                 = $request->get("movie_id");
        $notice->FMOVIEID         = $movie_id;
        $notice->save();

        // 上传本地文件
        foreach ($files as $key => $file) {
            if ($file) {
                $notice_excel                 = new NoticeExcel;
                $notice_excel->FID            = NoticeExcel::max("fid") + 1;
                $notice_excel->FNOTICEEXCELID = $notice->FID;
                $notice_excel->FFILENAME      = $file->getClientOriginalName();
                $notice_excel->FFILEADD       = Picture::upload("notices/" . $notice->FID, $file);
                $notice_excel->FNEWDATE       = $current;
                $notice_excel->FEDITDATE      = $current;
                $notice_excel->FNUMBER        = $key + 1;
                $notice_excel->save();
            }
        }

        return redirect()->to("/admin/notices?movie_id=" . $movie_id)->with("message", "创建成功");

    }

    public function index(Request $request)
    {
        $movie_id = $request->get("movie_id");
        $movie    = Movie::where("FID", $movie_id)->first();
        $notices  = Notice::where("FMOVIEID", $movie_id)->where("is_delete", 0)->orderby("FID", "DESC")->get();
        return view("admin.notices.index", ["notices" => $notices, "movie" => $movie]);
    }

    public function edit(Request $request, $id)
    {
        $notice = Notice::where("FID", $id)->orderby("FID", "DESC")->first();
        return view("admin.notices.edit", ["notice" => $notice]);
    }

    public function update(Request $request, $id)
    {

        $notice = Notice::where("FID", $id)->orderby("FID", "DESC")->first();

        $movie_id = $notice->FMOVIEID;
        return redirect()->to("/admin/notices?movie_id=" . $movie_id)->with("message", "更新成功");
    }

    public function destroy(Request $request, $id)
    {

        $notice   = Notice::where("FID", $id)->orderby("FID", "DESC")->first();
        $movie_id = $notice->FMOVIEID;
        if ($notice) {
            $data['is_delete'] = 1;
            Notice::where("FID", $id)->update($data);
            return redirect()->to("/admin/notices?movie_id=" . $movie_id)->with("message", "删除成功");

        }

    }

}
