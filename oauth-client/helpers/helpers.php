<?php


function dd(...$var)
{
    echo '<pre>';
    foreach ($var as $v) print_r($v);
    echo '</pre>';
    die;
}

function makeUrl(string $url, array $query_strings)
{
    return $url . !empty($query_strings) ? http_build_query($query_strings) : '';
}

function request(string $url, bool $post = true)
{
    $request = curl_init($url);
    if ($post) {
        curl_setopt($request, CURLOPT_POST, true);
    }
    curl_setopt($request, CURLOPT_HEADER, 0);

    $response = json_decode(curl_exec($request), true);
    curl_close($request);

    return $response;
}