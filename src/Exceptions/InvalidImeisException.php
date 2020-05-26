<?php

namespace MobiMarket\TechSinghs\Exceptions;

use MobiMarket\TechSinghs\Exceptions\BaseTechSinghsException;

class InvalidImeisException extends BaseTechSinghsException
{
    public function __construct(string $message)
    {
        // make sure everything is assigned properly
        parent::__construct($message, 8901);
    }
}
