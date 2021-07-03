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

/**
 * Build an url with query strings
 *
 * @param string $url
 * @param array $params
 * @return string
 */
function makeUrl(string $url, array $params = [])
{
    return $url . (!empty($params) ? '?' . http_build_query($params) : '');
}

/**
 * Perform a HTTP Request
 *
 * @param string $url
 * @param string|array $context using stream_context_create function
 * @return array|null
 */
function httpRequest(string $url, $context = null)
{
    $response = file_get_contents($url, false, $context);
    return $response ? json_decode($response, true) : null;
}

/**
 * @param string $method
 * @param $header
 * @return resource
 */
function createStreamContext(string $method, $header)
{
    return stream_context_create([
        'http' => [
            'method' => $method,
            'header' => $header
        ]
    ]);
}
