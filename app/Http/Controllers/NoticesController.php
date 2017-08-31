<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\NoticeExcel;
use App\Models\Picture;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\MessageReceiver;
use Log;
class NoticesController extends Controller
{
    public function create(Request $request)
    {
        $movie_id = $request->get("movie_id");
        return view("website.notices.create", ["movie_id" => $movie_id]);
    }

    public function edit(Request $request, $id)
    {
        $notice = Notice::where("FID", $id)->first();

        $movie_id = $request->get("movie_id");
        return view("website.notices.edit", ["notice" => $notice, "movie_id" => $movie_id]);
    }

    public function store(Request $request)
    {
        $files    = $request->file("url");
        $current  = date('Y-m-d H:i:s', time());
        $name     = $request->get("name");
        $movie_id = $request->get("movie_id");
        if (!$name) {
            Session::put('message', '通告单日期不能为空');
            return redirect()->to("/notices/create?movie_id=" . $movie_id);
        }
        $notice   = Notice::where("FMOVIEID", $movie_id)->where("FDATE", $name)->where("FNOTICEEXCELTYPE",
                                                                                       $request->get("FNOTICEEXCELTYPE"))->first();
        if ($notice) {
            Session::put('message', '通告单已经存在');
            return redirect()->to("/notices/create?movie_id=" . $movie_id);
        }
        $notice                   = new Notice;
        $notice->FID              = Notice::max("FID") + 1;
        $notice->FNOTICEEXCELTYPE = $request->get("FNOTICEEXCELTYPE");
        $notice->FDATE            = $name;
        $notice->FNEWDATE         = $current;
        $notice->FEDITDATE        = $current;
        $notice->FNAME            = $name;
        $notice->FMOVIEID         = $request->get("movie_id");
        $notice->save();



        // 上传本地文件
        foreach ($files as $key => $file) {

            if ($file) {
                if($file    ->getClientOriginalExtension()=="jpg"
                    ||$file->getClientOriginalExtension()=="png"
                    ||$file->getClientOriginalExtension()=="pdf"
                    ||$file->getClientOriginalExtension()=="xls"
                    ||$file->getClientOriginalExtension()=="xlsx"){
                    if(substr_count($file->getClientOriginalName(),'.')==1){
                        $notice_excel                 = new NoticeExcel;
                        $notice_excel->FID            = NoticeExcel::max("fid") + 1;
                        $notice_excel->FNOTICEEXCELID = $notice->FID;
                        $notice_excel->FFILENAME      = $file->getClientOriginalName();
                        $notice_excel->FFILEADD       = Picture::upload("notices/" . $notice->FID, $file);
                        $notice_excel->FNEWDATE       = $current;
                        $notice_excel->FEDITDATE      = $current;
                        $notice_excel->FNUMBER        = $key + 1;
                        $notice_excel->save();
                    }else{
                        Session::put('message', '文件名中需要有且只有一个"."');
                        return redirect()->to("notices/".$notice->FID."/edit");
                    }
                }else{
                    Session::put('message', '请选择文件格式为： xls，xlsx，pdf，png，jpg 的文件上传');
                    return redirect()->to("notices/".$notice->FID."/edit");
                }
            }
        }

        return redirect()->to("/home?movie_id=" . $notice->FMOVIEID)->with("message", "创建成功");

    }

    public function show(Request $request, $id)
    {
        $notice   = Notice::where("FID", $id)->first();
        $movie_id = $notice->FMOVIEID;
        return view("website.notices.show", ["notice" => $notice, "movie_id" => $movie_id]);
    }

    public function update(Request $request, $id)
    {

        $current = date('Y-m-d H:i:s', time());

        $notice = Notice::where("FID", $id)->orderby("FID", "DESC")->first();

        $files = $request->file("new_url");

        $excel_ids = $request->get("excel_ids");

        $excels = $notice->excels();

        foreach ($files as $key => $file) {
            if ($file) {
                if($file->getClientOriginalExtension()=="jpg"
                    ||$file->getClientOriginalExtension()=="png"
                    ||$file->getClientOriginalExtension()=="pdf"
                    ||$file->getClientOriginalExtension()=="xls"
                    ||$file->getClientOriginalExtension()=="xlsx"){
                    if(substr_count($file->getClientOriginalName(),'.')==1) {
                        if (isset($excels[$key + 1])) {
                            $url = Picture::upload("notices/" . $notice->FID, $file);
                            DB::update("update t_biz_noticeexcelsinfo set FFILEADD = '" . $url . "',FFILENAME='" . $file->getClientOriginalName() . "' where FNOTICEEXCELID = ? and FNUMBER = ?",
                                [$notice->FID, $key + 1]);
                            $noticeexcelsid = DB::table('t_biz_noticeexcelsinfo')->select('FID')->where('FNOTICEEXCELID',
                                $notice->FID)->where('FNUMBER', $key + 1)->get();

                            DB::update("update messages set is_undo=1 where notice_file_id =?",
                                [$noticeexcelsid[0]->FID]);

                            $messagesid = DB::table('messages')->select('id')->where('notice_file_id',
                                $noticeexcelsid[0]->FID)->get();

                            foreach ($messagesid as $message) {
                                MessageReceiver::where("message_id", $message->id)->delete();
                            }
                            continue;
                        }
                    }else{
                        Session::put('message', '文件名中需要有且只有一个"."');
                        return redirect()->to("notices/".$notice->FID."/edit");
                    }
                    $notice_excel                 = new NoticeExcel;
                    $notice_excel->FID            = NoticeExcel::max("fid") + 1;
                    $notice_excel->FNOTICEEXCELID = $notice->FID;
                    $notice_excel->FFILENAME      = $file->getClientOriginalName();
                    $notice_excel->FFILEADD       = Picture::upload("notices/" . $notice->FID, $file);
                    $notice_excel->FNEWDATE       = $current;
                    $notice_excel->FEDITDATE      = $current;
                    $notice_excel->FNUMBER        = $key + 1;
                    $notice_excel->save();
                }else{
                    Session::put('message', '请选择文件格式为： xls，xlsx，pdf，png，jpg 的文件上传');
                    return redirect()->to("notices/".$notice->FID."/edit");
                }
            }
        }
        DB::update("update t_biz_noticeexcel set FEDITDATE = '" . $current . "' where FID = ? ",
            [$notice->FID]);

        return redirect()->to("/home?movie_id=" . $notice->FMOVIEID)->with("message", "更新成功");
    }
}
