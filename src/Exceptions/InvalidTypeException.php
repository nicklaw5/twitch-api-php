<?php

namespace TwitchApi\Exceptions;

class InvalidTypeException extends TwitchApiException
{
    /**
     * @var string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
