<?php declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final class RegisterAction
{
    /**
     * ユーザ登録
     *
     * @param User $user
     * @return User
     */
    public function __invoke(User $user): User
    {
        $user->save();

        if ($user->save()) {
            Auth::login($user);
            return $user;
        }

        throw ValidationException::withMessages([
            trans('auth.failed'),
        ]);
    }
}
