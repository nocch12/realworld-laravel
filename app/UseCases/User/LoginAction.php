<?php declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class LoginAction
{
    /**
     * ログイン
     *
     * @param string $email
     * @param string $password
     * @return User
     */
    public function __invoke(string $email, string $password): User
    {
        $user = User::where('email', $email)->first();

        if (Hash::check($password, $user->password)) {
            Auth::login($user);
            return $user;
        }

        throw ValidationException::withMessages([
            trans('auth.faild'),
        ]);
    }
}
