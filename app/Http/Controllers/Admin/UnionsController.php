<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UnionUser;
use Illuminate\Http\Request;
use DB;

class UnionsController extends Controller
{
    public function index($type){
        $allThisUnionUsers=DB::table('union_users')->where('type',$type)->get();
        return view("admin.union.index", compact('allThisUnionUsers','type'));
    }

    public function create($type){
        return view("admin.union.create", compact('type'));
    }


    public function store(Request $request,$type)
    {

        $data['name']              = $request->input("name");
        $data['phone']             = $request->input("phone");
        $data['type']              = $type;
        UnionUser::create($data);

        return redirect()->to("/admin/unions/{$type}");

    }


    public function destroy($type,$Id){
        $user=UnionUser::find($Id);

        if($user){
            $user->delete();
            return redirect()->to("/admin/unions/{$type}");
        }

    }
}
