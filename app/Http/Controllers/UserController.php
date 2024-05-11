<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = null;

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
        } else {
            return response()->json(['message' => 'invalid credentials'], 401);
        }

        $user['api_token'] = $user->createToken('master')->accessToken;

        return response()->json($user);
    }

    public function register(CreateUserRequest $request) {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->type = 'user';

        $user->save();

        $user['api_token'] = $user->createToken('master')->accessToken;

        return response()->json($user);
    }

    public function me()
    {
        $user = Auth::user();

        return response()->json($user);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'logged out'], 200);
    }

}
