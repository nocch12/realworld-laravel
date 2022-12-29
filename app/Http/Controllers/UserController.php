<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ログイン.
     *
     * @param  \App\Http\Requests\User\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        if (! $token = auth()->attempt($request->userRequest())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return (new UserResource(auth()->user()))
            ->withToken($token);
    }
    
    /**
     * ユーザ登録.
     *
     * @param  App\Http\Requests\User\RegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = $request->userRequest();
        $u = User::create([
            'username' => $user['username'],
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
        ]);

        if (! $token = auth()->attempt($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return (new UserResource(auth()->user()))
            ->withToken($token);
    }
    
    /**
     * ログイン中のユーザ情報
     *
     * @param  App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function me(Request $request)
    {
        return (new UserResource(auth()->user()))
            ->withToken($request->bearerToken());
    }
}
