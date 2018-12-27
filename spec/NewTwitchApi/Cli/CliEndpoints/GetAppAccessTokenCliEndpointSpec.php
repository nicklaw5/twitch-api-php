<?php

namespace spec\NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\Auth\OauthApi;
use NewTwitchApi\Cli\IO\InputOutput;
use NewTwitchApi\Cli\IO\InputReader;
use NewTwitchApi\Cli\IO\OutputWriter;
use NewTwitchApi\NewTwitchApi;
use PhpSpec\ObjectBehavior;

class GetAppAccessTokenCliEndpointSpec extends ObjectBehavior
{
    function let(NewTwitchApi $newTwitchApi, InputOutput $inputOutput, InputReader $inputReader, OutputWriter $outputWriter)
    {
        $inputOutput->getInputReader()->willReturn($inputReader);
        $inputOutput->getOutputWriter()->willReturn($outputWriter);
        $this->beConstructedWith($newTwitchApi, $inputOutput);
    }

    function it_should_have_correct_name()
    {
        $this->getName()->shouldReturn('Get an App Access Token');
    }

    function it_should_get_an_app_access_token(NewTwitchApi $newTwitchApi, InputReader $inputReader, OauthApi $oauthApi)
    {
        $oauthApi->getAppAccessToken('')->shouldBeCalled();
        $newTwitchApi->getOauthApi()->willReturn($oauthApi);
        $inputReader->readFromStdin()->willReturn('');

        $this->execute();
    }
}
