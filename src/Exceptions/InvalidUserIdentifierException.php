<?php

namespace TwitchApi\Exceptions;

class InvalidUserIdentifierException extends TwitchApiException
{
    public function __construct()
    {
        parent::__construct('Invalid user identifier provided.');
    }
}
