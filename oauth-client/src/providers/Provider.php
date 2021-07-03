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

    protected function __construct(string $client_id, string $client_secret, string $redirect_uri, string $scope)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
        $this->scope = $scope;
    }

    /**
     * Fetch user data from the provider's API
     *
     * @param string $code authorization code received from OAuth process
     * @return array|null
     */
    abstract public function getUser(string $code);

    /**
     * Request the access token with the authorization code received
     *
     * @param string $code authorization code
     * @param bool $is_post POST or GET request
     * @return array|null
     */
    protected function getAccessToken(string $code, bool $is_post = false)
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

    /**
     * Generate link for authentification/authorization
     *
     * @return string
     */
    public function getAuthorizationUrl()
    {
        return makeUrl($this->auth_url, [
            'response_type' => 'code',
            'scope' => $this->scope,
            'redirect_uri' => $this->redirect_uri,
            'client_id' => $this->client_id,
        ]);
    }
}
