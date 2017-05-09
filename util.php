<?php
require_once("vendor/autoload.php");

function getClient(){
    $client = new \Adyen\Client();
    $client->setApplicationName("Adyen PHP Api Library Example");
    $client->setUsername("ws@Company.ConnexionGroup");
    $client->setPassword("jcfqgp2pkhba");
    $client->setEnvironment(\Adyen\Environment::TEST);
    
    return $client;
}

function hoiLog($result){
    $log_psp_ref = fopen('psp.log', 'a');
    fwrite($log_psp_ref, json_encode($result) . PHP_EOL);
    fclose($log_psp_ref);
}