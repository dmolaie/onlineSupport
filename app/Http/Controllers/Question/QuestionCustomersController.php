<?php

namespace App\Http\Controllers\Question;

use App\Exceptions\Question\QuestionException;
use App\Exceptions\Question\QuestionNotFoundException;
use App\Http\Controllers\OnlineSupportBaseController;
use App\Http\Presenters\Question\QuestionInfoPresenter;
use App\Http\Presenters\Question\QuestionPaginateInfoPresenter;
use App\Http\Requests\Question\QuestionChangeStatusRequest;
use App\Http\Requests\Question\QuestionCreateRequest;
use App\Http\Requests\Question\QuestionListRequest;
use App\Services\Question\QuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class QuestionCustomersController extends OnlineSupportBaseController
{

    /**
     * @var UserService
     */
    private $questionService;

    /**
     * QuestionCustomersController constructor.
     * @param QuestionService $questionService
     */
    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    /**
     * this function is for create question with status Not Answered by default by customer user
     * @param QuestionCreateRequest $request
     * @param QuestionInfoPresenter $questionInfoPresenter
     * @return JsonResponse
     */
    public function create(QuestionCreateRequest $request, QuestionInfoPresenter $questionInfoPresenter) {
        try {
            $userRegisterDto = $request->createUserQuestionDTO();
            $questionCreated = $this->questionService->createQuestion($userRegisterDto);
            return $this->response(
                $questionInfoPresenter->transformDTO($questionCreated),
                Response::HTTP_OK,
                trans('response.create_question_success')
            );
        } catch (QuestionException $exception) {
            return $this->response([], $exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * this function is for list question by every self user
     * @param QuestionPaginateInfoPresenter $questionPaginateInfoPresenter
     * @return JsonResponse
     */
    public function listCustomerQuestion(QuestionPaginateInfoPresenter $questionPaginateInfoPresenter) {
        try {
            $questions = $this->questionService->listQuestion();
            return $this->response(
                $questionPaginateInfoPresenter->transform($questions),
                Response::HTTP_OK,
                trans('response.update_question_success')
            );
        } catch (QuestionException $exception) {
            return $this->response([], $exception->getCode(), $exception->getMessage());
        }
    }
}
