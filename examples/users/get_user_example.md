# Get User

## Supported API Versions

v3 & v5

### v3 Example

```php
$options = [
    'client_id' => 'YOUR-CLIENT-ID',
    'api_version' => 3,
];

$twitchApi = new \TwitchApi\TwitchApi($options);
$user = $twitchApi->getUser('summit1g');
```

### v5 Example

```php
$options = [
    'client_id' => 'YOUR-CLIENT-ID',
];

$twitchApi = new \TwitchApi\TwitchApi($options);
$user = $twitchApi->getUser(26490481);
```
