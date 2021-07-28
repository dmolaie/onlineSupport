<?php

namespace App\Console\Commands\Question;

use App\Exceptions\Question\QuestionNotFoundException;
use App\Services\Contracts\DTOs\Question\QuestionChangeStatusDTO;
use App\Services\Question\QuestionService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ChangeQuestionStatusJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'question:answered';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'all question change status to answered';

    protected $questionService;

    /**
     * Create a new command instance.
     *
     * @param QuestionService $questionService
     */
    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
        parent::__construct();
    }

    /**
     * this method for change status to answered questions in command
     * Execute the console command.
     * @return bool
     */
    public function handle()
    {
        try {
            $this->info('Cron Job Start for Change status questions');
            $questionChangeStatusDTO = new QuestionChangeStatusDTO();
            $statusAnswered = config('config.status_question.answered');
            $dateOne = Carbon::now()->subDays(7)->format('Y-m-d') . " 00:00:00";
            $dateTwo = Carbon::now()->format('Y-m-d') . " 23:59:59";
            $questions = $this->questionService->getQuestionBetweenDates($dateOne, $dateTwo);
            $questionChangeStatusDTO->setStatus($statusAnswered);
            foreach ($questions as $question) {
                $questionChangeStatusDTO->setId($question->id);
                $this->questionService->changeStatusQuestion($questionChangeStatusDTO);
            }
            $this->info('Cron Job Start for Change questions is successful');
            return true;
        } catch (\Exception $e) {
            $this->error('Something went wrong Change questions is!');
            return false;
        }
    }
}
