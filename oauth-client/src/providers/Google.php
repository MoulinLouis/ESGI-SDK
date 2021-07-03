<?php

class Google extends Provider
{

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, string $scope = '')
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $scope);
        $this->access_token_url = URL_GOOGLE_ACCESS_TOKEN;
        $this->auth_url = URL_GOOGLE_AUTH;
        $this->api_url = URL_GOOGLE_API;
    }

    public function getUser(string $code)
    {
        $access_token = $this->getAccessToken($code, true);
        return $access_token ? httpRequest($this->api_url, createStreamContext('GET', "Authorization: Bearer ${access_token}")) : null;
    }
}
