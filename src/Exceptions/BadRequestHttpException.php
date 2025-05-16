<?php

namespace Teardrops\Teardrops\Exceptions;

class BadRequestHttpException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 400);
    }
}
