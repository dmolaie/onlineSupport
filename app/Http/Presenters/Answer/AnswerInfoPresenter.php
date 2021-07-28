<?php


namespace App\Http\Presenters\Answer;

use App\Services\Contracts\DTOs\Answer\AnswerInfoDTO;
use App\Services\Contracts\DTOs\Question\QuestionInfoDTO;


class AnswerInfoPresenter
{
    public function transformMany(array $answerDTOs): array
    {
        return array_map(function ($answerDTO) {
            return $this->transform($answerDTO);
        }, $answerDTOs);
    }

    public function transform(AnswerInfoDTO $answerInfoDTO)
    {
        return [
            'id' => $answerInfoDTO->getId(),
            'description' => $answerInfoDTO->getDescription(),
            'questionId' => $answerInfoDTO->getQuestion(),
        ];
    }
}
