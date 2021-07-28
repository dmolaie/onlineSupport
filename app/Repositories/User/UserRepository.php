<?php


namespace App\Repositories\User;


use App\Models\User;
use App\Services\Contracts\DTOs\UserLoginDTO;
use App\Services\Contracts\DTOs\UserRegisterInfoDTO;
use Illuminate\Support\Str;

class UserRepository
{
    protected $entityName = User::class;

    /**
     * method for update o create
     * @param UserRegisterInfoDTO $userRegisterInfoDTO
     * @param User|null $userInfo
     * @return User
     */
    public function createOrUpdateUser(UserRegisterInfoDTO $userRegisterInfoDTO, ?User $userInfo): User
    {
        $user = $userInfo ?? new $this->entityName;
        $user->name = $userRegisterInfoDTO->getName() ?? $user->name;
        $user->email = $userRegisterInfoDTO->getEmail() ?? $user->email;
        if ($userRegisterInfoDTO->getPassword()) {
            $user->password = bcrypt($userRegisterInfoDTO->getPassword());
        }
        if (!empty($user->getDirty())) {
            $user->save();
            $user->api_token = $user->createToken($user->email)->plainTextToken;
        }
        return $user;
    }

    /**
     * this method for find user with email
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->entityName::where('email', $email)
            ->first();
    }

}
