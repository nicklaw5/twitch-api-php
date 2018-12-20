<?php

namespace spec\NewTwitchApi\Cli;

use InvalidArgumentException;
use NewTwitchApi\Cli\CliClient;
use PhpSpec\ObjectBehavior;

class CliClientSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(['cmd', 'client-id', 'client-secret']);
        $this->shouldHaveType(CliClient::class);
        $this->shouldNotThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_without_client_id()
    {
        $this->beConstructedWith(['cmd']);
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_without_client_secret()
    {
        $this->beConstructedWith(['cmd', 'client-id']);
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }
}
