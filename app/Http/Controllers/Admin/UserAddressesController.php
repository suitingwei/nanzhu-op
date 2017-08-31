<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;

class UserAddressesController extends Controller
{
    public function index()
    {
        $user_addresses = UserAddress::all();
        return view("admin.user_addresses.index", ["user_addresses" => $user_addresses]);
    }
}
