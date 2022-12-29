<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterAction extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  App\Http\Requests\User\RegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterRequest $request)
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
}
