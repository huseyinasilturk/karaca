<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

class AuthenticationController extends Controller
{
    public function loginUser(Request $request)
    {
        $validator = Validator::make(
            $request->only("user_name", "password"),
            [
                'user_name' => 'required|string|min:3',
                'password' => 'required|string|min:6',
            ],
            [
                "user_name.required" => "Kullanıcı adı girmek zorundasınız",
                "user_name.string" => "Kullanıcı adı yazı olmak zorunda",
                "user_name.min" => "Kullanıcı adı 3 karakterden fazla olmalı",
                "password.required" => "Şifre girmek zorundasınız",
                "password.string" => "Şifre yazı olmak zorunda",
                "password.min" => "Şifre 6 karakterden fazla olmalı"
            ]
        );

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        if (!auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Kullanıcı adı veya şifre hatalı'], 401);
        }

        return response()->json(['message' => 'Giriş Başarılı', "status" => 200]);
    }

    public function login(Request $request)
    {
        $pageConfigs = ['blankPage' => true];
        return view('/live/authentication/login', ['pageConfigs' => $pageConfigs]);
    }

    public function logout()
    {
        Session::flush();

        auth()->logout();

        return redirect('auth/login');
    }

    // ** TEMA FONKSİYONLARI

    // Login basic
    public function login_basic()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-login-basic', ['pageConfigs' => $pageConfigs]);
    }

    // Login Cover
    public function login_cover()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-login-cover', ['pageConfigs' => $pageConfigs]);
    }

    // Register basic
    public function register_basic()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-register-basic', ['pageConfigs' => $pageConfigs]);
    }

    // Register cover
    public function register_cover()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-register-cover', ['pageConfigs' => $pageConfigs]);
    }

    // Forgot Password basic
    public function forgot_password_basic()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-forgot-password-basic', ['pageConfigs' => $pageConfigs]);
    }

    // Forgot Password cover
    public function forgot_password_cover()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-forgot-password-cover', ['pageConfigs' => $pageConfigs]);
    }

    // Reset Password basic
    public function reset_password_basic()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-reset-password-basic', ['pageConfigs' => $pageConfigs]);
    }

    // Reset Password cover
    public function reset_password_cover()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-reset-password-cover', ['pageConfigs' => $pageConfigs]);
    }

    // email verify basic
    public function verify_email_basic()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-verify-email-basic', ['pageConfigs' => $pageConfigs]);
    }

    // email verify cover
    public function verify_email_cover()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-verify-email-cover', ['pageConfigs' => $pageConfigs]);
    }

    // two steps basic
    public function two_steps_basic()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-two-steps-basic', ['pageConfigs' => $pageConfigs]);
    }

    // two steps cover
    public function two_steps_cover()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-two-steps-cover', ['pageConfigs' => $pageConfigs]);
    }

    // register multi steps
    public function register_multi_steps()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-register-multisteps', ['pageConfigs' => $pageConfigs]);
    }
}
