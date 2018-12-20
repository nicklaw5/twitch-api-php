<?php

namespace spec\NewTwitchApi\Cli\IO;

use NewTwitchApi\Cli\IO\Stdin;
use PhpSpec\ObjectBehavior;

class InputReaderSpec extends ObjectBehavior
{
    function let(Stdin $stdin)
    {
        $this->beConstructedWith($stdin);
    }

    function it_should_return_a_trimmed_string(Stdin $stdin)
    {
        $stdin->read()->willReturn('   message   ');
        $this->readFromStdin()->shouldReturn('message');
    }

    function it_should_return_an_integer(Stdin $stdin)
    {
        $stdin->read()->willReturn('42');
        $this->readIntFromStdin()->shouldReturn(42);
    }

    function it_should_return_an_array_from_csv(Stdin $stdin)
    {
        $stdin->read()->willReturn('1,2,3,4,5');
        $this->readCSVIntoArrayFromStdin()->shouldReturn(['1', '2', '3', '4', '5']);
    }
}
