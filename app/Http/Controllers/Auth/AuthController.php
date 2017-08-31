<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Log;

class AuthController extends Controller
{

    public function showLoginForm(Request $request)
    {
        return view("auth.login", ['request' => $request]);
    }

    public function login(Request $request)
    {
        $phone = $request->get("phone");
        $code = $request->get("code");
        $token = $request->get("aliyuntoken");
        Log::info($phone);
        if (!$phone) {
            Session::put('message', '请输入手机号');
            return redirect()->to("/login");
        }
        if (!$code) {
            Session::put('message', '请输入验证码');
            return redirect()->to("/login");
        }
       //没有取到用户信息的话就登陆
        $data = User::login_or_register($phone, $code, $token);
        if ($data['ret'] != 0) {
            Session::put('message', '验证码或者手机号错误');
            return redirect()->to("/login");
        }
        //login success
        $user = $data['user'];
        $request->session()->put('user_id', $user->FID);
        $request->session()->put('user', $user);
        if (User::where("FID", $data["user"]->FID)->first()->has_role(1)) {
            return redirect()->to("/admin")->with("message", $data['msg']);
        }
        return redirect()->to("/login");
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user_id');
        $request->session()->forget('user');
        return redirect()->to("/login")->with("message", "成功登出");
    }
}
