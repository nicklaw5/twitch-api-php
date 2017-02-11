## Get User

#### Supported API Versions
v3, v4 & v5

#### v3 & v4 Example
```php
$options = [
    'client_id' => 'YOUR-CLIENT-ID',
    'api_version' => 3, // or 4
];

$twitchApi = new \TwitchApi\TwitchApi($options);
$user = $twitchApi->getUser('summit1g');
```

#### v5 Example
```php
$options = [
    'client_id' => 'YOUR-CLIENT-ID',
];

$twitchApi = new \TwitchApi\TwitchApi($options);
$user = $twitchApi->getUser(26490481);
```
