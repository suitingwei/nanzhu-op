<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Picture;
use Illuminate\Http\Request;

class AdvertisementsController extends Controller
{
    public function create(Request $request)
    {
        return view("admin.advertisements.create");
    }

    public function edit(Request $request, $id)
    {
        $advertisement = Advertisement::where("FID", $id)->first();
        return view("admin.advertisements.edit", ["advertisement" => $advertisement]);
    }

    public function update(Request $request, $id)
    {
        $advertisement = Advertisement::where("FID", $id)->first();
        if ($advertisement) {
            $data = $request->except("_token", "_method");
            $file = $request->file("FPICURL");
            if ($file) {
                $data["FPICURL"] = Picture::upload("advertisements", $file);
            }
            Advertisement::where("FID", $id)->update($data);
        }
        return redirect()->to("/admin/advertisements")->with("message", "更新成功");
    }

    public function store(Request $request)
    {
        $data            = $request->all();
        $file            = $request->file("FPICURL");
        $data['FID']     = Advertisement::max("FID") + 1;
        $data["FPICURL"] = Picture::upload("advertisements", $file);
        Advertisement::create($data);

        return redirect()->to("/admin/advertisements");
    }

    public function index(Request $request)
    {
        $advertisements = Advertisement::paginate(15);
        return view("admin.advertisements.index", ["advertisements" => $advertisements]);
    }

    public function destroy(Request $request, $id)
    {
        $advertisement = Advertisement::where("FID", $id)->first();
        if ($advertisement) {
            Advertisement::where("FID", $id)->delete();
        }

        return redirect()->to("/admin/advertisements");
    }
}
