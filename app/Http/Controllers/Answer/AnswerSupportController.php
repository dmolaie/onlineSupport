<?php

namespace App\Http\Controllers\Answer;

use App\Exceptions\Answer\AnswerException;
use App\Http\Controllers\OnlineSupportBaseController;
use App\Http\Presenters\Answer\AnswerInfoPresenter;
use App\Http\Requests\Answer\AnswerCreateRequest;
use App\Http\Requests\Answer\AnsweredStatusRequest;
use App\Services\Answer\AnswerService;

use Illuminate\Http\Response;

class AnswerSupportController extends OnlineSupportBaseController
{
    /**
     * @var AnswerService
     */
    private $answerService;

    /**
     * AnswerSupportController constructor.
     * @param AnswerService $answerService
     */
    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }

    /**
     * this function is for create answers question with status inProgress by user support
     * @param AnswerCreateRequest $request
     * @param AnswerInfoPresenter $answerInfoPresenter
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Question\QuestionNotFoundException
     */
    public function create(AnswerCreateRequest $request, AnswerInfoPresenter $answerInfoPresenter)
    {
        try {
            $answeredDto = $request->createUserAnswerDTO();
            $questionCreated = $this->answerService->createAnswerSupport($answeredDto);
            return $this->response(
                $answerInfoPresenter->transform($questionCreated),
                Response::HTTP_OK,
                trans('response.create_answer_success')
            );
        } catch (AnswerException $exception) {
            return $this->response([], $exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * this function is for change status question to answered by user support
     * @param AnsweredStatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Question\QuestionNotFoundException
     */
    public function changeStatusAnswered(AnsweredStatusRequest $request)
    {
        try {
            $answeredDto = $request->createUserAnswerDTO();
            $answeredStatus = config('config.status_question.answered');
            $this->answerService->changeStatusQuestion($answeredDto->getQuestion(), $answeredStatus);
            return $this->response([], Response::HTTP_OK, trans('response.create_answer_success'));
        } catch (AnswerException $exception) {
            return $this->response([], $exception->getCode(), $exception->getMessage());
        }
    }
}
