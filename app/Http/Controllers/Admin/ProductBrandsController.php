<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductBrandsController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.product_brands.index");
    }

    public function create(Request $request)
    {
        return view("admin.product_brands.create");
    }
    
    public function edit(Request $request)
    {
        return view("admin.product_brands.edit");
    }
    
    public function show(Request $request)
    {
        return view("admin.product_brands.show");
    }

}