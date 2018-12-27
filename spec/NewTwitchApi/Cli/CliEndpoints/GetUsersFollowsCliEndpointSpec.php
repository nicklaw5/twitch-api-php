<?php

namespace spec\NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\Cli\IO\InputOutput;
use NewTwitchApi\Cli\IO\InputReader;
use NewTwitchApi\Cli\IO\OutputWriter;
use NewTwitchApi\NewTwitchApi;
use NewTwitchApi\Resources\UsersApi;
use PhpSpec\ObjectBehavior;

class GetUsersFollowsCliEndpointSpec extends ObjectBehavior
{
    function let(NewTwitchApi $newTwitchApi, InputOutput $inputOutput, InputReader $inputReader, OutputWriter $outputWriter)
    {
        $inputOutput->getInputReader()->willReturn($inputReader);
        $inputOutput->getOutputWriter()->willReturn($outputWriter);
        $this->beConstructedWith($newTwitchApi, $inputOutput);
    }

    function it_should_have_correct_name()
    {
        $this->getName()->shouldReturn('Get Users Follows');
    }

    function it_should_get_games_by_ids_and_names_with_email(NewTwitchApi $newTwitchApi, InputReader $inputReader, UsersApi $usersApi)
    {
        $usersApi->getUsersFollows(12345, 98765, 100, 'after')->shouldBeCalled();
        $newTwitchApi->getUsersApi()->willReturn($usersApi);
        $inputReader->readIntFromStdin()->willReturn(12345, 98765, 100);
        $inputReader->readFromStdin()->willReturn('after');

        $this->execute();
    }
}
