<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use App\Models\TradeScript;
use Illuminate\Http\Request;

class ScriptController extends Controller
{
    public function index(Request $request)
    {
        $title      = $request->input("title");
        $created_at = $request->input("created_at");
        if ($created_at) {
            $scripts = TradeScript::where("created_at", "like", "%" . $created_at . "%")->orderBy("created_at",
                "desc")->paginate(50);
            return view("admin.scripts.index", compact("scripts"));
        }
        if ($title) {
            $scripts = TradeScript::where("title", "like", "%" . $title . "%")->orderBy("created_at",
                "desc")->paginate(50);
            return view("admin.scripts.index", compact("scripts"));
        }
        $scripts = TradeScript::orderBy("created_at", "desc")->paginate(50);
        return view("admin.scripts.index", compact("scripts"));
    }

    public function create(Request $request)
    {
        $user_id = $request->session()->get("user_id");
        return view("admin.scripts.create", compact("user_id"));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data['title']         = $request->input("title");
        $data['author']        = $request->input("author");
        $data['content']       = $request->input("content");
        $data['plain_content'] = $request->input("plain_content");
        if ($request->input('contact_user_ids')) {
            $contack_user_id          = implode(',', $request->input('contact_user_ids'));
            $data['contact_user_ids'] = $contack_user_id;
        }
        $script = TradeScript::create($data);
        $files  = $request->file("pic_url");
        foreach ($files as $key => $file) {
            if ($file) {
                $picture            = new Picture;
                $picture->url       = Picture::upload("pictures/" . $script->id, $file);
                $picture->script_id = $script->id;
                $picture->save();
            }
        }
        return redirect()->to("/admin/scripts/")->with("message", "创建成功");
    }

    public function update($scriptId, Request $request)
    {
        $script = TradeScript::find($scriptId);

        if ($request->input('title')) {
            $script->update($request->only('title', 'content', 'author', 'plain_content'));
        }

        if ($request->hasFile('pictures')) {
            $script->pictures()->delete();
            foreach ($request->file('pictures') as $pictureFile) {
                if (!$pictureFile) {
                    continue;
                }
                $picture            = new Picture;
                $picture->url       = Picture::upload("pictures/" . $script->id, $pictureFile);
                $picture->script_id = $script->id;
                $picture->save();
            }
        }
        if ($script->allow_cooperation && ($receiveUserIds = $request->input('receive_user_ids'))) {
            $script->update(['receive_user_ids' => implode(',', $receiveUserIds)]);
        }

        return redirect()->to("/admin/scripts/");
    }

    public function edit($scriptId)
    {
        $script = TradeScript::find($scriptId);

        return view('admin.scripts.edit', compact('script'));
    }
    public function destroy(Request $request, $id)
    {
        $script = TradeScript::find($id);
        $type = $script->type;
        if ($script) {
            $script->delete();
            return redirect()->to("/admin/scripts?type=" . $type);
        }
    }
    public function editCooperationConfig($companyId, Request $request)
    {
        $company = TradeScript::find($companyId);

        $receiveUsers = $company->receiveUsers();

        return view('admin.scripts.edit_cooperation_config', compact('company', 'receiveUsers'));
    }

    /**
     * @param         $companyId
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleAllowCooperations($companyId, Request $request)
    {
        $company = TradeScript::find($companyId);

        $company->update(['allow_cooperation' => (int)$request->input('allow_cooperation')]);

        return redirect()->to('/admin/scripts/' . $companyId . '/edit-cooperation-config');
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
