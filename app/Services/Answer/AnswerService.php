<?php


namespace App\Services\Answer;

use App\Events\Email\EmailNotifyEvent;
use App\Exceptions\Question\QuestionNotFoundException;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Requests\Question\QuestionChangeStatusRequest;
use App\Models\Questions;
use App\Models\User;
use App\Repositories\Answer\AnswerRepository;
use App\Repositories\Question\QuestionRepository;
use App\Repositories\User\UserRepository;
use App\Services\Contracts\DTOs\Answer\AnswerInfoDTO;
use App\Services\Contracts\DTOs\Pagination\PaginationDTOMaker;
use App\Services\Contracts\DTOs\Question\QuestionChangeStatusDTO;
use App\Services\Contracts\DTOs\Question\QuestionInfoDTO;
use App\Services\Contracts\DTOs\Question\QuestionInfoMakerDTO;
use App\Services\Contracts\DTOs\Question\QuestionListDTO;
use App\Services\Question\QuestionService;
use Domains\User\Exceptions\UserUnAuthorizedException;

class AnswerService
{
    /**
     * @var AnswerRepository
     */
    private $answerRepository;

    /**
     * @var QuestionService
     */
    private $questionService;

    /**
     * UserService constructor.
     * @param AnswerRepository $answerRepository
     * @param QuestionService $questionService
     */
    public function __construct(AnswerRepository $answerRepository, QuestionService $questionService)
    {
        $this->answerRepository = $answerRepository;
        $this->questionService = $questionService;
    }


    /**
     * this function for answer support
     * @param AnswerInfoDTO $answerInfoDTO
     * @return AnswerInfoDTO send email notification by event
     * send email notification by event
     * @throws QuestionNotFoundException
     */
    public function createAnswerSupport(AnswerInfoDTO $answerInfoDTO): AnswerInfoDTO
    {
        $inProgressStatus = config('config.status_question.inProgress');
        $answerCreated = $this->answerRepository->create($answerInfoDTO);
        $answerInfoDTO->setQuestion($answerCreated->question_id);
        $answerInfoDTO->setDescription($answerCreated->description);
        $answerInfoDTO->setId($answerCreated->id);
        $this->changeStatusQuestion($answerCreated->question_id, $inProgressStatus);
        event(new EmailNotifyEvent($answerInfoDTO));
        return $answerInfoDTO;
    }

    /**
     * this function for answer customer
     * @param AnswerInfoDTO $answerInfoDTO
     * @return AnswerInfoDTO send email notification by event
     * send email notification by event
     * @throws QuestionNotFoundException
     */
    public function createAnswerCustomer(AnswerInfoDTO $answerInfoDTO): AnswerInfoDTO
    {
        $inProgressStatus = config('config.status_question.noAnswered');
        $answerCreated = $this->answerRepository->create($answerInfoDTO);
        $answerInfoDTO->setQuestion($answerCreated->question_id);
        $answerInfoDTO->setDescription($answerCreated->description);
        $answerInfoDTO->setId($answerCreated->id);
        $this->changeStatusQuestion($answerCreated->question_id, $inProgressStatus);
        event(new EmailNotifyEvent($answerInfoDTO));
        return $answerInfoDTO;
    }

    /**
     * method for change status questions
     * @param int $questionId
     * @param string $status
     * @return QuestionInfoDTO
     * @throws QuestionNotFoundException
     */
    public function changeStatusQuestion(int $questionId, string $status)
    {
        $questionChangeStatusDTO = new QuestionChangeStatusDTO();
        $questionChangeStatusDTO->setId($questionId);
        $questionChangeStatusDTO->setStatus($status);
        return $this->questionService->changeStatusQuestion($questionChangeStatusDTO);
    }
}

