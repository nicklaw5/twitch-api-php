<?php

namespace spec\NewTwitchApi\Auth;

use GuzzleHttp\Psr7\Uri;
use PhpSpec\ObjectBehavior;

class AuthGuzzleClientSpec extends ObjectBehavior
{
    function it_should_have_correct_base_uri()
    {
        /** @var Uri $uri */
        $uri = $this->getConfig('base_uri');
        $uri->getScheme()->shouldBe('https');
        $uri->getHost()->shouldBe('id.twitch.tv');
        $uri->getPath()->shouldBe('/oauth2/');
    }

    function it_should_have_passed_in_config_params_instead_of_defaults()
    {
        $this->beConstructedWith(['base_uri' => 'https://different.url']);
        $this->getConfig('base_uri')->getHost()->shouldBe('different.url');
    }
}
