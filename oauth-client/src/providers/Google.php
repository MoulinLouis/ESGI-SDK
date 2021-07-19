<?php

class Google extends Provider
{

    public function __construct(string $client_id, string $client_secret, string $redirect_uri, array $options = [])
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $options);
        $this->access_token_url = URL_GOOGLE_ACCESS_TOKEN;
        $this->auth_url = URL_GOOGLE_AUTH;
        $this->api_url = URL_GOOGLE_API;
    }

    public function getUser(string $code)
    {
        $access_token = $this->getAccessToken($code, true);
        $result = httpRequest($this->api_url, createStreamContext('GET', "Authorization: Bearer ${access_token}"));
        if ($result['error']) die("Votre token d'accès n'est pas valide ou l'URL est inaccessible");

        return [
            'id' => $result['id'],
            'name' => $result['name'],
            'email' => $result['email']
        ];
    }
}
