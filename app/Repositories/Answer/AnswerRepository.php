<?php


namespace App\Repositories\Answer;


use App\Models\Answers;
use App\Models\Questions;
use App\Services\Contracts\DTOs\Answer\AnswerInfoDTO;
use App\Services\Contracts\DTOs\Question\QuestionInfoDTO;

class AnswerRepository
{
    protected $entityName = Answers::class;

    /**
     * method fo create answer
     * @param AnswerInfoDTO $answerInfoDTO
     * @return Questions
     */
    public function create(AnswerInfoDTO $answerInfoDTO): Answers
    {
        $questionEntity = new $this->entityName;
        $questionEntity->description = $answerInfoDTO->getDescription();
        $questionEntity->user_id = auth()->user()->id;
        $questionEntity->question_id = $answerInfoDTO->getQuestion();
        $questionEntity->save();
        return $questionEntity;
    }

}
