<?php


namespace App\Http\Presenters\Question;

use App\Services\Contracts\DTOs\Question\QuestionInfoDTO;
use App\Services\Contracts\DTOs\UserLoginDTO;

class QuestionInfoPresenter
{
    public function transformMany(array $questionDTOs): array
    {
        return array_map(function ($questionDTO) {
            return $this->transform($questionDTO);
        }, $questionDTOs);
    }

    public function transform(array $questionInfoDTO)
    {
        return [
            'id' => $questionInfoDTO['id'],
            'title' => $questionInfoDTO['title'],
            'description' => $questionInfoDTO['description'],
            'status' => $questionInfoDTO['status'],
        ];
    }

    public function transformDTO(QuestionInfoDTO $questionInfoDTO)
    {
        return [
            'id' => $questionInfoDTO->getId(),
            'title' => $questionInfoDTO->getTitle(),
            'description' => $questionInfoDTO->getDescription(),
            'status' => $questionInfoDTO->getStatus(),
        ];
    }
}
