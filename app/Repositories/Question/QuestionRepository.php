<?php


namespace App\Repositories\Question;


use App\Models\Questions;
use App\Models\User;
use App\Services\Contracts\DTOs\Question\QuestionInfoDTO;
use App\Services\Contracts\DTOs\Question\QuestionListDTO;
use App\Services\Contracts\DTOs\UserLoginDTO;
use App\Services\Contracts\DTOs\UserRegisterInfoDTO;
use Illuminate\Support\Str;

class QuestionRepository
{
    protected $entityName = Questions::class;

    /**
     * method fo create question
     * @param QuestionInfoDTO $questionCreateDTO
     * @return Questions
     */
    public function create(QuestionInfoDTO $questionCreateDTO): Questions
    {
        $questionEntity = new $this->entityName;
        $questionEntity->title = $questionCreateDTO->getTitle();
        $questionEntity->description = $questionCreateDTO->getDescription();
        $questionEntity->user_id = auth()->user()->id;
        $questionEntity->save();
        return $questionEntity;
    }

    /**
     * method for update question
     * @param QuestionInfoDTO $questionCreateDTO
     * @param Questions $question
     * @return Questions
     */
    public function update(QuestionInfoDTO $questionCreateDTO, Questions $questions): Questions
    {
        $question = $questions ?? new $this->entityName;
        $question->title = $questionCreateDTO->getTitle() ?? $questions->title;
        $question->description = $questionCreateDTO->getDescription() ?? $questions->description;
        $question->status = $questionCreateDTO->getStatus() ?? $questions->status;
        if (!empty($question->getDirty())) {
            $question->save();
        }
        return $question;
    }

    /**
     * @param string $id
     * @return Questions|null
     */
    public function findById(string $id): ?Questions
    {
        return $this->entityName::where('id', $id)->first();
    }


    /**
     * @param QuestionListDTO $questionListDTO
     * @return Questions|null
     */
    public function getAllQuestionCustomer(QuestionListDTO $questionListDTO)
    {
        return $this->entityName::
        when($questionListDTO->getStatus(), function ($query) use ($questionListDTO) {
            $query->where('status', $questionListDTO->getStatus());
        })
            ->when($questionListDTO->getName(), function ($query) use ($questionListDTO) {
                $query->with('user')->whereHas('user', function ($query) use ($questionListDTO) {
                    $query->where('name', 'like', '%' . $questionListDTO->getName() . '%');
                });
            })
            ->paginate(10);
    }

    /**
     * @param string $id
     * @return Questions|null
     */
    public function getAllQuestionUser()
    {
        return $this->entityName::where('user_id', auth()->user()->id)->paginate(10);
    }

    /**
     * @param string $id
     * @return Questions|null
     */
    public function getAll(): ?Questions
    {
        return $this->entityName::get()->paginate(10);
    }

    /**
     * @param string $id
     * @return Questions|null
     */
    public function getAllBetweenDates($dateOne, $dateTwo)
    {
        return $this->entityName::whereBetween('updated_at', [$dateOne, $dateTwo])->get();
    }

}
