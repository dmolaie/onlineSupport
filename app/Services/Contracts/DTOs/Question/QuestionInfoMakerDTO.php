<?php

namespace App\Services\Contracts\DTOs\Question;

use App\Models\Questions;

/**
 * Class QuestionValueObject
 */
class QuestionInfoMakerDTO
{
    /**
     * @param $questionCollection
     * @return array
     */
    public function convertMany($questionCollection)
    {
        return $questionCollection->map(function ($question){
            return $this->convert($question);
        })->toArray();
    }

    /**
     * @param QuestionInfoDTO $questionInfoDTO
     * @return array
     */
    public function convert(Questions $questions)
    {
        return [
            'id' => $questions->id,
            'title' => $questions->title,
            'description' => $questions->description,
            'status' => $questions->status,
        ];
    }
}
