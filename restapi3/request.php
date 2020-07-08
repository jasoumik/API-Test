<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client(['base_uri'=>'https://jsonplaceholder.typicode.com/']);
$response = $client->get('posts/1');

var_dump($response);
echo $response->getBody();
echo "<br>";
echo "<br>";
$response = $client->get('posts/2');

//var_dump($response);
echo $response->getBody();

echo "<br>";
echo "<br>";
$response = $client->get('comments/2');


echo $response->getBody();

echo "<br>";
echo "<br>";
$response = $client->get('https://httpbin.org/ip');


echo $response->getBody();
?>