<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{

    public function index()
    {
        return view("admin.permissions.index");
    }
}
