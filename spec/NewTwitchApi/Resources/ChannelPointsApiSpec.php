<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use NewTwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class ChannelPointsApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_custom_reward(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'channel_points/custom_rewards', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getCustomReward('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_custom_reward_by_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'channel_points/custom_rewards', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '321']], [])->willReturn($request);
        $this->getCustomReward('TEST_TOKEN', '123', ['321'])->shouldBe($response);
    }

    function it_should_get_custom_reward_by_ids(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'channel_points/custom_rewards', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '321'], ['key' => 'id', 'value' => '456']], [])->willReturn($request);
        $this->getCustomReward('TEST_TOKEN', '123', ['321', '456'])->shouldBe($response);
    }

    function it_should_get_custom_reward_by_id_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'channel_points/custom_rewards', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '321'], ['key' => 'only_manageable_rewards', 'value' => 1]], [])->willReturn($request);
        $this->getCustomReward('TEST_TOKEN', '123', ['321'], true)->shouldBe($response);
    }

    function it_should_get_custom_reward_by_ids_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'channel_points/custom_rewards', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '321'], ['key' => 'id', 'value' => '456'], ['key' => 'only_manageable_rewards', 'value' => 1]], [])->willReturn($request);
        $this->getCustomReward('TEST_TOKEN', '123', ['321', '456'], true)->shouldBe($response);
    }

    function it_should_get_custom_reward_redemption(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'channel_points/custom_rewards/redemptions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'reward_id', 'value' => '321']], [])->willReturn($request);
        $this->getCustomRewardRedemption('TEST_TOKEN', '123', '321')->shouldBe($response);
    }

    function it_should_get_custom_reward_redemption_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'channel_points/custom_rewards/redemptions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'reward_id', 'value' => '321'], ['key' => 'status', 'value' => 'UNFULFILLED'], ['key' => 'sort', 'value' => 'NEWEST'], ['key' => 'after', 'value' => 'abc'], ['key' => 'first', 'value' => 100]], [])->willReturn($request);
        $this->getCustomRewardRedemption('TEST_TOKEN', '123', '321', [], 'UNFULFILLED', 'NEWEST', 'abc', 100)->shouldBe($response);
    }

    function it_should_get_custom_reward_redemption_by_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'channel_points/custom_rewards/redemptions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'reward_id', 'value' => '321'], ['key' => 'id', 'value' => '111']], [])->willReturn($request);
        $this->getCustomRewardRedemption('TEST_TOKEN', '123', '321', ['111'])->shouldBe($response);
    }

    function it_should_get_custom_reward_redemption_by_ids(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'channel_points/custom_rewards/redemptions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'reward_id', 'value' => '321'], ['key' => 'id', 'value' => '111'], ['key' => 'id', 'value' => '222']], [])->willReturn($request);
        $this->getCustomRewardRedemption('TEST_TOKEN', '123', '321', ['111', '222'])->shouldBe($response);
    }

    function it_should_create_custom_reward(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'channel_points/custom_rewards', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'title', 'value' => 'test 123'], ['key' => 'cost', 'value' => 100]])->willReturn($request);
        $this->createCustomReward('TEST_TOKEN', '123', 'test 123', 100)->shouldBe($response);
    }

    function it_should_create_custom_reward_with_one_opt(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'channel_points/custom_rewards', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'title', 'value' => 'test 123'], ['key' => 'cost', 'value' => 100], ['key' => 'prompt', 'value' => 'What is your name?']])->willReturn($request);
        $this->createCustomReward('TEST_TOKEN', '123', 'test 123', 100, ['prompt' => 'What is your name?'])->shouldBe($response);
    }

    function it_should_create_custom_reward_with_multiple_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'channel_points/custom_rewards', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'title', 'value' => 'test 123'], ['key' => 'cost', 'value' => 100], ['key' => 'prompt', 'value' => 'What is your name?'], ['key' => 'is_enabled', 'value' => 1]])->willReturn($request);
        $this->createCustomReward('TEST_TOKEN', '123', 'test 123', 100, ['prompt' => 'What is your name?', 'is_enabled' => 1])->shouldBe($response);
    }

    function it_should_update_custom_reward(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'channel_points/custom_rewards', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '321']], [])->willReturn($request);
        $this->updateCustomReward('TEST_TOKEN', '123', '321')->shouldBe($response);
    }

    function it_should_update_custom_reward_with_one_opt(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'channel_points/custom_rewards', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '321']], [['key' => 'prompt', 'value' => 'What is your name?']])->willReturn($request);
        $this->updateCustomReward('TEST_TOKEN', '123', '321', ['prompt' => 'What is your name?'])->shouldBe($response);
    }

    function it_should_update_custom_reward_with_multiple_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'channel_points/custom_rewards', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '321']], [['key' => 'prompt', 'value' => 'What is your name?'], ['key' => 'is_enabled', 'value' => 1]])->willReturn($request);
        $this->updateCustomReward('TEST_TOKEN', '123', '321', ['prompt' => 'What is your name?', 'is_enabled' => 1])->shouldBe($response);
    }

    function it_should_delete_custom_reward(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('DELETE', 'channel_points/custom_rewards', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '321']], [])->willReturn($request);
        $this->deleteCustomReward('TEST_TOKEN', '123', '321')->shouldBe($response);
    }

    function it_should_update_redemption_status(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'channel_points/custom_rewards/redemptions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'reward_id', 'value' => '456'], ['key' => 'id', 'value' => '789']], [['key' => 'status', 'value' => 'FULFILLED']])->willReturn($request);
        $this->updateRedemptionStatus('TEST_TOKEN', '123', '456', '789', 'FULFILLED')->shouldBe($response);
    }
}
