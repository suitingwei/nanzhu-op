<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductPricesController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.product_prices.index");
    }

    public function create(Request $request)
    {
        return view("admin.product_prices.create");
    }
    
    public function edit(Request $request)
    {
        return view("admin.product_prices.edit");
    }
    
    public function show(Request $request)
    {
        return view("admin.product_prices.show");
    }

}