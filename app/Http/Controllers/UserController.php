<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\UpdateRequest;
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
        $params = $request->userRequest();
        $user = User::create([
            'username' => $params['username'],
            'email' => $params['email'],
            'password' => Hash::make($params['password']),
        ]);

        $token = auth()->attempt($params);

        return (new UserResource($user))
            ->withToken($token);
    }
    
    /**
     * ログイン中のユーザ情報取得
     *
     * @param  App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function me(Request $request)
    {
        return (new UserResource(auth()->user()))
            ->withToken($request->bearerToken());
    }
    
    /**
     * ログイン中のユーザ情報更新
     *
     * @param  App\Http\Requests\User\UpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request)
    {
        $user = auth()->user();

        $params = $request->userRequest();
        
        if (!empty($params['password'])) {
            $params['password'] = Hash::make($params['password']);
        }

        $user->fill($params);
        $user->save();
        
        return (new UserResource($user))
            ->withToken($request->bearerToken());
    }
}
