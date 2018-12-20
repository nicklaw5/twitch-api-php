<?php

namespace spec\NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\Cli\IO\InputOutput;
use NewTwitchApi\Cli\IO\InputReader;
use NewTwitchApi\Cli\IO\OutputWriter;
use NewTwitchApi\NewTwitchApi;
use NewTwitchApi\Resources\UsersApi;
use PhpSpec\ObjectBehavior;

class GetUserWithAccessTokenCliEndpointSpec extends ObjectBehavior
{
    function let(NewTwitchApi $newTwitchApi, InputOutput $inputOutput, InputReader $inputReader, OutputWriter $outputWriter)
    {
        $inputOutput->getInputReader()->willReturn($inputReader);
        $inputOutput->getOutputWriter()->willReturn($outputWriter);
        $this->beConstructedWith($newTwitchApi, $inputOutput);
    }

    function it_should_have_correct_name()
    {
        $this->getName()->shouldReturn('Get User with Access Token');
    }

    function it_should_get_games_by_ids_and_names_with_email(NewTwitchApi $newTwitchApi, InputReader $inputReader, UsersApi $usersApi)
    {
        $usersApi->getUserByAccessToken('access-token', true)->shouldBeCalled();
        $newTwitchApi->getUsersApi()->willReturn($usersApi);
        $inputReader->readFromStdin()->willReturn('access-token', 'y');

        $this->execute();
    }

    function it_should_get_games_by_ids_and_names_without_email(NewTwitchApi $newTwitchApi, InputReader $inputReader, UsersApi $usersApi)
    {
        $usersApi->getUserByAccessToken('access-token', false)->shouldBeCalled();
        $newTwitchApi->getUsersApi()->willReturn($usersApi);
        $inputReader->readFromStdin()->willReturn('access-token', 'n');

        $this->execute();
    }
}
