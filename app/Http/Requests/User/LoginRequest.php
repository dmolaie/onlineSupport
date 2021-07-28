<?php

namespace App\Http\Requests\User;

use App\Services\Contracts\DTOs\UserLoginDTO;
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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|max:30|min:5',
            'password' => 'required|min:6',
        ];
    }

    /**
     * @return UserLoginDTO
     */
    public function createLoginDto(): UserLoginDTO
    {
        $userLoginDTO = new UserLoginDTO();
        $userLoginDTO->setPassword($this['password']);
        $userLoginDTO->setEmail($this['email']);
        return $userLoginDTO;
    }
}
