<?php

namespace App\Exceptions\User;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserUnAuthorizedException extends Exception
{
    /**
     * UserUnAuthorizedException constructor.
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message, Response::HTTP_UNAUTHORIZED);
    }

}
