<?php

namespace Teardrops\Teardrops\Exceptions;

class NotFoundHttpException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 404);
    }
}
