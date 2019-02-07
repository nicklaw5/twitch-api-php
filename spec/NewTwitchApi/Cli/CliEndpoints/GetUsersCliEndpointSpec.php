<?php

namespace spec\NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\Cli\IO\InputOutput;
use NewTwitchApi\Cli\IO\InputReader;
use NewTwitchApi\Cli\IO\OutputWriter;
use NewTwitchApi\NewTwitchApi;
use NewTwitchApi\Resources\UsersApi;
use PhpSpec\ObjectBehavior;

class GetUsersCliEndpointSpec extends ObjectBehavior
{
    function let(NewTwitchApi $newTwitchApi, InputOutput $inputOutput, InputReader $inputReader, OutputWriter $outputWriter)
    {
        $inputOutput->getInputReader()->willReturn($inputReader);
        $inputOutput->getOutputWriter()->willReturn($outputWriter);
        $this->beConstructedWith($newTwitchApi, $inputOutput);
    }

    function it_should_have_correct_name()
    {
        $this->getName()->shouldReturn('Get Users');
    }

    function it_should_get_games_by_ids_and_names_with_email(NewTwitchApi $newTwitchApi, InputReader $inputReader, UsersApi $usersApi)
    {
        $usersApi->getUsers(['12345', '98765'], ['game1', 'game2'], true)->shouldBeCalled();
        $newTwitchApi->getUsersApi()->willReturn($usersApi);
        $inputReader->readCSVIntoArrayFromStdin()->willReturn(['12345', '98765'], ['game1', 'game2']);
        $inputReader->readFromStdin()->willReturn('y');

        $this->execute();
    }

    function it_should_get_games_by_ids_and_names_without_email(NewTwitchApi $newTwitchApi, InputReader $inputReader, UsersApi $usersApi)
    {
        $usersApi->getUsers(['12345', '98765'], ['game1', 'game2'], false)->shouldBeCalled();
        $newTwitchApi->getUsersApi()->willReturn($usersApi);
        $inputReader->readCSVIntoArrayFromStdin()->willReturn(['12345', '98765'], ['game1', 'game2']);
        $inputReader->readFromStdin()->willReturn('n');

        $this->execute();
    }
}
