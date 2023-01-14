<?php declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
        // 重複チェック
        $validator = Validator::make(
            [
                'username' => $user->username,
                'email'    => $user->email,
            ],
            [
                'username' => 'unique:users,username',
                'email' => 'unique:users,email',
            ],
        );
        $validator->validate();

        $saved = $user->save();

        if ($saved) {
            Auth::login($user);
            return $user;
        }

        throw ValidationException::withMessages([
            trans('auth.failed'),
        ]);
    }
}
