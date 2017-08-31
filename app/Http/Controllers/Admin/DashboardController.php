<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        //echo Sms::send("18515665818","xx","66857");
        return view("admin.dashboard");
    }

}
