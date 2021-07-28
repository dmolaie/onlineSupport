<?php

namespace App\Exceptions\Question;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class QuestionNotFoundException extends Exception
{
    /**
     * QuestionException constructor.
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
