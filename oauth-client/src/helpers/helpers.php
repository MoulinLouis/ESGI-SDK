<?php


function dd(...$var)
{
    echo '<pre>';
    foreach ($var as $v) {
        if (is_array($v)) {
            print_r($v);
        } else {
            echo $v . PHP_EOL;
        }
    }
    echo '</pre>';
    die;
}

function makeUrl(string $url, array $params)
{
    return $url . !empty($params) ? '?' . http_build_query($params) : '';
}

function httpRequest(string $url, bool $post = true)
{
    $request = curl_init($url);
    if ($post) {
        curl_setopt($request, CURLOPT_POST, true);
    }

    $response = json_decode(curl_exec($request), true);
    curl_close($request);

    return $response;
}
