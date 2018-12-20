<?php

namespace spec\NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\Cli\Exceptions\ExitCliException;
use PhpSpec\ObjectBehavior;

class ExitCliEndpointSpec extends ObjectBehavior
{
    function it_should_have_correct_name()
    {
        $this->getName()->shouldReturn('Quit');
    }

    function it_should_throw_exception_to_exit_cli()
    {
        $this->shouldThrow(ExitCliException::class)->during('execute');
    }
}
