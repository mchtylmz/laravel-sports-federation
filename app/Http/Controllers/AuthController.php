<?php

namespace App\Http\Controllers;

use App\Actions\UploadFile;
use App\Enums\PeopleType;
use App\Enums\Status;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\People\SaveRequest;
use App\Http\Requests\Profile\PasswordRequest;
use App\Http\Requests\Profile\UpdateRequest;
use App\Models\People;
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

        authLog('login');
        user()->update(['last_login' => now()]);

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

    public function register()
    {
        return view('auth.register', [
            'title' => __('auth.register.title')
        ]);
    }


    public function registerSave(SaveRequest $request)
    {
        $validated = $request->validated();
        if (!$request->integer('term')) {
            return response()->json([
                'message' => 'Onay alanını lütfen işaretleyiniz!',
            ], 400);
        }

        if ($people = People::where('license_no', $request->get('license_no'))->first()) {
            return response()->json([
                'message' => __('auth.register.error_license_no', ['license_no' => $people->license_no]),
            ], 400);
        }

        // unset($validated['photo']);
        if ($request->hasFile('photo')) {
            $validated['photo'] = UploadFile::image($request->file('photo'));
        }
        $validated['status'] = Status::pending;

        $people = People::create($validated);

        if ($people->type == PeopleType::player) {
            $metas = [
                'player_club_id' => $request->integer('player_club_id')
            ];
        } elseif ($people->type == PeopleType::referee) {
            $metas = [
                'referee_class' => $request->get('referee_class'),
                'referee_region' => $request->get('referee_region'),
            ];
        } elseif ($people->type == PeopleType::coach) {
            $metas = [
                'coach_class' => $request->get('coach_class'),
                'coach_job' => $request->get('coach_job'),
            ];
        } elseif ($people->type == PeopleType::racer) {
            $metas = [
                'racer_section' => $request->get('racer_section')
            ];
        } elseif ($people->type == PeopleType::school) {
            $metas = [
                'school_club_id' => $request->integer('school_club_id'),
                'school_name' => $request->get('racer_section')
            ];
            if ($request->hasFile('school_document')) {
                $metas['school_document'] = UploadFile::file($request->file('school_document'));
            }
        }

        $people->setMeta($metas ?? []);
        customLog('people_meta', $metas ?? [], $people->id);

        session()->flash('success', __('auth.register.success', ['fullname' => $people->fullname]));

        return response()->json([
            'message' => __('auth.register.success', ['fullname' => $people->fullname]),
            'redirect' => route('register')
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
