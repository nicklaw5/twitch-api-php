# Twitch API PHP Library

![Packagist Version](https://img.shields.io/packagist/v/nicklaw5/twitch-api-php)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/nicklaw5/twitch-api-php)
![Packagist Downloads](https://img.shields.io/packagist/dt/nicklaw5/twitch-api-php)
![Packagist License](https://img.shields.io/packagist/l/nicklaw5/twitch-api-php)

The Twitch API PHP Library allows you to interact through HTTP to a number of [Twitch API](https://dev.twitch.tv/docs/api/) endpoints. The library does not format the repsonses of your request so you have full flexability in how to handle the data that is returned from the API.

## Documentation & Links

- [Twitch API Documentation](https://dev.twitch.tv/docs/api/)
- [TwitchDev Discord](https://link.twitch.tv/devchat)
- [Twitch Libraries Discord](https://discord.gg/8NXaEyV)

## Getting Started

### Requirements

- PHP 7.4 - The library has been shown to work on earlier versions but we encoruage you to use the latest versions of PHP that are tested with our library. - The requirement will be increased to PHP 8.0 in the future, so you should develop for the latest version of PHP.
- Composer
- `ext-json: *`
- [guzzlehttp/guzzle](https://github.com/guzzle/guzzle) `~6.0|~7.0`

### Installation

The recommended way to install the Twitch API PHP Library is through [Composer](https://getcomposer.org/).

```bash
composer require nicklaw5/twitch-api-php

```

### Example Usage

All calls to the Twitch API require bearer tokens that can be retrieved through the `OauthApi` class. You can review the [types of tokens](https://dev.twitch.tv/docs/authentication/#types-of-tokens) in the Twitch API docs. The below examples store the Client ID, Secret and Scopes directly in the example, but you should not do this. Store your IDs, Secret, and Scopes in a secure place such as your database or environment variables or alternate settings storage. Security of this information is important. Here is an example of how you can retrieve a token for your application:

```php
$twitch_client_id = 'TWITCH_CLIENT_ID';
$twitch_client_secret = 'TWITCH_CLIENT_SECRET';
$twitch_scopes = '';

$helixGuzzleClient = new \NewTwitchApi\HelixGuzzleClient($twitch_client_id);
$newTwitchApi = new \NewTwitchApi\NewTwitchApi($helixGuzzleClient, $twitch_client_id, $twitch_client_secret);
$oauth = $newTwitchApi->getOauthApi();

try {
    $token = $oauth->getAppAccessToken($twitch_scopes ?? '');
    $data = json_decode($token->getBody()->getContents());

    // Your bearer token
    $twitch_access_token = $data->access_token ?? null;
} catch (Exception $e) {
    //TODO: Handle Error
}
```

Here is an example of how you retrieve a users token:

```php
$twitch_client_id = 'TWITCH_CLIENT_ID';
$twitch_client_secret = 'TWITCH_CLIENT_SECRET';
$twitch_scopes = '';

$helixGuzzleClient = new \NewTwitchApi\HelixGuzzleClient($twitch_client_id);
$newTwitchApi = new \NewTwitchApi\NewTwitchApi($helixGuzzleClient, $twitch_client_id, $twitch_client_secret);
$oauth = $newTwitchApi->getOauthApi();

// Get the current URL, we'll use this to redirect them back to exactly where they came from
$currentUri = explode('?', 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0];

if ($code == '') {
    // Generate the Oauth Uri
    $oauthUri = $oauth->getAuthUrl($currentUri, 'code', $twitch_scopes);
    // Redirect them as there was no auth code
    header("Location: {$oauthUri}");
} else {
    try {
        $token = $oauth->getUserAccessToken($code, $currentUri);
        // It is a good practice to check the status code when they've responded, this really is optional though
        if ($token->getStatusCode() == 200) {
            // Below is the returned token data
            $data = json_decode($token->getBody()->getContents());

            // Your bearer token
            $twitch_access_token = $data->access_token ?? null;

            // The scopes from the API
            $twitch_scopes = $data->scope;
        } else {
            //TODO: Handle Error
        }
    } catch (Exception $e) {
        //TODO: Handle Error
    }
}
```

When you have a user token that is expired, you're able to refresh it instead of requiring them to authenticate again. Here is an example of how you refresh a users token:

```php
$twitch_client_id = 'TWITCH_CLIENT_ID';
$twitch_client_secret = 'TWITCH_CLIENT_SECRET';
$twitch_scopes = '';
$user_refresh_token = 'REFRESH_TOKEN';

$helixGuzzleClient = new \NewTwitchApi\HelixGuzzleClient($twitch_client_id);
$newTwitchApi = new \NewTwitchApi\NewTwitchApi($helixGuzzleClient, $twitch_client_id, $twitch_client_secret);
$oauth = $newTwitchApi->getOauthApi();

try {
    $token = $oauth->getAppAccessToken($twitch_scopes ?? '');
    $data = json_decode($token->getBody()->getContents());

    // Your bearer token
    $twitch_access_token = $data->access_token ?? null;

    // The scopes from the API
    $twitch_scopes = $data->scope;
} catch (Exception $e) {
    //TODO: Handle Error
}
```

### Usage of the API Classes

Everything stems from the `NewTwitchApi` class. However, if you want to individually instantiate `UsersApi`, `OauthApi`, etc. you are free to do so.

The API calls generally return an object implementing `ResponseInterface`. Since you are getting the full `Response` object, you'll need to handle its contents, e.g. by decoding then into an object with `json_decode()`. This library does not assume this is what you want to do, so it does not do this for you automatically. This library simply acts as a middleman between your code and Twitch, providing you with the raw responses the Twitch API returns.

The individual API classes that can be called from `NewTwitchApi` correspond to the [Twitch API documentation](https://dev.twitch.tv/docs/api/). The rest of the API classes are based on the resources listed [here](https://dev.twitch.tv/docs/api/reference/). The methods in the classes generally correspond to the endpoints for each resource. The naming convention was chosen to try and match the Twitch documentation. Each primary endpoint method (not convenience or helper methods) should have an `@link` annotation with a URL to that endpoint's specific documentation.

Here is a sample of retrieving a users table from their access token:

```php
$twitch_client_id = 'TWITCH_CLIENT_ID';
$twitch_client_secret = 'TWITCH_CLIENT_SECRET';
// Assuming you already have the access token - see above
$twitch_access_token = 'the token';

// The Guzzle client used can be the included `HelixGuzzleClient` class, for convenience.
// You can also use a mock, fake, or other double for testing, of course.
$helixGuzzleClient = new HelixGuzzleClient($twitch_client_id);

// Instantiate NewTwitchApi. Can be done in a service layer and injected as well.
$newTwitchApi = new NewTwitchApi($helixGuzzleClient, $twitch_client_id, $twitch_client_secret);

try {
    // Make the API call. A ResponseInterface object is returned.
    $response = $newTwitchApi->getUsersApi()->getUserByAccessToken($twitch_access_token);

    // Get and decode the actual content sent by Twitch.
    $responseContent = json_decode($response->getBody()->getContents());

    // Return the first (or only) user.
    return $responseContent->data[0];
} catch (GuzzleException $e) {
    //TODO: Handle Error
}
```

## Developer Tools

### PHP Coding Standards Fixer

[PHP Coding Standards Fixer](https://cs.sensiolabs.org/) (`php-cs-fixer`) has been added, specifically for the New Twitch API code. A configuration file for it can be found in `.php_cs.dist`. The ruleset is left at default (PSR-2 at this time). The configuration file mostly just limits it's scope to only the New Twitch API code.

You can run the fixer with `vendor/bin/php-cs-fixer fix`. However, the easiest way to run the fixer is with the provided git hook.

### Git pre-commit Hook

In `bin/git/hooks`, you'll find a `pre-commit` hook that you can add to git that will automatically run the `php-cs-fixer` everytime you commit. The result is that, after the commit is made, any changes that fixer has made are left as unstaged changes. You can review them, then add and commit them.

To install the hook, go to `.git/hooks` and `ln -s ../../bin/git/hooks/pre-commit`.

## License

Distributed under the [MIT](LICENSE) license.
