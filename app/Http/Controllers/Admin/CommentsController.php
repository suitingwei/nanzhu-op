<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    //

    public function index()
    {
        $comments = Comment::paginate(15);
        return view("admin.comments.index", ["comments" => $comments]);
    }

    public function edit($id)
    {
        $comment = Comment::where("FID", $id)->first();
        return view("admin.comments.edit", ["comment" => $comment]);
    }

    public function update(Request $request, $id)
    {
        $data                  = array();
        $data['FREPLYTIME']    = date('Y-m-d H:i:s');
        $data['FREPLYCONTENT'] = $request->get("FREPLYCONTENT");

        Comment::where("FID", $id)->update($data);

        return redirect()->to("/admin/comments")->with("message", "创建成功");
    }
}

