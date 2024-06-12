<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

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
        if ($request->has('sort')) {
            $user = $user->orderBy($request->get('sort'), $request->get('order', 'ASC'));
        }
        if ($request->has('search')) {
            $user->whereAny(['name', 'email', 'username'], 'LIKE', '%' . $request->get('search'). '%');
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

        return view('users.detail', [
            'title' => !empty($user->id) ? __('users.edit_'.$userType) : __('users.add_'.$userType),
            'userType' => $userType,
            'user' => $user
        ]);
    }

}
