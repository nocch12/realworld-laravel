<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\UserResource;

class LoginAction extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\User\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request)
    {
        if (! $token = auth()->attempt($request->userRequest())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return (new UserResource(auth()->user()))
            ->withToken($token);
    }
}
