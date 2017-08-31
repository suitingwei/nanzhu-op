<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Picture;
use Illuminate\Http\Request;
use DB;

class BannersController extends Controller
{

    public function index(Request $request)
    {
        $banners = Banner::orderBy('is_show','asc')->orderBy("sort")->where(function ($query) {
            $query->whereNull('product_id')
                  ->orWhere('product_id', 0);
        })->get();

        return view("admin.banners.index", ["banners" => $banners]);
    }

    public function create()
    {

        return view("admin.banners.create");
    }

    public function store(Request $request)
    {
        $data = $request->except("cover");
        if ($request->file("cover")) {
            $data['cover'] = Picture::upload("banners", $request->file("cover"));
        }
        $banner = Banner::create($data);
        return redirect()->to("/admin/banners");
    }

    public function edit(Request $request, $id)
    {
        $banner = Banner::find($id);
        return view("admin.banners.edit", ["banner" => $banner]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except("cover");
        if ($request->file("cover")) {
            $data['cover'] = Picture::upload("banners", $request->file("cover"));
        }
        $banner = Banner::find($id);
        $banner->update($data);
        return redirect()->to("/admin/banners");
    }

    public function destroy(Request $request, $id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $banner->delete();
            return redirect()->to("/admin/banners");
        }
    }

    // show or not
    public function showBanner(Request $request,$id){
        DB::update('update banners set is_show = ? where id = ? ',[0,$id]);
        return redirect()->to("/admin/banners");
    }
    public function notshowBanner(Request $request,$id){
        DB::update('update banners set is_show = ? where id = ? ',[1,$id]);
        return redirect()->to("/admin/banners");
    }
}
