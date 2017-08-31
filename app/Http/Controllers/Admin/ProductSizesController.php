<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductSizesController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.product_sizes.index");
    }

    public function create(Request $request)
    {
        return view("admin.product_sizes.create");
    }
    
    public function edit(Request $request)
    {
        return view("admin.product_sizes.edit");
    }
    
    public function show(Request $request)
    {
        return view("admin.product_sizes.show");
    }

}