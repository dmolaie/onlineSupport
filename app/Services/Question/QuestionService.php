<?php


namespace App\Services\Question;

use App\Events\Email\EmailNotifyEvent;
use App\Exceptions\Question\QuestionNotFoundException;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Requests\Question\QuestionChangeStatusRequest;
use App\Models\Questions;
use App\Models\User;
use App\Repositories\Question\QuestionRepository;
use App\Repositories\User\UserRepository;
use App\Services\Contracts\DTOs\Pagination\PaginationDTOMaker;
use App\Services\Contracts\DTOs\Question\QuestionChangeStatusDTO;
use App\Services\Contracts\DTOs\Question\QuestionInfoDTO;
use App\Services\Contracts\DTOs\Question\QuestionInfoMakerDTO;
use App\Services\Contracts\DTOs\Question\QuestionListDTO;
use Domains\User\Exceptions\UserUnAuthorizedException;

class QuestionService
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    /**
     * @var
     */
    private $paginationDTOMaker;

    /**
     * UserService constructor.
     * @param QuestionRepository $questionRepository
     * @param PaginationDTOMaker $paginationDTOMaker
     */
    public function __construct(QuestionRepository $questionRepository, PaginationDTOMaker $paginationDTOMaker)
    {
        $this->questionRepository = $questionRepository;
        $this->paginationDTOMaker = $paginationDTOMaker;
    }


    /**
     * this method for create question
     * @param QuestionInfoDTO $questionCreateDTO
     * @return QuestionInfoDTO
     * send email notification by event
     */
    public function createQuestion(QuestionInfoDTO $questionCreateDTO): QuestionInfoDTO
    {
        $questionCreated = $this->questionRepository->create($questionCreateDTO);
        $questionCreateDTO->setId($questionCreated->id);
        $questionCreateDTO->setTitle($questionCreated->title);
        $questionCreateDTO->setDescription($questionCreated->description);
        event(new EmailNotifyEvent($questionCreateDTO));
        return $questionCreateDTO;
    }

    /**
     * this method for change status question with QuestionChangeStatusDTO
     * @param QuestionChangeStatusDTO $questionChangeStatusDTO
     * @return QuestionInfoDTO
     * send email notification by event
     * @throws QuestionNotFoundException
     */
    public function changeStatusQuestion(QuestionChangeStatusDTO $questionChangeStatusDTO): QuestionInfoDTO
    {
        $question = $this->getQuestion($questionChangeStatusDTO);
        $question->status = $questionChangeStatusDTO->getStatus();
        $questionDTO = $this->makeQuestionDTO($question);
        $questionCreated = $this->questionRepository->update($questionDTO, $question);
        $questionDTO = $this->makeQuestionDTO($questionCreated);
        event(new EmailNotifyEvent($questionDTO));
        return $questionDTO;
    }

    /**
     * thios method for create DTO as QuestionInfoDTO
     * @param $question
     * @return QuestionInfoDTO
     */
    private function makeQuestionDTO($question) :QuestionInfoDTO
    {
        $questionDTO = new QuestionInfoDTO();
        $questionDTO->setId($question->id);
        $questionDTO->setTitle($question->title);
        $questionDTO->setDescription($question->description);
        $questionDTO->setStatus($question->status);
        return $questionDTO;
    }

    /**
     * this method for get all question user customer by self user id
     * @param QuestionChangeStatusDTO $questionChangeStatusDTO
     * @return mixed
     * @throws QuestionNotFoundException
     */
    private function getQuestion(QuestionChangeStatusDTO $questionChangeStatusDTO): Questions
    {
        $question = $this->questionRepository->findById($questionChangeStatusDTO->getId());
        if ($question->id) {
            return $question;
        }
        throw new QuestionNotFoundException(trans('response.errorFindQuestion'));
    }

    public function listQuestion() :PaginationDTOMaker
    {
        $question = $this->questionRepository->getAllQuestionUser();
        return $this->paginationDTOMaker->perform(
            $question,
            QuestionInfoMakerDTO::class
        );
    }

    /**
     * this method for get all question user support
     * @param QuestionListDTO $questionListDTO
     * @return PaginationDTOMaker
     */
    public function listSupportQuestion(QuestionListDTO $questionListDTO) :PaginationDTOMaker
    {
        $question = $this->questionRepository->getAllQuestionCustomer($questionListDTO);
        return $this->paginationDTOMaker->perform(
            $question,
            QuestionInfoMakerDTO::class
        );
    }

    /**
     * this method for get all question user support
     * @param $dateOne
     * @param $dateTwo
     * @return PaginationDTOMaker
     */
    public function getQuestionBetweenDates($dateOne, $dateTwo)
    {
        $question = $this->questionRepository->getAllBetweenDates($dateOne,$dateTwo);
        return $question;
    }
}

