<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'user.email'    => 'sometimes|required|email',
            'user.username' => 'sometimes|required',
            'user.password' => 'sometimes|required',
            'user.image'    => 'nullable|url',
            'user.bio'      => 'nullable',
        ];
    }
    
    public function userRequest()
    {
        return $this->validated('user');
    }
}
