<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function Symfony\Component\Translation\t;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login', [
            'title' => __('auth.login.title')
        ]);
    }

    public function auth(LoginRequest $request)
    {
        $credentials = [
            'username' => $request->validated('username'),
            'password' => $request->validated('password'),
        ];
        if (!Auth::attempt($credentials, true)) {
            return response()->json([
                'message' => __('auth.failed')
            ], 401);
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => __('auth.success'),
            'redirect' => '/'
        ]);
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->regenerate();

        return redirect()->to('login');
    }
}
