<?php

class App extends Provider
{

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, string $scope = '')
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $scope);
        $this->access_token_url = URL_APP_ACCESS_TOKEN;
        $this->auth_url = URL_APP_AUTH;
        $this->api_url = URL_APP_API;
    }

    public function getUser(string $code)
    {
    }
}
