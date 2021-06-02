<?php

namespace spec\NewTwitchApi;

use NewTwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class HelixGuzzleClientSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient)
    {
        $this->beConstructedWith('TEST_CLIENT_ID');
    }

    function it_should_have_correct_base_uri()
    {
        $this->shouldHaveType('\NewTwitchApi\HelixGuzzleClient');

        /** @var Uri $uri */
        $uri = $this->getConfig('base_uri');
        $uri->getScheme()->shouldBe('https');
        $uri->getHost()->shouldBe('api.twitch.tv');
        $uri->getPath()->shouldBe('/helix/');
    }

    function it_should_have_client_id_header()
    {
        $this->shouldHaveType('\NewTwitchApi\HelixGuzzleClient');
        $this->getConfig('headers')->shouldHaveKeyWithValue('Client-ID', 'TEST_CLIENT_ID');
    }

    function it_should_have_json_content_type_header()
    {

        $this->shouldHaveType('\NewTwitchApi\HelixGuzzleClient');
        $this->getConfig('headers')->shouldHaveKeyWithValue('Content-Type', 'application/json');
    }

    function it_should_have_passed_in_config_params_instead_of_defaults()
    {
        $this->beConstructedWith('TEST_CLIENT_ID', ['base_uri' => 'https://different.url']);
        $this->shouldHaveType('\NewTwitchApi\HelixGuzzleClient');
        $this->getConfig('base_uri')->getHost()->shouldBe('different.url');
    }
}
