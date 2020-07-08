<?php

//Sending Request Data
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();
$response = $client->request('POST',
'https://jsonplaceholder.typicode.com/posts',
[
    'json' =>[
        'title' => 'Guzzle Request',
        'body' =>'Guzzle makes working with REST APIs easy',
        'userId' => 2
    ],
]
);

//var_dump($response);
echo $response->getBody();
?>