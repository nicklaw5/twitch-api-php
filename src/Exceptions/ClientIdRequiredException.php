<?php

namespace TwitchApi\Exceptions;

class ClientIdRequiredException extends TwitchApiException
{
    public function __construct()
    {
        parent::__construct('You must provide a \'client_id\' option.');
    }
}
