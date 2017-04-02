<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\EndpointNotSupportedByApiVersionException;
use TwitchApi\Exceptions\InvalidIdentifierException;
use TwitchApi\Exceptions\InvalidLimitException;
use TwitchApi\Exceptions\InvalidTypeException;
use TwitchApi\Exceptions\TwitchApiException;

trait Collections
{
    /**
     * Get a summary of information about a collection
     *
     * @param string $collectionId
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function getCollectionMetadata($collectionId)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        return $this->get(sprintf('collections/%s', $collectionId));
    }

    /**
     * Gets all items (videos) in specified collection
     *
     * @param string $collectionId
     * @param bool   $includeAllItems
     * @throws EndpointNotSupportedByApiVersionException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function getCollection($collectionId, $includeAllItems = false)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        if (!is_bool($includeAllItems)) {
            throw new InvalidTypeException('Include All Items', 'boolean', gettype($includeAllItems));
        }

        $params = [
            'includeAllItems' => $includeAllItems,
        ];

        return $this->get(sprintf('collections/%s/items', $collectionId), $params);
    }

    /**
     * Get all collections owned by a channel
     *
     * @param int|string $channelIdentifier
     * @param int        $limit
     * @param string     $cursor
     * @param string     $containingItem
     * @throws EndpointNotSupportedByApiVersionException
     * @throws InvalidIdentifierException
     * @throws InvalidLimitException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function getChannelCollection($channelIdentifier, $limit = 10, $cursor = null, $containingItem = null)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        if (!is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if ($cursor && !is_string($cursor)) {
            throw new InvalidTypeException('Cursor', 'string', gettype($cursor));
        }

        if ($containingItem && !is_string($containingItem)) {
            throw new InvalidTypeException('Containing Item', 'string', gettype($containingItem));
        }

        $params = [
            'limit' => intval($limit),
            'cursor' => $cursor,
            'containingItem' => $containingItem,
        ];

        return $this->get(sprintf('channels/%s/collections', $channelIdentifier), $params);
    }

    /**
     * Create a new collection owned a channel
     *
     * @param int|string $channelIdentifier
     * @param string     $title
     * @param string     $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @throws InvalidIdentifierException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function createCollection($channelIdentifier, $title, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        if (!is_numeric($channelIdentifier)) {
            throw new InvalidIdentifierException('channel');
        }

        if (!is_string($title)) {
            throw new InvalidTypeException('Title', 'string', gettype($title));
        }

        $params = [
            'title' => $title,
        ];

        return $this->post(sprintf('channels/%s/collections', $channelIdentifier), $params, $accessToken);
    }

    /**
     * Update a collection
     *
     * @param string $collectionId
     * @param string $title
     * @param string $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @throws InvalidTypeException
     * @return null
     */
    public function updateCollection($collectionId, $title, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        if (!is_string($title)) {
            throw new InvalidTypeException('Title', 'string', gettype($title));
        }

        $params = [
            'title' => $title,
        ];

        return $this->put(sprintf('collections/%s', $collectionId), $params, $accessToken);
    }

    /**
     * Create a collection thumbnail
     *
     * @param string $collectionId
     * @param string $itemId
     * @param string $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @return null
     */
    public function createCollectionThumbnail($collectionId, $itemId, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        if (!is_string($itemId)) {
            throw new InvalidTypeException('Item ID', 'string', gettype($itemId));
        }

        $params = [
            'item_id' => $itemId,
        ];

        return $this->put(sprintf('collections/%s/thumbnail', $collectionId), $params, $accessToken);
    }

    /**
     * Delete a collection
     *
     * @param string $collectionId
     * @param string $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @throws InvalidTypeException
     * @return null
     */
    public function deleteCollection($collectionId, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        return $this->delete(sprintf('collections/%s', $collectionId), [], $accessToken);
    }

    /**
     * Add an item to a collection
     *
     * @param string $collectionId
     * @param string $itemId
     * @param string $itemType
     * @param string $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @throws InvalidTypeException
     * @return array|json
     */
    public function addCollectionItem($collectionId, $itemId, $itemType = 'video', $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        if (!is_string($itemId)) {
            throw new InvalidTypeException('Item ID', 'string', gettype($itemId));
        }

        if (!is_string($itemType)) {
            throw new InvalidTypeException('Item ID', 'string', gettype($itemType));
        }

        $params = [
            'item_id' => $itemId,
            'type' => $itemType,
        ];

        return $this->post(sprintf('collections/%s/items', $collectionId), $params, $accessToken);
    }

    /**
     * Delete an item from a collection
     *
     * @param string $collectionId
     * @param string $itemId
     * @param string $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @throws InvalidTypeException
     * @return null
     */
    public function deleteCollectionItem($collectionId, $itemId, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        if (!is_string($itemId)) {
            throw new InvalidTypeException('Item ID', 'string', gettype($itemId));
        }

        return $this->delete(sprintf('collections/%s/items/%s', $collectionId, $itemId), [], $accessToken);
    }

    /**
     * Move a collection item
     *
     * @param string $collectionId
     * @param string $itemId
     * @param int    $position
     * @param string $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @throws InvalidTypeException
     * @throws TwitchApiException
     * @return null
     */
    public function moveCollectionThumbnail($collectionId, $itemId, $position, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException();
        }

        if (!is_string($itemId)) {
            throw new InvalidTypeException('Item ID', 'string', gettype($itemId));
        }

        if ($position < 1) {
            throw new TwitchApiException('Collection position cannot be less than 1.');
        }

        $params = [
            'position' => $position,
        ];

        return $this->put(sprintf('collections/%s/itmes/%s', $collectionId, $itemId), $params, $accessToken);
    }
}
