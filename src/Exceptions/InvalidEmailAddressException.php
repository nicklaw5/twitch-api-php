<?php

namespace TwitchApi\Exceptions;

class InvalidEmailAddressException extends TwitchApiException
{
    public function __construct()
    {
        parent::__construct('Invalid email address provied.');
    }
}
