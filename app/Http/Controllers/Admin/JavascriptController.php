<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;

class JavascriptController extends Controller
{
    //
    public function getPurchaseRequestRootUrl()
    {
        $getPurchaseRequestRoorUrl = env('PURCHASE_REQUEST_ROOT_URL');
        return response()->json(['url'=>$getPurchaseRequestRoorUrl]);
    }
}

