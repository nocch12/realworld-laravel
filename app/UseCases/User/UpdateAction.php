<?php declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class UpdateAction
{
    /**
     * ユーザ更新
     *
     * @param User $user
     * @param array $params
     * @return User
     */
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
