<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recruit;
use Illuminate\Http\Request;

class RecruitsController extends Controller
{

    public function index(Request $request)
    {
        $type        = $request->get("type");
        $title       = $request->get("title");
        $is_approved = $request->get("is_approved");
        if ($is_approved) {
            $recruits = Recruit::where("is_approved", $is_approved)->paginate(30);
            return view("admin.recruits.index", ["recruits" => $recruits]);
        }
        if ($type) {
            $recruits = Recruit::where("type", $type)->paginate(30);
            return view("admin.recruits.index", ["recruits" => $recruits]);
        }
        if ($title) {
            $recruits = Recruit::where("title", "like", "%" . $title . "%")->paginate(30);
            return view("admin.recruits.index", ["recruits" => $recruits]);
        }
        $recruits = Recruit::where("is_approved", 0)->paginate(30);
        return view("admin.recruits.index", ["recruits" => $recruits]);
    }

    public function edit(Request $request, $id)
    {
        $recruit = Recruit::find($id);
        return view("admin.recruits.edit", ['recruit' => $recruit]);
    }

    public function update(Request $request, $id)
    {
        $recruit = Recruit::find($id);
        $data    = $request->all();
        $recruit->update($data);
        return redirect()->to("/admin/recruits");
    }

    public function destroy(Request $request, $id)
    {
        $recruit = Recruit::find($id);
        if ($recruit) {
            $recruit->delete();
            return redirect()->to("/admin/recruits");
        }
    }

    public function create()
    {
        return view("admin.recruits.create");
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $blog = Recruit::create($data);
        return redirect()->to("/admin/recruits")->with("message", "创建成功");
    }
}
