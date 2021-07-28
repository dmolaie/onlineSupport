<?php


namespace App\Services\User;

use App\Exceptions\User\UserUnAuthorizedException;
use App\Http\Controllers\Auth\LoginController;
use App\Repositories\User\UserRepository;
use App\Services\Contracts\DTOs\UserLoginDTO;
use App\Services\Contracts\DTOs\UserRegisterInfoDTO;
use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * this method for register user with JWT Sanctum token
     * @param UserRegisterInfoDTO $userRegisterInfoDTO
     * @return UserLoginDTO
     * @throws UserUnAuthorizedException
     */
    public function register(UserRegisterInfoDTO $userRegisterInfoDTO): UserLoginDTO
    {
        $user = $this->userRepository->createOrUpdateUser(
            $userRegisterInfoDTO,
            $this->getUser($userRegisterInfoDTO));
        $userLoginDTO = new UserLoginDTO();
        $userLoginDTO->setEmail($userRegisterInfoDTO->getEmail());
        $userLoginDTO->setToken($user->api_token);
        $userLoginDTO->setId($user->id);
        $userLoginDTO->setName($user->name);
        return $userLoginDTO;

    }

    /**
     * this method for get user info by email
     * @param $userRegisterInfoDTO
     * @return \App\Models\User|null
     * @throws UserUnAuthorizedException
     */
    private function getUser($userRegisterInfoDTO)
    {
        $user = $this->userRepository->findByEmail($userRegisterInfoDTO->getEmail());
        if (!$user || Auth::attempt([
                'email' => $userRegisterInfoDTO->getEmail(),
                'password' => $userRegisterInfoDTO->getPassword()
            ])) {
            return $user;
        }
        throw new UserUnAuthorizedException(trans('response.authenticate.error_username_password'));
    }

    /**
     * this method for login user with JWT Sanctum token with user and password
     * @param UserLoginDTO $userLoginDTO
     * @return UserLoginDTO
     * @throws UserUnAuthorizedException
     */
    public function login(UserLoginDTO $userLoginDTO): UserLoginDTO
    {
        $userLogin= $this->getUser($userLoginDTO);
        if ($userLogin->id) {
            $token = $userLogin->createToken($userLogin->email)->plainTextToken;;
            $userLoginDTO = new UserLoginDTO();
            $userLoginDTO->setEmail($userLogin->email);
            $userLoginDTO->setToken($token);
            $userLoginDTO->setId(\auth()->user()->id);
            $userLoginDTO->setName(\auth()->user()->name);
        }
        return $userLoginDTO;
    }

}

