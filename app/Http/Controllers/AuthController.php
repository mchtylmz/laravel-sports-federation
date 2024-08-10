<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Profile\PasswordRequest;
use App\Http\Requests\Profile\UpdateRequest;
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
            'status' => Status::active
        ];
        if (!Auth::attempt($credentials, true)) {
            return response()->json([
                'message' => __('auth.failed')
            ], 401);
        }

        user()->update(['last_login' => now()]);
        authLog('login');

        request()->session()->regenerate(true);

        return response()->json([
            'message' => __('auth.success'),
            'redirect' => '/'
        ]);
    }

    public function profile()
    {
        return view('auth.profile', [
            'title' => __('auth.profile.title')
        ]);
    }

    public function updateProfile(UpdateRequest $request)
    {
        auth()->user()->update($request->validated());

        return response()->json([
            'message' => __('auth.profile.success'),
            'refresh' => true
        ]);
    }

    public function changePassword(PasswordRequest $request)
    {
        $password = $request->validated('password');

        auth()->user()->update([
            'password' => Hash::make($password)
        ]);
        $request->session()->regenerate(true);

        return response()->json([
            'message' => __('auth.changePassword.success'),
            'refresh' => true
        ]);
    }

    public function logout()
    {
        authLog('logout');

        Auth::logout();
        request()->session()->regenerate(true);

        return redirect()->to('login');
    }
}
