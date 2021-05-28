<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestGenerator;
use PhpSpec\ObjectBehavior;

class PredictionsApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_predictions(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'predictions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getPredictions('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_predictions_by_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'predictions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '321']], [])->willReturn($request);
        $this->getPredictions('TEST_TOKEN', '123', ['321'])->shouldBe($response);
    }

    function it_should_get_predictions_by_ids(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'predictions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '321'], ['key' => 'id', 'value' => '456']], [])->willReturn($request);
        $this->getPredictions('TEST_TOKEN', '123', ['321', '456'])->shouldBe($response);
    }

    function it_should_get_predictions_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'predictions', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'after', 'value' => 'abc'], ['key' => 'first', 'value' => 100]], [])->willReturn($request);
        $this->getPredictions('TEST_TOKEN', '123', [], 'abc', 100)->shouldBe($response);
    }

    function it_should_create_a_prediction(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'predictions', 'TEST_TOKEN', [], [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'title', 'value' => 'Will the coin land on heads or tails?'], ['key' => 'outcomes', 'value' => [['title' => 'Heads'], ['title' => 'Tails']]], ['key' => 'prediction_window', 'value' => 15]])->willReturn($request);
        $this->createPrediction('TEST_TOKEN', '123', 'Will the coin land on heads or tails?', [['title' => 'Heads'], ['title' => 'Tails']], 15)->shouldBe($response);
    }

    function it_should_end_a_prediction(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'predictions', 'TEST_TOKEN', [], [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '456'], ['key' => 'status', 'value' => 'CANCELLED']])->willReturn($request);
        $this->endPrediction('TEST_TOKEN', '123', '456', 'CANCELLED')->shouldBe($response);
    }

    function it_should_resolve_a_prediction(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'predictions', 'TEST_TOKEN', [], [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '456'], ['key' => 'status', 'value' => 'RESOLVED'], ['key' => 'winning_outcome_id', 'value' => '1']])->willReturn($request);
        $this->endPrediction('TEST_TOKEN', '123', '456', 'RESOLVED', '1')->shouldBe($response);
    }
}
