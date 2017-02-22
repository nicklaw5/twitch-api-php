<?php

use PHPUnit\Framework\TestCase;
use TwitchApi\TwitchApi;
use TwitchApi\Exceptions\ClientIdRequiredException;
use TwitchApi\Exceptions\UnsupportedApiVersionException;

class TwitchApiTest extends TestCase
{
    public function testCanCreateClassWithMinimumOptions()
    {
        $twitchApi = new TwitchApi(['client_id' => 'CLIENT-ID']);
        $this->assertInstanceOf(TwitchApi::class, $twitchApi);
    }

    public function testCreateClassWithoutClientIdThrowsException()
    {
        $this->expectException(ClientIdRequiredException::class);
        $twitchApi = new TwitchApi([]);
    }

    public function testDefaultClassProperties()
    {
        $twitchApi = new TwitchApi(['client_id' => 'CLIENT-ID']);
        $this->assertEmpty($twitchApi->getScope());
        $this->assertNotEmpty($twitchApi->getClientId());
        $this->assertEmpty($twitchApi->getRedirectUri());
        $this->assertEmpty($twitchApi->getClientSecret());
        $this->assertEquals($twitchApi->getApiVersion(), $twitchApi->getDefaultApiVersion());
    }

    public function testCanCreateClassWithValidOptions()
    {
        $options = [
            'client_id' => 'CLIENT_ID',
            'client_secret' => 'CLIENT_SECRET',
            'redirect_uri' => 'REDIRECT_URI',
            'api_version' => 3,
            'scope' => ['user_read'],
        ];
        $twitchApi = new TwitchApi($options);
        $this->assertEquals($twitchApi->getClientId(), $options['client_id']);
        $this->assertEquals($twitchApi->getClientSecret(), $options['client_secret']);
        $this->assertEquals($twitchApi->getRedirectUri(), $options['redirect_uri']);
        $this->assertEquals($twitchApi->getApiVersion(), $options['api_version']);
        $this->assertEquals($twitchApi->getScope(), $options['scope']);
    }

    public function testApiVersionDefaultsTo5IfNotSpecificallySet()
    {
        $options = [
            'client_id' => 'CLIENT_ID',
            'api_version' => 5,
        ];
        $twitchApi = new TwitchApi($options);
        $this->assertEquals($twitchApi->getApiVersion(), 5);
    }

    public function testExceptionIsThrownIfApiVersionISNotSupported()
    {
        $this->expectException(UnsupportedApiVersionException::class);
        $options = [
            'client_id' => 'CLIENT_ID',
            'api_version' => 99,
        ];
        $twitchApi = new TwitchApi($options);
        $this->assertEquals($twitchApi->getApiVersion(), 5);
    }
}
