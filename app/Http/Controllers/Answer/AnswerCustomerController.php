<?php

namespace App\Http\Controllers\Answer;

use App\Exceptions\Answer\AnswerException;
use App\Http\Controllers\OnlineSupportBaseController;
use App\Http\Presenters\Answer\AnswerInfoPresenter;
use App\Http\Requests\Answer\AnswerCreateRequest;
use App\Services\Answer\AnswerService;

use Illuminate\Http\Response;

class AnswerCustomerController extends OnlineSupportBaseController
{
    /**
     * @var AnswerService
     */
    private $answerService;

    /**
     * AnswerCustomerController constructor.
     * @param AnswerService $answerService
     */
    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }

    /**
     * this function is for create answers question with status noAnswered by user customer
     * @param AnswerCreateRequest $request
     * @param AnswerInfoPresenter $answerInfoPresenter
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(AnswerCreateRequest $request, AnswerInfoPresenter $answerInfoPresenter) {
        try {
            $userRegisterDto = $request->createUserAnswerDTO();
            $questionCreated = $this->answerService->createAnswerCustomer($userRegisterDto);
            return $this->response(
                $answerInfoPresenter->transform($questionCreated),
                Response::HTTP_OK,
                trans('response.create_answer_success')
            );
        } catch (AnswerException $exception) {
            return $this->response([], $exception->getCode(), $exception->getMessage());
        }
    }
}
