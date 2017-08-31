<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bulletin;
use Illuminate\Http\Request;

class BulletinsController extends Controller
{
    public function index(Request $request)
    {
        $bulletins = Bulletin::paginate(15);
        return view("admin.bulletins.index", ["bulletins" => $bulletins]);
    }

    public function edit($id)
    {
        $bulletin = Bulletin::where("FID", $id)->first();
        return view("admin.bulletins.edit", ["bulletin" => $bulletin]);
    }

    public function update(Request $request, $id)
    {
        $data = array();
        //$data['FREPLYTIME'] = date('Y-m-d H:i:s');

        Bulletin::where("FID", $id)->update($data);

        return redirect()->to("/admin/bulletins")->with("message", "创建成功");
    }
}
