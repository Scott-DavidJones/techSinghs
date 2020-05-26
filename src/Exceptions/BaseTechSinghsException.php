<?php

namespace MobiMarket\TechSinghs\Exceptions;

use Exception;

class BaseTechSinghsException extends Exception
{
    public function __construct(string $message, int $code, Exception $previous = null)
    {
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}
