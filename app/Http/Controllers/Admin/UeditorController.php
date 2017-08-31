<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UeditorController extends Controller
{

    public function getConfig(Request $request)
    {
        if (!$request->has('action')) {
            return response()->json(['status' => 'success']);
        }
        $uploadImagesConfig = [
            'status'          => 'success',
            "imageUrl"        => "http://nanzhu-op.dev/ueditor/php/controller.php?action=uploadimage",
            "imagePath"       => "/ueditor/php/",
            "imageFieldName"  => "upfile",
            "imageMaxSize"    => 2048,
            "imageAllowFiles" => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
        ];
        return response()->json($uploadImagesConfig);
    }
}
