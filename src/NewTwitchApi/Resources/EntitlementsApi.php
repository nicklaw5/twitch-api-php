<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class EntitlementsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#create-entitlement-grants-upload-url
     */
    public function getEntitlementGrantsUploadURL(string $bearer, string $manifestId, string $type = 'bulk_drops_grant'): ResponseInterface
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
