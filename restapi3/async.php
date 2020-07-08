<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;

$client = new Client();
$promise = $client->requestAsync('GET',
'https://jsonplaceholder.typicode.com/posts/1');

//var_dump($response);
$promise->then(
    function (Response $res){
        echo $res->getBody();
    },
    function (RequestException $e){
        echo $e->getMessage();
    }
);
$promise->wait();
//echo $response->getBody();
?>