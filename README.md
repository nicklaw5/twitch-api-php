# twitch-api-php

# New Twitch API (Helix)

A New Twitch API (Helix) client for PHP. The code for the new API is all contained within `src/NewApi/`. This is because the New API code is meant to be separate from the old Kraken API code, such that in the future, when Kraken is no longer available, the old Kraken code can be removed without affecting the new API code. Additionally, keeping them separate allows for existing code using the Kraken part of this library to continue to function, untouched by the new code.

The New Twitch API client is still being developed and is currently incomplete. The endpoints that are implemented are usable, but not all endpoints have been implemented yet. If an endpoint you need is missing, incomplete, or not working correctly, please report it or fix it if you can and create a PR for it.

## Usage

Everything stems from the `NewTwitchApi` class. However, if you want to individually instantiate `UsersApi`, `OauthApi`, etc. you are free to do so.

The API calls generally return an object implementing `ResponseInterface`. Since you are getting the full `Response` object, you'll need to handle its contents, e.g. by decoding then into an object with `json_decode()`. This library does not assume this is what you want to do, so it does not do this for you automatically. This library simply acts as a middleman between your code and Twitch, providing you with the raw responses the Twitch API returns.

The individual API classes that can be called from `NewTwitchApi` correspond to the [New Twitch API documentation](https://dev.twitch.tv/docs/api/). `OauthApi` is for Oauth calls. `WebhooksSubscriptionApi` is for subscribing/unsubscribing to webhooks. The rest of the API classes are based on the resources listed [here](https://dev.twitch.tv/docs/api/reference/). The methods in the classes generally correspond to the endpoints for each resource. The naming convention was chosen to try and match the Twitch documentation. Each primary endpoint method (not convenience or helper methods) should have an `@link` annotation with a URL to that endpoint's specific documentation.

## Examples

Getting a user's information via their access token:

```php
// Assuming you already have the access token.
$accessToken = 'the token';

// The Guzzle client used can be the included `HelixGuzzleClient` class, for convenience. 
// You can also use a mock, fake, or other double for testing, of course.
$helixGuzzleClient = new HelixGuzzleClient($clientId);

// Instantiate NewTwitchApi. Can be done in a service layer and injected as well.
$newTwitchApi = new NewTwitchApi($helixGuzzleClient, $clientId, $clientSecret);

try {
    // Make the API call. A ResponseInterface object is returned.
    $response = $newTwitchApi->getUsersApi()->getUserByAccessToken($accessToken);
    
    // Get and decode the actual content sent by Twitch.
    $responseContent = json_decode($response->getBody()->getContents());
    
    // Return the first (or only) user.
    return $responseContent->data[0];
} catch (GuzzleException $e) {
    // Handle error appropriately for your application
}
```

## Developer Tools

### PHP Coding Standards Fixer

[PHP Coding Standards Fixer](https://cs.sensiolabs.org/) (`php-cs-fixer`) has been added, specifically for the New Twitch API code. A configuration file for it can be found in `.php_cs.dist`. The ruleset is left at default (PSR-2 at this time). The configuration file mostly just limits it's scope to only the New Twitch API code.

You can run the fixer with `vendor/bin/php-cs-fixer fix`. However, the easiest way to run the fixer is with the provided git hook.

### Git pre-commit Hook

In `bin/git/hooks`, you'll find a `pre-commit` hook that you can add to git that will automatically run the `php-cs-fixer` everytime you commit. The result is that, after the commit is made, any changes that fixer has made are left as unstaged changes. You can review them, then add and commit them.

To install the hook, go to `.git/hooks` and `ln -s ../../bin/git/hooks/pre-commit`.

## API Documentation

The New Twitch API docs can be found [here](https://dev.twitch.tv/docs/api/).

## License

Distributed under the [MIT](LICENSE) license.

---
---
---

# Kraken

A Twitch Kraken API client for PHP. This is the old API, which is deprecated and will be deleted soon. Please use Helix instead. If something is missing from the Helix API, please add it or request it.

The documentation below is left for legacy purposes, until Kraken support is removed.

[![Build Status](https://travis-ci.org/nicklaw5/twitch-api-php.svg?branch=master)](https://travis-ci.org/nicklaw5/twitch-api-php)

## Supported APIs

This library aims to support `v3` and `v5` of the Twitch API until each one becomes [deprecated](https://dev.twitch.tv/docs/v5). If an API version is not specified, `v5` will be used as the default.

## Features Completed

**Main API Endpoints:**

- [x] Authentication
- [x] Bits
- [x] Channel Feed
- [x] Channels
- [x] Chat
- [x] Clips
- [x] Collections
- [x] Communities
- [x] Games
- [x] Ingests
- [x] Search
- [x] Streams
- [x] Teams
- [x] Users
- [x] Videos

Any endpoints missing? Open an [issue here](https://github.com/nicklaw5/twitch-api-php/issues).

## Basic Example

```php
$options = [
    'client_id' => 'YOUR-CLIENT-ID',
];

$twitchApi = new \TwitchApi\TwitchApi($options);
$user = $twitchApi->getUser(26490481);

// By default API responses are returned as an array, but if you want the raw JSON instead:
$twitchApi->setReturnJson(true);
$user = $twitchApi->getUser(26490481);

// If you want to switch between API versions on the fly:
$twitchApi->setApiVersion(3);
$user = $twitchApi->getUser('summit1g');
```

See the [examples](examples) directory for more common use cases.

## Requirements

PHP 5.6 or higher is required.

## Installation

Either pull in the library via composer:

```bash
composer require nicklaw5/twitch-api-php

```

or add the following dependency to your `composer.json` file and run `composer install`:

```json
"nicklaw5/twitch-api-php": "~1.0"
```

## Tests

All unit tests can be run with the following command:

```bash
vendor/bin/phpunit # or simply "phpunit" if you have it installed globally
```

## Documentation

The Twitch API docs can be found [here](https://dev.twitch.tv/docs).

As for the documentation of this library, that is still on the to-do list. In the meantime, most modern IDEs by default, or through the use of plugins, will provide class property and method auto-completion. Or you can simple look through the [source](src) code.

## License

Distributed under the [MIT](LICENSE) license.
