<?php

namespace App\Http\Requests\User;

use App\Services\Contracts\DTOs\UserRegisterInfoDTO;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required|string|max:30|min:3',
            'email' => 'required|string|max:30|min:5',
            'password' => 'required|confirmed|min:6',
        ];
    }

    /**
     * @return UserRegisterInfoDTO
     */
    public function createUserRegisterDTO(): UserRegisterInfoDTO
    {
        $userRegisterDTO = new UserRegisterInfoDTO();
        $userRegisterDTO->setPassword($this['password']);
        $userRegisterDTO->setName($this['name']);
        $userRegisterDTO->setEmail($this['email']);
        return $userRegisterDTO;
    }
}
