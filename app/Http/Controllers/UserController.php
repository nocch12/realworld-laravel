<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Usecases\User\UpdateAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
            throw ValidationException::withMessages([
                trans('auth.faild'),
            ]);
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
    public function update(UpdateRequest $request, UpdateAction $action)
    {
        $user = auth()->user();

        $params = $request->userRequest();

        $user = $action($user, $params);
        
        return (new UserResource($user))
            ->withToken($request->bearerToken());
    }
}
