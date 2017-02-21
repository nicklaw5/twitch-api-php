# twitch-api-php

A Twitch API client for PHP.

## Supported APIs

This library aims to support `v3`, `v4` and `v5` of the Twitch API until each one becomes [deprecated](https://dev.twitch.tv/docs#which-api-version-can-you-use). If an API version is not specified, `v5` will be used as the default.

## Features Completed

**Main API Endpoints:**
- [x] Authentication
- [x] Channel Feed
- [x] Channels
- [x] Chat
- [x] Clips
- [x] Communities
- [x] Games
- [x] Ingests
- [x] Search
- [x] Streams
- [x] Teams
- [x] Users
- [x] Videos

Any endpoints missing? Open an [issue here](https://github.com/nicklaw5/twitch-api-php/issues).

**Other Features:**
- [ ] IRC Client
- [ ] Pub/Sub (ie. Bits & Whispers)
- [ ] Video Upload

**Additional Integrations:**
- [ ] [StreamsLabs:](https://twitchalerts.readme.io/docs/getting-started)
  - [ ] Alerts
  - [ ] Authentication
  - [ ] Donations
  - [ ] Users

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

## Installation

Either pull in the library via composer:
```bash
$ composer require nicklaw5/twitch-api-php

```
or add the following dependency to your `composer.json` file:
```json
"nicklaw5/twitch-api-php": "0.1.*"
```

## Documentation

The API docs for each version can be found in their respective locations:

- v3 docs can be found [here](https://dev.twitch.tv/docs/v3).
- v4 was not officially documented by the Twicth staff. Mostly it incorporates the v3 API, but some documentation for the [Clips API](https://dev.twitch.tv/docs/v5/guides/clips-discovery/), for example, can be found on Twitch's developer website.
- v5 docs can be found on the [Twitch's developer website](https://dev.twitch.tv/docs/).

As for the documentation of this library, that is still on the to-do list. In the meantime, most modern IDEs by default or through the use of plugins, will provide class property and method auto-completion. Or you can simple look through the [source](src) code.

## License

Distributed under the [MIT](LICENSE) license.
