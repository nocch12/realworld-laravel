<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\UseCases\User\LoginAction;
use App\UseCases\User\RegisterAction;
use App\UseCases\User\UpdateAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
    }

    /**
     * ログイン.
     *
     * @param  \App\Http\Requests\User\LoginRequest  $request
     * @param  \App\Usecases\User\LoginAction  $action
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request, LoginAction $action)
    {
        $action($request->email(), $request->password());

        return (new UserResource(Auth::user()))
            ->withToken(Auth::getToken());
    }

    /**
     * ユーザ登録.
     *
     * @param  App\Http\Requests\User\RegisterRequest  $request
     * @param  \App\Usecases\User\RegisterAction  $action
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request, RegisterAction $action)
    {
        $user = $action($request->makeUser());

        return (new UserResource(Auth::user()))
            ->withToken(Auth::getToken());
    }

    /**
     * ログイン中のユーザ情報取得
     *
     * @param  App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function me(Request $request)
    {
        return (new UserResource(Auth::user()))
            ->withToken(Auth::getToken());
    }

    /**
     * ログイン中のユーザ情報更新
     *
     * @param  App\Http\Requests\User\UpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, UpdateAction $action)
    {
        $action(Auth::user(), $request->userRequest());

        return (new UserResource(Auth::user()))
            ->withToken(Auth::getToken());
    }
}
