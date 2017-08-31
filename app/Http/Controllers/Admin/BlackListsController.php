<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlackList;
use App\User;
use Illuminate\Http\Request;


class BlackListsController extends Controller
{
    public function index(Request $request)
    {
        $blackLists = BlackList::orderBy('created_at', 'desc');

        if ($request->has('phone')) {
            $blackLists = $blackLists->where('phone', 'like', "%{$request->input('phone')}%");
        }

        $blackLists = $blackLists->paginate(15);

        return view('admin.black_lists.index', compact('blackLists'));
    }


    public function create()
    {
        return view('admin.black_lists.create');
    }

    public function store(Request $request)
    {
        $user = User::where('FPHONE', $request->input('phone'))->first();
        BlackList::create([
            'phone'   => $request->input('phone'),
            'user_id' => $user ? $user->FID : null,
            'note'    => $request->input('note')
        ]);

        return redirect()->to('admin/black-lists');
    }

    public function destroy($id)
    {
        BlackList::destroy($id);

        return redirect()->to('/admin/black-lists');
    }

}
