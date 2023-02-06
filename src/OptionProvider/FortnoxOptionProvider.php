<?php

namespace Codepeak\OAuth2\Client\OptionProvider;

use League\OAuth2\Client\OptionProvider\PostAuthOptionProvider;

class FortnoxOptionProvider extends PostAuthOptionProvider
{
    protected string $base64AuthString = '';

    public function __construct(string $base64AuthString = '')
    {
        $this->base64AuthString = $base64AuthString;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessTokenOptions($method, array $params)
    {
        $options = parent::getAccessTokenOptions($method, $params);

        $options['headers']['Authorization'] = 'Basic ' . $this->base64AuthString;

        return $options;
    }
}
