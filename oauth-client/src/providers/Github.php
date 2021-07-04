<?php

class Github extends Provider
{

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, array $options = [])
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $options);
        $this->access_token_url = URL_GITHUB_ACCESS_TOKEN;
        $this->auth_url = URL_GITHUB_AUTH;
        $this->api_url = URL_GITHUB_API;
    }

    public function getUser(string $code)
    {
    }
}