<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.products.index");
    }

    public function create(Request $request)
    {
        return view("admin.products.create");
    }
    
    public function edit(Request $request)
    {
        return view("admin.products.edit");
    }
    
    public function show(Request $request)
    {
        return view("admin.products.show");
    }

    public function prices($productId)
    {
        return view('admin.products.prices');
    }
    public function brands($brandId)
    {
        return view('admin.products.brands');
    }


}