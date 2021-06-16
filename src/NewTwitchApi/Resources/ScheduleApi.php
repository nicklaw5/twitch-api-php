<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ScheduleApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-channel-stream-schedule
     */
    public function getChannelStreamSchedule(string $bearer, string $broadcasterId, array $ids = [], string $startTime = null, string $utcOffset = null, int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }

        if ($startTime) {
            $queryParamsMap[] = ['key' => 'start_time', 'value' => $startTime];
        }

        if ($utcOffset) {
            $queryParamsMap[] = ['key' => 'utc_offset', 'value' => $utcOffset];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->getApi('schedule', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-channel-icalendar
     */
    public function getChanneliCalendar(string $bearer = null, string $broadcasterId): ResponseInterface
    {
        // This endpoint at the time of addition does not require any authorization, so the bearer is null.
        // However, to prevent a breaking update in the future, it will remain the first function parameter.
        // You may simple pass NULL to this to bypass authentication.

        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        return $this->getApiWithOptionalAuth('schedule/icalendar', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#update-channel-stream-schedule
     */
    public function updateChannelStreamSchedule(string $bearer, string $broadcasterId, bool $isVacationEnabled = null, $vacationStartTime = null, $vacationEndTime = null, $timezone = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        if ($isVacationEnabled) {
            $queryParamsMap[] = ['key' => 'is_vacation_enabled', 'value' => $isVacationEnabled];
        }

        if ($vacationStartTime) {
            $queryParamsMap[] = ['key' => 'vacation_start_time', 'value' => $vacationStartTime];
        }

        if ($vacationEndTime) {
            $queryParamsMap[] = ['key' => 'vacation_end_time', 'value' => $vacationEndTime];
        }

        if ($timezone) {
            $queryParamsMap[] = ['key' => 'timezone', 'value' => $timezone];
        }

        return $this->patchApi('schedule/settings', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#create-channel-stream-schedule-segment
     */
    public function createChannelStreamScheduleSegment(string $bearer, string $broadcasterId, string $startTime, string $timezone, bool $isRecurring, array $additionalBodyParams = []): ResponseInterface
    {
        // $additionalBodyParams should be a standard key => value format, eg. ['duration' => '240'];
        $queryParamsMap = $bodyParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        $bodyParamsMap[] = ['key' => 'start_time', 'value' => $startTime];
        $bodyParamsMap[] = ['key' => 'timezone', 'value' => $timezone];
        $bodyParamsMap[] = ['key' => 'is_recurring', 'value' => $isRecurring];

        foreach ($additionalBodyParams as $key => $value) {
            $bodyParamsMap[] = ['key' => $key, 'value' => $value];
        }

        return $this->postApi('schedule/segment', $bearer, $queryParamsMap, $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#update-channel-stream-schedule-segment
     */
    public function updateChannelStreamScheduleSegment(string $bearer, string $broadcasterId, string $segmentId, array $updateValues = []): ResponseInterface
    {
        // $updateValues should be a standard key => value format based on the values available on the documentation, eg. ['duration' => '240'];
        $queryParamsMap = $bodyParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'id', 'value' => $segmentId];

        foreach ($updateValues as $key => $value) {
            $bodyParamsMap[] = ['key' => $key, 'value' => $value];
        }

        return $this->patchApi('schedule/segment', $bearer, $queryParamsMap, $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#delete-channel-stream-schedule-segment
     */
    public function deleteChannelStreamScheduleSegment(string $bearer, string $broadcasterId, string $segmentId): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'id', 'value' => $segmentId];

        return $this->deleteApi('schedule/segment', $bearer, $queryParamsMap);
    }
}
