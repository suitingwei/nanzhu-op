<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Picture;
use App\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $title      = $request->input("title");
        $created_at = $request->input("created_at");
        if ($created_at) {
            $companies = Company::where("created_at", "like", "%" . $created_at . "%")->orderBy("created_at",
                "desc")->paginate(20);
            return view("admin.companies.index", compact("companies"));
        }
        if ($title) {
            $companies = Company::where("title", "like", "%" . $title . "%")->orderBy("created_at",
                "desc")->paginate(20);
            return view("admin.companies.index", compact("companies"));
        }

        $companies = Company::orderBy("created_at", "desc")->paginate(20);
        return view("admin.companies.index", compact("companies"));
    }

    public function create(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        return view("admin.companies.create", compact('user_id'));
    }

    public function store(Request $request)
    {
        $logo                       = $request->file("logo");
        $data['logo']               = Picture::upload("logos/" . time(), $logo);
        $data['title']              = $request->input("title");
        $data['introduction']       = $request->input("introduction");
        $data['plain_introduction'] = $request->input('plain_introduction');

        if ($request->input('contact_user_ids')) {
            $contact_user_ids         = implode(',', $request->input('contact_user_ids'));
            $data['contact_user_ids'] = $contact_user_ids;
        }
        $company = Company::create($data);
        $files   = $request->file("pic_url");


        foreach ($files as $key => $file) {
            if ($file) {
                $picture             = new Picture;
                $picture->url        = Picture::upload("pictures/" . $company->id, $file);
                $picture->company_id = $company->id;
                $picture->save();
            }
        }

        return redirect()->to("/admin/companies/")->with("message", "创建成功");

    }

    /**
     * @param Request $request
     *
     * 创建时联系人选项的自动补全功能
     *
     * @return mixed
     */

    public function destroy(Request $request, $id)
    {
        $company = Company::find($id);
        if ($company) {
            $company->delete();
            return redirect()->to("/admin/companies");
        }
    }

    public function edit($companyId, Request $request)
    {
        $company = Company::find($companyId);
        $picurls = Picture::where('company_id', $companyId)->get();

        return view('admin.companies.edit', compact('company', 'picurls'));
    }

    public function update($companyId, Request $request)
    {
        $company = Company::find($companyId);

        if (!$company) {
            return redirect()->to("/admin/companies");
        }
        if($request->input('title')) {
            $company->update($request->only('title', 'introduction', 'plain_introduction'));
        }
        if ($request->hasFile('logo')) {
            $company->update(['logo' => Picture::upload("logos/" . time(), $request->file('logo'))]);
        }

        if ($request->hasFile('pictures')) {
            $company->pictures()->delete();
            foreach ($request->file('pictures') as $pictureFile) {
                if (!$pictureFile) {
                    continue;
                }
                $picture             = new Picture;
                $picture->url        = Picture::upload("pictures/" . $company->id, $pictureFile);
                $picture->company_id = $company->id;
                $picture->save();
            }
        }

        if ($company->allow_cooperation && ($receiveUserIds = $request->input('receive_user_ids'))) {
            $company->update(['receive_user_ids' => implode(',', $receiveUserIds)]);

        }

        return redirect()->to("/admin/companies");
    }

    /**
     * @param         $companyId
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCooperationConfig($companyId, Request $request)
    {
        $company = Company::find($companyId);

        $receiveUsers = $company->receiveUsers();

        return view('admin.companies.edit_cooperation_config', compact('company', 'receiveUsers'));
    }

    /**
     * @param         $companyId
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleAllowCooperations($companyId, Request $request)
    {
        $company = Company::find($companyId);
        $company->update(['allow_cooperation' => (int)$request->input('allow_cooperation')]);

        return redirect()->to('/admin/companies/' . $companyId . '/edit-cooperation-config');
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
