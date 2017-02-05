<?php

namespace TwitchApi\Exceptions;

class InvalidTypeException extends TwitchApiException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
