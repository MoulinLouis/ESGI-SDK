# ESGI-SDK

ESGI-SDK is a project carried out in the 3rd year of a Bachelor's degree in Web Engineering

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/MoulinLouis/ESGI-SDK/blob/master/LICENSE)

---

It provides a base for integrating with Oauth 2.0 service providers like Google, Facebook or Github.

# Base Provider

These providers are handled by the app :

* [Facebook](https://developers.facebook.com/)
* [Google](https://developers.google.com/identity/protocols/oauth2)
* [Github](https://docs.github.com/en/developers/apps/building-oauth-apps/authorizing-oauth-apps)
* [Karl](https://github.com/kmarques) 's app

# Usage

```sh
git clone https://github.com/MoulinLouis/ESGI-SDK.git
```

Setup the docker-compose.yml as you need

```sh
docker-compose up-d
```

Go to [https://localhost](https://localhost) (by default)

# Implement new providers

Add credentials on the .env file
```
SOMEPROVIDER_CLIENT_ID=
SOMEPROVIDER_SECRET=
```

Add the urls of your provider on the constant.php file (oauth-client/src/includes/)
```php
const URL_SOMEPROVIDER_AUTH = '';
const URL_SOMEPROVIDER_ACCESS_TOKEN = '';
const URL_SOMEPROVIDER_API = '';
```

Create a class named as your new provider (oauth-client/src/providers/)
```php
class SomeProvider extends Provider
{
    public function __construct(string $client_id, string $client_secret, string $redirect_uri, array $options = [])
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $options);
        $this->access_token_url = URL_SOMEPROVIDER_ACCESS_TOKEN;
        $this->auth_url = URL_SOMEPROVIDER_AUTH;
        $this->api_url = URL_SOMEPROVIDER_API;
    }
}
```

Edit index.php to add the link to the new provider (oauth-client/src/)
```php
function getAllProviders()
{
    $redirect_uri = 'https://localhost/auth';
    return [
         // ...
        'someprovider' => [
            'link_label' => 'Login with SomeProvider',
            'instance' => new SomeProvider(
            SOMEPROVIDER_CLIENT_ID, 
            SOMEPROVIDER_SECRET, 
            "${redirect_uri}?provider=someprovider")
        ],
        // ..
    ];
}
```

# Contributors

* **Louis Moulin** - *Travail Initial* - [MoulinLouis](https://github.com/MoulinLouis)
* **Mahery** - *Travail Initial* - [maheryy](https://github.com/maheryy)