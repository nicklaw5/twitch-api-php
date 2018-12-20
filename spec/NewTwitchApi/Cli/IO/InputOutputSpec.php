<?php

namespace spec\NewTwitchApi\Cli\IO;

use NewTwitchApi\Cli\IO\InputReader;
use NewTwitchApi\Cli\IO\OutputWriter;
use PhpSpec\ObjectBehavior;

class InputOutputSpec extends ObjectBehavior
{
    function let(InputReader $inputReader, OutputWriter $outputWriter)
    {
        $this->beConstructedWith($inputReader, $outputWriter);
    }

    function it_should_return_input_reader(InputReader $inputReader)
    {
        $this->getInputReader()->shouldReturn($inputReader);
    }

    function it_should_return_output_writer(OutputWriter $outputWriter)
    {
        $this->getOutputWriter()->shouldReturn($outputWriter);
    }
}
