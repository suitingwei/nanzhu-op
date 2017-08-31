<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MovieBasement;
use App\Models\Picture;
use Illuminate\Http\Request;


class BasementsController extends Controller
{

    public function index(Request $request,$type)
    {

        $title      = $request->get("title");
        $created_at = $request->get("created_at");
        if ($created_at) {
            $basements = MovieBasement::where("created_at", "like", "%" . $created_at . "%")->where('type',$type)->orderBy("sort",
                "desc")->paginate(20);
            return view("admin.movie_basements.index", compact("basements"));
        }
        if ($title) {
            $basements = MovieBasement::where("title", "like", "%" . $title . "%")->where('type',$type)->orderBy("sort",
                "desc")->paginate(20);
            return view("admin.movie_basements.index", compact("basements"));
        }

        $basements = MovieBasement::where('type',$type)->orderBy("sort", "desc")->paginate(20);
        return view("admin.movie_basements.index", compact("basements",'type'));
    }

    public function create(Request $request,$type)
    {

        $user_id = $request->session()->get('user_id');
        return view("admin.movie_basements.create", compact('user_id','type'));
    }

    public function store(Request $request,$type)
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

        $files   = $request->input("pic_url");
        if($files ) {
            foreach ($files as $key => $file) {
                if ($file) {
                    $picture              = new Picture;
                    $picture->url         = $file;
                    $picture->basement_id = $basement->id;
                    $picture->save();
                }
            }
        }
        return redirect()->to("/admin/basements/{$type}")->with("message", "创建成功");

    }

    public function edit($type,$basementId)
    {

        $basement = MovieBasement::find($basementId);

        $picurls   = Picture::where('basement_id',$basementId)->get();
        return view('admin.movie_basements.edit', compact('basement','picurls','type'));
    }
    public function update($type,$basementId, Request $request)
    {

        $basement = MovieBasement::find($basementId);
        if ($basement) {
            if($request->input('title')){
                $basement->update($request->only('title', 'content', 'introduction','sort'));
            }
            if ($request->hasFile('cover')) {
                $basement->update(['cover' => Picture::upload("covers/" . time(), $request->file('cover'))]);
            }
            $haspics=$request->input('pictures');

            if ($haspics) {
                $basement->pictures()->delete();

                foreach ($haspics as $key => $haspic) {
                    if($haspic){
                        $picture             = new Picture;
                        $picture->url        = $haspic;
                        $picture->basement_id = $basement->id;
                        $picture->save();
                    }

                }
            }
            if ($basement->allow_cooperation==1 && ($receiveUserIds = $request->input('receive_user_ids'))) {
                $basement->update(['receive_user_ids' => implode(',', $receiveUserIds)]);
                return redirect()->to('/admin/basements/'.$basement->type);
            }

        }

        return redirect()->to("/admin/basements/{$type}");
    }
    public function upload(Request $request)
    {
        set_time_limit(0);
        $uploadFile = $request->file('file');

        $url         = Picture::upload('basements' . time(), $uploadFile);
        $fileType    = $uploadFile->getClientOriginalExtension();
        $fileName    = $uploadFile->getClientOriginalName();


        return response()->json([
            'success' => true,
            'msg'     => '',
            'data'    => [
                'uploaded_file_url' => $url,
                'file_type'         => $fileType,
                'file_name'         => $fileName
            ]
        ]);
    }
    public function destroy($type,$basementId){
        $basement=MovieBasement::find($basementId);

        if($basement){
            $basement->delete();
            return redirect()->to("/admin/basements/{$type}");

        }

    }

    public function editCooperationConfig($companyId, Request $request)
    {
        $company = MovieBasement::find($companyId);

        $receiveUsers = $company->receiveUsers();

        return view('admin.movie_basements.edit_cooperation_config', compact('company', 'receiveUsers'));
    }

    /**
     * @param         $companyId
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleAllowCooperations($companyId, Request $request)
    {
        $company = MovieBasement::find($companyId);

        $company->update(['allow_cooperation' => (int)$request->input('allow_cooperation')]);

        return redirect()->to('/admin/basement/' . $companyId . '/edit-cooperation-config');
    }

    public function autoload(Request $request)
    {
        $username = User::where('FNAME', 'like', '%' . $request->get('query') . '%')->orderBy('FID',
            'desc')->limit(10)->get()->all();

        $data['query'] = $request->get('query');
        foreach ($username as $key => $value) {
            $data['suggestions'][$key]['value'] = $value->FNAME;
            $data['suggestions'][$key]['data']  = $value->FID;
        }
        return $data;
    }
}
