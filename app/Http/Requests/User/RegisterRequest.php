<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user.email'    => 'required|email',
            'user.password' => 'required',
            'user.username' => 'required',
        ];
    }

    public function makeUser()
    {
        $params = $this->validated('user');

        return new User([
            'username' => $params['username'],
            'email' => $params['email'],
            'password' => Hash::make($params['password']),
        ]);
    }
}
