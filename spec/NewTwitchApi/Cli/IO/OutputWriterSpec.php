<?php

namespace spec\NewTwitchApi\Cli\IO;

use NewTwitchApi\Cli\IO\OutputWriter;
use PhpSpec\ObjectBehavior;

class OutputWriterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OutputWriter::class);
    }
}
