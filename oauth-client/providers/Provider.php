<?php

abstract class Provider
{
    protected $base_url;
    protected $url_access_token;
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;
    protected $scope;

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, string $scope = '')
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
        $this->scope = $scope;
    }

    protected function setAccessToken(string $url_access_token)
    {
        $this->url_access_token = $url_access_token;
    }

    protected function setBaseUrl(string $base_url)
    {
        $this->base_url = $base_url;
    }

    protected function getAccessToken(string $code)
    {
        $url = null;
        if($this->url_access_token) {
            $url = makeUrl($this->url_access_token, [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_id,
                'code' => $code,
                'redirect_uri' => $this->client_id,
                'grant_type' => 'authorization_code',
            ]);
        }

        return $url ? request($url)['access_token'] : null;
    }

}
