<?php
require_once("vendor/autoload.php");

var_dump($_POST);

$client_payload = $_POST['adyen-encrypted-data'];

$post_fields = [
    'additionalData' => [
        'card.encrypted.json' => $client_payload
    ],

    'amount' => [
        'value' => 20000,
        'currency' => 'USD'
    ],

    'reference' => 'hoiposayden',
    'merchantAccount' => 'TestMerchant'
];

$client = new \Adyen\Client();
$client->setApplicationName("Adyen PHP Api Library Example");
$client->setUsername("ws@Company.ConnexionGroup");
$client->setPassword("jcfqgp2pkhba");
$client->setEnvironment(\Adyen\Environment::TEST);

$service = new \Adyen\Service\Payment($client);

$params = $post_fields;

try{
    $result = $service->authorise($params);
    var_dump($result);
}catch(\Exception $e){
    var_dump($e->getMessage());
}

