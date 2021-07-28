<?php

namespace App\Http\Requests\Answer;

use App\Services\Contracts\DTOs\Answer\AnswerInfoDTO;
use Illuminate\Foundation\Http\FormRequest;

class AnswerCreateRequest extends FormRequest
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
            'question_id' => 'exists:questions,id',
            'description' => 'required|min:6',
        ];
    }

    /**
     * @return AnswerInfoDTO
     */
    public function createUserAnswerDTO(): AnswerInfoDTO
    {
        $createAnswerDTO = new AnswerInfoDTO();
        $createAnswerDTO->setDescription($this['description']);
        $createAnswerDTO->setQuestion($this['question_id']);
        return $createAnswerDTO;
    }
}
