<?php

namespace spec\TwitchApi\Auth;

use GuzzleHttp\Psr7\Uri;
use PhpSpec\ObjectBehavior;

class AuthGuzzleClientSpec extends ObjectBehavior
{
    function it_should_have_correct_base_uri()
    {
        $this->beConstructedThrough('getClient');
        $this->shouldHaveType('\GuzzleHttp\Client');

        /** @var Uri $uri */
        $uri = $this->getConfig('base_uri');
        $uri->getScheme()->shouldBe('https');
        $uri->getHost()->shouldBe('id.twitch.tv');
        $uri->getPath()->shouldBe('/oauth2/');
    }

    function it_should_have_passed_in_config_params_instead_of_defaults()
    {
        $this->beConstructedThrough('getClient', [['base_uri' => 'https://different.url']]);
        $this->shouldHaveType('\GuzzleHttp\Client');
        $this->getConfig('base_uri')->getHost()->shouldBe('different.url');
    }
}
