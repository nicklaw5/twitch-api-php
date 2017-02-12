<?php

namespace TwitchApi\Exceptions;

class InvalidStreamTypeException extends TwitchApiException
{
    public function __construct()
    {
        parent::__construct('Invalid \'streamType\' provided. StreamType can only be set to \'live\', \'playlist\' or \'all\'.');
    }
}
