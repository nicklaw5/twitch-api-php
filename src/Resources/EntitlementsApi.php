<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class EntitlementsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#create-entitlement-grants-upload-url
     */
    public function createEntitlementGrantsUploadURL(string $bearer, string $manifestId, string $type = 'bulk_drops_grant'): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'manifest_id', 'value' => $manifestId];
        $queryParamsMap[] = ['key' => 'type', 'value' => $type];

        return $this->postApi('entitlements/upload', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-code-status
     */
    public function getCodeStatus(string $bearer, int $userId, array $codes = []): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];

        foreach ($codes as $code) {
            $queryParamsMap[] = ['key' => 'code', 'value' => $code];
        }

        return $this->getApi('entitlements/codes', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-drops-entitlements
     */
    public function getDropsEntitlements(string $bearer, string $id = null, string $userId = null, string $gameId = null, string $after = null, int $first = null): ResponseInterface
    {
        $queryParamsMap = [];

        if ($id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }

        if ($userId) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];
        }

        if ($gameId) {
            $queryParamsMap[] = ['key' => 'game_id', 'value' => $gameId];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        return $this->getApi('entitlements/drops', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#update-drops-entitlements
     */
    public function updateDropsEntitlements(string $bearer, array $entitlement_ids = null, string $fulfillment_status = null): ResponseInterface
    {
        $bodyParamsMap = [];

        $bodyParamsMap[] = ['key' => 'entitlement_ids', 'value' => $entitlement_ids];
        $bodyParamsMap[] = ['key' => 'fulfillment_status', 'value' => $fulfillment_status];

        return $this->patchApi('entitlements/drops', $bearer, [], $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#redeem-code
     */
    public function redeemCode(string $bearer, int $userId, array $codes = []): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];

        foreach ($codes as $code) {
            $queryParamsMap[] = ['key' => 'code', 'value' => $code];
        }

        return $this->postApi('entitlements/code', $bearer, $queryParamsMap);
    }
}
