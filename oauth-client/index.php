<?php

require 'src/includes/constants.php';
require 'src/includes/dotenv.php';
require 'src/helpers/helpers.php';
require 'src/providers/Provider.php';
require 'src/providers/Facebook.php';
require 'src/providers/App.php';
require 'src/providers/Google.php';
require 'src/providers/Github.php';

function handleResponse(Provider $provider, array $request)
{
    if (!$request['code']) die('Accès refusé');

    $data = $provider->getUser($request['code']);
    dd($data);
}

function displayHome(array $providers)
{
    foreach ($providers as $provider) {
        echo getOAuthLink($provider['instance']->getAuthorizationUrl(), $provider['link_label']);
    }
}

function getOAuthLink(string $link, string $label, array $options = [])
{
    $html = "<p><a href=${link}>${label}</a></p>";

    return $html;
}


function getAllProviders()
{
    $redirect_uri = 'https://localhost/auth';
    return [
        'facebook' => [
            'link_label' => 'Login with Facebook',
            'instance' => new Facebook(FB_CLIENT_ID, FB_SECRET, "${redirect_uri}?provider=facebook")
        ],
        'app' => [
            'link_label' => 'Login with App',
            'instance' => new App(APP_CLIENT_ID, APP_SECRET, "${redirect_uri}?provider=app", ['scope' => 'userinfo', 'state' => 'state_example'])
        ],
        'github' => [
            'link_label' => 'Login with Github',
            'instance' => new Github(GITHUB_CLIENT_ID, GITHUB_SECRET, "${redirect_uri}?provider=github", [], GITHUB_APP)
        ],
        'google' => [
            'link_label' => 'Login with Google',
            'instance' => new Google(GOOGLE_CLIENT_ID, GOOGLE_SECRET, "${redirect_uri}?provider=google", ['scope' => 'https://www.googleapis.com/auth/userinfo.profile'])
        ],
    ];
}

loadDotEnv(ENV_PATH);
$providers = getAllProviders();
$route = strtok($_SERVER["REQUEST_URI"], '?');

switch ($route) {
    case '/':
        displayHome($providers);
        break;
    case '/auth':
        if (!$provider = $providers[$_GET['provider']]['instance']) die("Une erreur est survenue : le provider {$_GET['provider']} n'est pas reconnu");
        handleResponse($provider, $_GET);
        break;
    default:
        http_response_code(404);
}
