<?php

namespace Codepeak\OAuth2\Client\Provider;

use Codepeak\OAuth2\Client\OptionProvider\FortnoxOptionProvider;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Fortnox extends AbstractProvider
{
    public function __construct(array $options = [], array $collaborators = [])
    {
        $this->fillProperties($options);

        $collaborators['optionProvider'] = new FortnoxOptionProvider(
            base64_encode($this->clientId . ':' . $this->clientSecret)
        );

        parent::__construct($options, $collaborators);
    }

    public function getBaseAuthorizationUrl(): string
    {
        return 'https://apps.fortnox.se/oauth-v1/auth';
    }

    public function getBaseAccessTokenUrl(array $params): string
    {
        return 'https://apps.fortnox.se/oauth-v1/token';
    }

    /**
     * Returns the string that should be used to separate scopes when building
     * the URL for requesting an access token.
     *
     * @return string Scope separator
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }

    protected function getAuthorizationParameters(array $options)
    {
        $options = parent::getAuthorizationParameters($options);

        // Add offline access type
        if (! isset($options['access_type'])) {
            $options['access_type'] = 'offline';
        }

        // Remove approval_prompt since Fortnox forces approval
        unset($options['approval_prompt']);

        return $options;
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return '';
    }

    protected function getDefaultScopes()
    {
        return [];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode >= 400) {
            $message = $response->getReasonPhrase();
            if (isset($data['error_description'])) {
                $message = $data['error_description'];
            }
            throw new IdentityProviderException(
                $message,
                $statusCode,
                $response
            );
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
    }

    protected function getAuthorizationHeaders($token = null)
    {
        return ['Authorization' => "Bearer {$token}"];
    }
}
