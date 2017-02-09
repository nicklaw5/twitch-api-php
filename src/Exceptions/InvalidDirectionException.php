<?php

namespace TwitchApi\Exceptions;

class InvalidDirectionException extends TwitchApiException
{
    public function __construct()
    {
        parent::__construct('Invalid \'direction\' provided. Direction can only be set to \'asc\' or\'desc\'.');
    }
}
