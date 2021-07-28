<?php


namespace App\Http\Presenters\User;

use App\Services\Contracts\DTOs\UserLoginDTO;

class UserInfoPresenter
{
    /**
     * @param UserLoginDTO $userLoginDTO
     * @return array
     */
    public function transform(UserLoginDTO $userLoginDTO)
    {
        return [
            'id' => $userLoginDTO->getId(),
            'name' => $userLoginDTO->getName(),
            'email' => $userLoginDTO->getEmail(),
            'token' => $userLoginDTO->getToken(),
        ];
    }
}
