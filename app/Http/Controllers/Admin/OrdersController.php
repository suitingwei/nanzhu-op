<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {

        return view("admin.orders.index");
    }

    public function show(Request $request)
    {
        return view("admin.orders.show");
    }

    public function edit(Request $request)
    {
        return view("admin.orders.edit");
    }

}