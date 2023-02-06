# Fortnox provider for league/oauth2-client

This is a package to integrate [Fortnox](https://developer.fortnox.se/general/authentication/) authentication with the OAuth2 client library by [The League of Extraordinary Packages](https://github.com/thephpleague/oauth2-client).


## Installation

```bash
composer require codepeak/oauth2-fortnox
```

## Usage

### Create instance of the provider

```php
$provider = new \Codepeak\OAuth2\Client\Provider\Fortnox([
    'clientId' => "YOUR_CLIENT_ID",
    'clientSecret' => "YOUR_CLIENT_SECRET",
    'redirectUri' => "http://your-redirect-uri"
]);
```

### Get authorization URL

```php
$authorizationUrl = $provider->getAuthorizationUrl();
```

### Get the access token

```php
$token = $this->provider->getAccessToken("authorizaton_code", [
    'code' => $_GET['code']
]);
```
