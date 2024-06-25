<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Http\Requests\User\SaveRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index($userType)
    {
        if (!in_array($userType, UserType::names())) {
            abort(404);
        }

        return view('users.index', [
            'title' => __('users.' . $userType),
            'userType' => $userType
        ]);
    }

    public function json(Request $request, $userType)
    {
        $user = User::where('role', $userType)->latest();

        if ($sort = $request->get('sort')) {
            $user = $user->orderBy($sort, $request->get('order', 'ASC'));
        }
        if ($search = $request->get('search')) {
            $user->whereAny(['name', 'email', 'username'], 'LIKE', '%' . $search . '%');
        }
        if ($location = $request->get('location')) {
            $user->whereMeta('places', 'LIKE', '%' . $location . '%');
        }
        if ($federation_id = $request->get('federation_id')) {
            $user->whereMeta('federation_id', $federation_id);
        }
        if ($lastLogin = $request->get('last_login')) {
            $lastLogin = explode(' - ', $lastLogin);
            $user->whereBetween('last_login', $lastLogin);
        }

        return response()->json([
            'total' => $user->count(),
            'totalNotFiltered' => $user->count(),
            'rows' => UserResource::collection($user->page()),
        ]);
    }

    public function detail($userType, User $user)
    {
        if (!in_array($userType, UserType::names())) {
            abort(404);
        }

        if (request()->input('format') == 'json') {
            return response()->json([
                'title' => $user->name,
                'user' => $user,
                'body' => view('users.offcanvas', [
                    'userType' => $userType,
                    'user' => $user
                ])->render()
            ]);
        }

        return view('users.detail', [
            'title' => !empty($user->id) ? __('users.edit_'.$userType) : __('users.add_'.$userType),
            'userType' => $userType,
            'user' => $user
        ]);
    }

    public function save(SaveRequest $request, string $userType, User $user)
    {
        // section-1
        if (!in_array($userType, UserType::names())) {
            abort(403, 'Kullanıcı yönetim rolü bilgisi hatalı!');
        }

        // section-2
        $unique = Validator::make($request->validated(), [
            'username' => [
                Rule::unique('users')->ignore($user->id)
            ],
        ]);
        if ($errorMessage = $unique->errors()->first()) {
            abort(403, str_replace('username', trans('users.form.username'), $errorMessage));
        }

        // section-3
        $data = [
            ...$request->validated(),
            'role' => $user?->role ?? $userType,
        ];

        unset($data['identity_number'], $data['places']);
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // section-4
        if (!$user?->id) {
            $user = User::create($data);
        } else {
            $user->update($data);
        }

        // section-5
        // metas
        $metas = [
            'event_color' => $request->validated('event_color')
        ];

        if ($user->role == 'manager') {
            $metas = [
                ...$metas,
                'identity_number' => $request->validated('identity_number'),
                'places' => collect($request->validated('places'))->pluck('place')->toArray()
            ];

            cache()->delete('places_all');
        }
        elseif ($user->role == 'admin') {
            $metas = [
                ...$metas,
                'federation_id' => $request->validated('federation_id')
            ];
        }

        $user->setMeta($metas);
        // metas

        // section-6
        return response()->json([
            'message' => __('users.save_success', ['name' => $user->name]),
            'redirect' => route('user.index', $user->role)
        ]);
    }
}
