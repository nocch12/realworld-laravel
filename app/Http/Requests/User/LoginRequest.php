<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'user.email'    => 'required',
            'user.password' => 'required',
        ];
    }

    public function email()
    {
        return $this->validated('user.email');
    }

    public function password()
    {
        return $this->validated('user.password');
    }
}
