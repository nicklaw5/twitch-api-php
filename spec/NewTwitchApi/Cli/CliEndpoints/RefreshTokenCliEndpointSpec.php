<?php

namespace spec\NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\Auth\OauthApi;
use NewTwitchApi\Cli\IO\InputOutput;
use NewTwitchApi\Cli\IO\InputReader;
use NewTwitchApi\Cli\IO\OutputWriter;
use NewTwitchApi\NewTwitchApi;
use PhpSpec\ObjectBehavior;

class RefreshTokenCliEndpointSpec extends ObjectBehavior
{
    function let(NewTwitchApi $newTwitchApi, InputOutput $inputOutput, InputReader $inputReader, OutputWriter $outputWriter)
    {
        $inputOutput->getInputReader()->willReturn($inputReader);
        $inputOutput->getOutputWriter()->willReturn($outputWriter);
        $this->beConstructedWith($newTwitchApi, $inputOutput);
    }

    function it_should_have_correct_name()
    {
        $this->getName()->shouldReturn('Refresh an Access Token');
    }

    function it_should_refresh_a_token(NewTwitchApi $newTwitchApi, InputReader $inputReader, OauthApi $oauthApi)
    {
        $oauthApi->refreshToken('refresh-token', '')->shouldBeCalled();
        $newTwitchApi->getOauthApi()->willReturn($oauthApi);
        $inputReader->readFromStdin()->willReturn('refresh-token', '');

        $this->execute();
    }
}
