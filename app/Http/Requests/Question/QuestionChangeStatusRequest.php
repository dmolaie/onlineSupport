<?php

namespace App\Http\Requests\Question;

use App\Services\Contracts\DTOs\Question\QuestionChangeStatusDTO;
use App\Services\Contracts\DTOs\Question\QuestionInfoDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionChangeStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question_id' => 'required|exists:questions,id',
            'status' => ['required', Rule::in(array_keys(config('config.status_question')))],
        ];
    }

    /**
     * @return QuestionInfoDTO
     */
    public function UserQuestionDTO(): QuestionChangeStatusDTO
    {
        $QuestionDTO = new QuestionChangeStatusDTO();
        $QuestionDTO->setId($this['question_id']);
        $QuestionDTO->setStatus($this['status']);
        return $QuestionDTO;
    }
}
