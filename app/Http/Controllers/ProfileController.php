<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['show']);
    }

    /**
     * ユーザープロフィール
     *
     * @param User $user
     * @return ProfileResource
     */
    public function show(User $user): ProfileResource
    {
        return new ProfileResource($user);
    }

    /**
     * ユーザーフォロー
     *
     * @param User $user
     * @return ProfileResource
     */
    public function follow(User $user): ProfileResource
    {
        $authUser = Auth::user();
        if ($authUser->id !== $user->id) {
            $authUser->following()->attach($user);
        }
        return new ProfileResource($user);
    }

    /**
     * ユーザーフォロー解除
     *
     * @param User $user
     * @return ProfileResource
     */
    public function unFollow(User $user): ProfileResource
    {
        Auth::user()->following()->detach($user);
        return new ProfileResource($user);
    }
}
