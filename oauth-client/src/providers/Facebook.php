<?php

class Facebook extends Provider
{

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, string $scope = null)
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $scope);
        $this->access_token_url = URL_FB_ACCESS_TOKEN;
        $this->auth_url = URL_FB_AUTH;
        $this->api_url = URL_FB_API;
    }

    public function getUser(string $code)
    {
        $access_token = $this->getAccessToken($code);
        return $access_token ? httpRequest("{$this->api_url}/me?fields=id,name,email", createStreamContext('GET', "Authorization: Bearer ${access_token}")) : null;
    }
}
