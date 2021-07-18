<?php

class Github extends Provider
{

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, array $options = [], string $app_name = "")
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $options, $app_name);
        $this->access_token_url = URL_GITHUB_ACCESS_TOKEN;
        $this->auth_url = URL_GITHUB_AUTH;
        $this->api_url = URL_GITHUB_API;
    }

    public function getUser(string $code)
    {
        $access_token = $this->getAccessToken($code, true);
        $result = $access_token ? httpRequest($this->api_url, createStreamContext('GET', ["Authorization: Bearer ${access_token}", "User-Agent: $this->app_name"])) : false;
        return [
            'id' => $result['id'],
            'name' => $result['login'],
            'email' => $result['email']
        ];
    }
}
