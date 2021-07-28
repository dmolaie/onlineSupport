<?php

namespace App\Http\Controllers\Question;

use App\Exceptions\Question\QuestionException;
use App\Exceptions\Question\QuestionNotFoundException;
use App\Http\Controllers\OnlineSupportBaseController;
use App\Http\Presenters\Question\QuestionInfoPresenter;
use App\Http\Presenters\Question\QuestionPaginateInfoPresenter;
use App\Http\Requests\Question\QuestionChangeStatusRequest;
use App\Http\Requests\Question\AnswerCreateRequest;
use App\Http\Requests\Question\QuestionListRequest;
use App\Services\Question\QuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class QuestionSupportController extends OnlineSupportBaseController
{

    /**
     * @var UserService
     */
    private $questionService;

    /**
     * QuestionSupportController constructor.
     * @param QuestionService $questionService
     */
    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    /**
     * this function is for change status question every status by support
     * @param QuestionChangeStatusRequest $request
     * @param QuestionInfoPresenter $questionInfoPresenter
     * @return JsonResponse
     * @throws \App\Exceptions\Question\QuestionNotFoundException
     */
    public function changeStatus(QuestionChangeStatusRequest $request, QuestionInfoPresenter $questionInfoPresenter) {
        try {
            $userRegisterDto = $request->UserQuestionDTO();
            $questionCreated = $this->questionService->changeStatusQuestion($userRegisterDto);
            if ($questionCreated->getId() == null){
                throw new QuestionNotFoundException(trans('response.errorFindQuestion'));
            }
            return $this->response(
                $questionInfoPresenter->transform($questionCreated),
                Response::HTTP_OK,
                trans('response.update_question_success')
            );
        } catch (QuestionException $exception) {
            return $this->response([], $exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * this function is for get list of question by filter name and status with pagination question
     * @param QuestionListRequest $questionListRequest
     * @param QuestionPaginateInfoPresenter $questionPaginateInfoPresenter
     * @return JsonResponse
     */
    public function listQuestionSupport(QuestionListRequest $questionListRequest, QuestionPaginateInfoPresenter $questionPaginateInfoPresenter) {
        try {
            $questionListDTO = $questionListRequest->userQuestionDTO();
            $questions = $this->questionService->listSupportQuestion($questionListDTO);
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
