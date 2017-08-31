<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class SocialSecuritiesController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.social_securities.index');
    }
}
