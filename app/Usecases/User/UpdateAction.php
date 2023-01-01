<?php

namespace App\Usecases\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateAction {
    public function __invoke(User $user, array $params): User
    {   
        if (!empty($params['password'])) {
            $params['password'] = Hash::make($params['password']);
        }

        $user->fill($params);
        $user->save();
        return $user;
    }
}