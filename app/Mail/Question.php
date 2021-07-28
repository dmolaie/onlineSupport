<?php

namespace App\Mail;

use App\Services\Contracts\DTOs\Question\QuestionInfoDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Question extends Mailable
{
    use Queueable, SerializesModels;

    public $dataDTO;

    /**
     * Create a new message instance.
     *
     * @param $dataDTO
     */
    public function __construct($dataDTO)
    {
        $this->dataDTO = $dataDTO;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(auth()->user()->email, $this->dataDTO->getTitle())
            ->view('emails.question');
    }
}
