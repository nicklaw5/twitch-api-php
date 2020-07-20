<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class EntitlementsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     */
    public function getEntitlementGrantsUploadURL(string $bearer, string $manifestId, string $type = 'bulk_drops_grant'): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'manifest_id', 'value' => $manifestId];
        $queryParamsMap[] = ['key' => 'type', 'value' => $type];

        return $this->postApi('entitlements/upload', $bearer, $queryParamsMap);
    }
}
