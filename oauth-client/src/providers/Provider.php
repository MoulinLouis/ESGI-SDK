<?php

abstract class Provider
{
    protected $client_id;
    protected $client_secret;
    protected $auth_url;
    protected $api_url;
    protected $access_token_url;
    protected $redirect_uri;
    protected $scope;

    abstract public function getUser(string $code);

    protected function __construct(string $client_id, string $client_secret, string $redirect_uri, string $scope = null)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
        $this->scope = $scope;
    }

    public function getAccessToken(string $code, $is_post = false)
    {
        $context = $is_post ? createStreamContext('POST', ['Content-Type: application/x-www-form-urlencoded', 'Content-Length: 0']) : null;
        $url = makeUrl($this->access_token_url, [
            'code' => $code,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
            'grant_type' => 'authorization_code',
        ]);

        return httpRequest($url, $context)['access_token'];
    }

    public function getCodeResponseUrl()
    {
        return makeUrl($this->auth_url, [
            'response_type' => 'code',
            'scope' => !empty($this->scope) ? $this->scope : '',
            'redirect_uri' => $this->redirect_uri,
            'client_id' => $this->client_id,
        ]);
    }
}
