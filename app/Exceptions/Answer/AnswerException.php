<?php

namespace App\Exceptions\Answer;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class AnswerException extends Exception
{
    /**
     * AnswerException constructor.
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
