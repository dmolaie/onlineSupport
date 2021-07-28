<?php

namespace App\Http\Controllers\User;

use App\Exceptions\User\UserUnAuthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OnlineSupportBaseController;
use App\Http\Presenters\User\UserInfoPresenter;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\UserRegisterRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class UserController
 */
class UserController extends OnlineSupportBaseController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * this method is for register user
     * @param UserRegisterRequest $request
     * @param UserInfoPresenter $userInfoPresenter
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request, UserInfoPresenter $userInfoPresenter)
    {
        try {
            $userRegisterDto = $request->createUserRegisterDTO();
            $userRegisterResult = $this->userService->register($userRegisterDto);
            return $this->response(
                $userInfoPresenter->transform($userRegisterResult),
                Response::HTTP_OK,
                trans('response.success_register')
            );
        } catch (UserUnAuthorizedException $exception) {
            return $this->response([], $exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * this method is for login user
     * @param LoginRequest $request
     * @param UserInfoPresenter $userInfoPresenter
     * @return JsonResponse
     */
    public function login(LoginRequest $request, UserInfoPresenter $userInfoPresenter)
    {
        try {
            $userLoginDTO = $request->createLoginDto();
            $userLoginData = $this->userService->login($userLoginDTO);
            if ($userLoginData->getToken() == null) {
                throw new UserUnAuthorizedException(trans('response.fail_auth'));
            }
            return $this->response(
                $userInfoPresenter->transform($userLoginData),
                Response::HTTP_OK,
                trans('response.success_login')
            );
        } catch (UserUnAuthorizedException $exception) {
            return $this->response([], $exception->getCode(), trans('response.fail_auth'));
        }
    }

}
