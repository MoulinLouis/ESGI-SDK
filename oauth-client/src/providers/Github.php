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
        $params = [
            'code' => $code,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri
        ];
        $url = makeUrl($this->access_token_url, $params);
        return httpRequestCurl($url)["access_token"];
    }

    public function getUser(string $code)
    {
        $access_token = $this->getAccessToken($code, true);
        return $access_token ? httpRequest($this->api_url, createStreamContext('GET', ["Authorization: Bearer ${access_token}", "User-Agent: esgi-sdk"])) : false;
    }
}
