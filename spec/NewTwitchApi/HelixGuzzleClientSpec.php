<?php

namespace spec\NewTwitchApi;

use GuzzleHttp\Psr7\Uri;
use PhpSpec\ObjectBehavior;

class HelixGuzzleClientSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('client-id');
    }

    function it_should_have_correct_base_uri()
    {
        /** @var Uri $uri */
        $uri = $this->getConfig('base_uri');
        $uri->getScheme()->shouldBe('https');
        $uri->getHost()->shouldBe('api.twitch.tv');
        $uri->getPath()->shouldBe('/helix/');
    }

    function it_should_have_client_id_header()
    {
        $this->getConfig('headers')->shouldHaveKeyWithValue('Client-ID', 'client-id');
    }

    function it_should_have_json_content_type_header()
    {
        $this->getConfig('headers')->shouldHaveKeyWithValue('Content-Type', 'application/json');
    }

    function it_should_have_passed_in_config_params_instead_of_defaults()
    {
        $this->beConstructedWith('client-id', ['base_uri' => 'https://different.url']);
        $this->getConfig('base_uri')->getHost()->shouldBe('different.url');
    }
}
