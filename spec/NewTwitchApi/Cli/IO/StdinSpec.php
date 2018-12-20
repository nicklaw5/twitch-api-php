<?php

namespace spec\NewTwitchApi\Cli\IO;

use NewTwitchApi\Cli\IO\Stdin;
use PhpSpec\ObjectBehavior;

class StdinSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Stdin::class);
    }
}
