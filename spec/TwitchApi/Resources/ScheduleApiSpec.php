<?php

namespace spec\TwitchApi\Resources;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use TwitchApi\RequestGenerator;
use TwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class ScheduleApiSpec extends ObjectBehavior
{
    function let(HelixGuzzleClient $guzzleClient, RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $this->beConstructedWith($guzzleClient, $requestGenerator);
        $guzzleClient->send($request)->willReturn($response);
    }

    function it_should_get_channel_stream_schedule(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'schedule', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getChannelStreamSchedule('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_get_channel_stream_schedule_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'schedule', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'start_time', 'value' => '2021-06-15T23:08:20+00:00'], ['key' => 'utc_offset', 'value' => '240'], ['key' => 'first', 'value' => 25], ['key' => 'after', 'value' => 'abc']], [])->willReturn($request);
        $this->getChannelStreamSchedule('TEST_TOKEN', '123', [], '2021-06-15T23:08:20+00:00', '240', 25, 'abc')->shouldBe($response);
    }

    function it_should_get_a_channel_stream_schedule(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'schedule', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '456']], [])->willReturn($request);
        $this->getChannelStreamSchedule('TEST_TOKEN', '123', ['456'])->shouldBe($response);
    }

    function it_should_get_multiple_channel_stream_schedules(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'schedule', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '456'], ['key' => 'id', 'value' => '789']], [])->willReturn($request);
        $this->getChannelStreamSchedule('TEST_TOKEN', '123', ['456', '789'])->shouldBe($response);
    }

    function it_should_get_channel_icalendar_with_no_auth(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'schedule/icalendar', null, [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getChanneliCalendar(null, '123')->shouldBe($response);
    }

    function it_should_get_channel_icalendar_with_auth(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('GET', 'schedule/icalendar', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [])->willReturn($request);
        $this->getChanneliCalendar('TEST_TOKEN', '123')->shouldBe($response);
    }

    function it_should_update_channel_stream_schedule(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'schedule/settings', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'is_vacation_enabled', 'value' => true], ['key' => 'vacation_start_time', 'value' => '2021-06-15T23:08:20+00:00'], ['key' => 'vacation_end_time', 'value' => '2021-06-22T23:08:20+00:00'], ['key' => 'timezone', 'value' => 'America/New_York']], [])->willReturn($request);
        $this->updateChannelStreamSchedule('TEST_TOKEN', '123', true, '2021-06-15T23:08:20+00:00', '2021-06-22T23:08:20+00:00', 'America/New_York')->shouldBe($response);
    }

    function it_should_create_channel_stream_schedule_segment(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'schedule/segment', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'start_time', 'value' => '2021-06-15T23:08:20+00:00'], ['key' => 'timezone', 'value' => 'America/New_York'], ['key' => 'is_recurring', 'value' => true]])->willReturn($request);
        $this->createChannelStreamScheduleSegment('TEST_TOKEN', '123', '2021-06-15T23:08:20+00:00', 'America/New_York', true)->shouldBe($response);
    }

    function it_should_create_channel_stream_schedule_segment_with_opts(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('POST', 'schedule/segment', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123']], [['key' => 'start_time', 'value' => '2021-06-15T23:08:20+00:00'], ['key' => 'timezone', 'value' => 'America/New_York'], ['key' => 'is_recurring', 'value' => true], ['key' => 'duration', 'value' => '240']])->willReturn($request);
        $this->createChannelStreamScheduleSegment('TEST_TOKEN', '123', '2021-06-15T23:08:20+00:00', 'America/New_York', true, ['duration' => '240'])->shouldBe($response);
    }

    function it_should_update_channel_stream_schedule_segment(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('PATCH', 'schedule/segment', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '456']], [['key' => 'start_time', 'value' => '2021-06-15T23:08:20+00:00'], ['key' => 'timezone', 'value' => 'America/New_York'], ['key' => 'is_canceled', 'value' => true], ['key' => 'duration', 'value' => '240']])->willReturn($request);
        $this->updateChannelStreamScheduleSegment('TEST_TOKEN', '123', '456', ['start_time' => '2021-06-15T23:08:20+00:00', 'timezone' => 'America/New_York', 'is_canceled' => true, 'duration' => '240'])->shouldBe($response);
    }

    function it_should_delete_channel_stream_schedule_segment(RequestGenerator $requestGenerator, Request $request, Response $response)
    {
        $requestGenerator->generate('DELETE', 'schedule/segment', 'TEST_TOKEN', [['key' => 'broadcaster_id', 'value' => '123'], ['key' => 'id', 'value' => '456']], [])->willReturn($request);
        $this->deleteChannelStreamScheduleSegment('TEST_TOKEN', '123', '456')->shouldBe($response);
    }
}
