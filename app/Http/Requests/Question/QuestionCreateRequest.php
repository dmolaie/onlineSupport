<?php

namespace App\Http\Requests\Question;

use App\Services\Contracts\DTOs\Question\QuestionInfoDTO;
use Illuminate\Foundation\Http\FormRequest;

class QuestionCreateRequest extends FormRequest
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
            'title' => 'required|string|max:30|min:3',
            'description' => 'required|min:6',
        ];
    }

    /**
     * @return QuestionInfoDTO
     */
    public function createUserQuestionDTO(): QuestionInfoDTO
    {
        $createQuestionDTO = new QuestionInfoDTO();
        $createQuestionDTO->setDescription($this['description']);
        $createQuestionDTO->setTitle($this['title']);
        return $createQuestionDTO;
    }
}
