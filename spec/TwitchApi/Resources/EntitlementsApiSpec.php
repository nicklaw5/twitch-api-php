<?php

namespace spec\TwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use TwitchApi\RequestGenerator;
use TwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class EntitlementsApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_create_entitlement_grants_upload_url(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'entitlements/upload', 'TEST_TOKEN', [['key' => 'manifest_id', 'value' => '123'], ['key' => 'type', 'value' => 'bulk_drops_grant']], [])->willReturn($request);
        $this->createEntitlementGrantsUploadURL('TEST_TOKEN', '123', 'bulk_drops_grant')->shouldBe($response);
    }

    function it_should_create_entitlement_grants_upload_url_shorthand(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'entitlements/upload', 'TEST_TOKEN', [['key' => 'manifest_id', 'value' => '123'], ['key' => 'type', 'value' => 'bulk_drops_grant']], [])->willReturn($request);
        $this->createEntitlementGrantsUploadURL('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_code_status(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'entitlements/codes', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123'], ['key' => 'code', 'value' => 'abc']], [])->willReturn($request);
        $this->getCodeStatus('TEST_TOKEN', '123', ['abc'])->shouldBe($response);
    }

    function it_should_get_codes_status(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'entitlements/codes', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123'], ['key' => 'code', 'value' => 'abc'], ['key' => 'code', 'value' => 'def']], [])->willReturn($request);
        $this->getCodeStatus('TEST_TOKEN', '123', ['abc', 'def'])->shouldBe($response);
    }

    function it_should_get_drop_entitlements_by_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'entitlements/drops', 'TEST_TOKEN', [['key' => 'id', 'value' => '123']], [])->willReturn($request);
        $this->getDropsEntitlements('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_drop_entitlements_by_user_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'entitlements/drops', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123']], [])->willReturn($request);
        $this->getDropsEntitlements('TEST_TOKEN', null, '123')->shouldBe($response);
    }

    function it_should_get_drop_entitlements_by_user_id_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'entitlements/drops', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123'], ['key' => 'after', 'value' => 'abc'], ['key' => 'first', 'value' => 100]], [])->willReturn($request);
        $this->getDropsEntitlements('TEST_TOKEN', null, '123', null, 'abc', 100)->shouldBe($response);
    }

    function it_should_get_drop_entitlements_by_game_id(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'entitlements/drops', 'TEST_TOKEN', [['key' => 'game_id', 'value' => '123']], [])->willReturn($request);
        $this->getDropsEntitlements('TEST_TOKEN', null, null, '123')->shouldBe($response);
    }

    function it_should_get_drop_entitlements_by_game_id_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'entitlements/drops', 'TEST_TOKEN', [['key' => 'game_id', 'value' => '123'], ['key' => 'after', 'value' => 'abc'], ['key' => 'first', 'value' => 100]], [])->willReturn($request);
        $this->getDropsEntitlements('TEST_TOKEN', null, null, '123', 'abc', 100)->shouldBe($response);
    }

    function it_should_get_drop_entitlements_by_status(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'entitlements/drops', 'TEST_TOKEN', [['key' => 'fulfillment_status', 'value' => 'CLAIMED']], [])->willReturn($request);
        $this->getDropsEntitlements('TEST_TOKEN', null, null, null, null, null, 'CLAIMED')->shouldBe($response);
    }

    function it_should_redeem_code(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'entitlements/code', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123'], ['key' => 'code', 'value' => 'abc']], [])->willReturn($request);
        $this->redeemCode('TEST_TOKEN', '123', ['abc'])->shouldBe($response);
    }

    function it_should_redeem_codes(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'entitlements/code', 'TEST_TOKEN', [['key' => 'user_id', 'value' => '123'], ['key' => 'code', 'value' => 'abc'], ['key' => 'code', 'value' => 'def']], [])->willReturn($request);
        $this->redeemCode('TEST_TOKEN', '123', ['abc', 'def'])->shouldBe($response);
    }

    function it_should_update_drop_entitlements(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'entitlements/drops', 'TEST_TOKEN', [], [])->willReturn($request);
        $this->updateDropsEntitlements('TEST_TOKEN')->shouldBe($response);
    }

    function it_should_update_one_drop_entitlements(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'entitlements/drops', 'TEST_TOKEN', [], [['key' => 'entitlement_ids', 'value' => ['123']], ['key' => 'fulfillment_status', 'value' => 'FULFILLED']])->willReturn($request);
        $this->updateDropsEntitlements('TEST_TOKEN', ['123'], 'FULFILLED')->shouldBe($response);
    }

    function it_should_update_multiple_drop_entitlements(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'entitlements/drops', 'TEST_TOKEN', [], [['key' => 'entitlement_ids', 'value' => ['123', '456']], ['key' => 'fulfillment_status', 'value' => 'FULFILLED']])->willReturn($request);
        $this->updateDropsEntitlements('TEST_TOKEN', ['123', '456'], 'FULFILLED')->shouldBe($response);
    }
}
