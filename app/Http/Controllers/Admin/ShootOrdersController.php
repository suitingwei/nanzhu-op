<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ShootOrder;

class ShootOrdersController extends Controller
{
    //
	public function index()
	{
		$shoot_orders = ShootOrder::orderBy("id","desc")->paginate(15);

		return view("admin.shoot_orders.index",["shoot_orders" => $shoot_orders]);
	}
}
