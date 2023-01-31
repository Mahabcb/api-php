<?php

use GuzzleHttp\Client;
require_once 'vendor/autoload.php';
$client = new Client();
$response = $client->request('GET', 'https://api.chucknorris.io/jokes/random');

// echo $response->getStatusCode() . PHP_EOL; // 200
// echo $response->getHeaderLine('content-type'). PHP_EOL; // 'application/json; charset=utf8'

// get body
$data = $response->getBody(). PHP_EOL; // '{"id": 1420053, "name": "guzzle", ...}'
echo $data;

$array = json_decode($data, true);
echo $array['value'];
?>