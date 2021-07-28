<?php

namespace App\Http\Requests\Question;

use App\Services\Contracts\DTOs\Question\QuestionListDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionListRequest extends FormRequest
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
            'user_name' => 'string|max:30|min:3',
            'status' => [Rule::in(array_keys(config('config.status_question')))],
        ];
    }

    /**
     * @return QuestionListDTO
     */
    public function userQuestionDTO(): QuestionListDTO
    {
        $QuestionDTO = new QuestionListDTO();
        $QuestionDTO->setName($this['user_name']);
        $QuestionDTO->setStatus($this['status']);
        return $QuestionDTO;
    }
}
