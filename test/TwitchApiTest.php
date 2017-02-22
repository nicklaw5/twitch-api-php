<?php

use TwitchApi\TwitchApi;
use PHPUnit\Framework\TestCase;

class TwitchApiTest extends TestCase
{
    public function testCanCreateBasicClass()
    {
        $twitchApi = new TwitchApi(['client_id' => 'CLIENT-ID']);
        $this->assertInstanceOf(TwitchApi::class, $twitchApi);
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
}
