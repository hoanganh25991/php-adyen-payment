<?php
require_once("vendor/autoload.php");

/**
 * Get our client
 * Reuse this library should submit your own credentials
 * @return \Adyen\Client
 * @throws \Adyen\AdyenException
 */
function getClient(){
    $client = new \Adyen\Client();
    $client->setApplicationName("Adyen PHP Api Library Example");
    $client->setUsername("ws@Company.ConnexionGroup");
    $client->setPassword("jcfqgp2pkhba");
    $client->setEnvironment(\Adyen\Environment::TEST);
    
    return $client;
}

/**
 * Suppot write & read log file
 */
const PSP_LOG_FILE =  'psp.log';

function hoiLog($result, $filename = PSP_LOG_FILE){
    $log_file = fopen($filename, 'a');
    fwrite($log_file, json_encode($result) . PHP_EOL);
    fclose($log_file);
}

function readLog($filename = PSP_LOG_FILE){
    $log_file = fopen($filename, 'r');

    $data = [];
    while($line = fgets($log_file)){
        try{
            $data[] = json_decode($line, true);
        }catch(\Exception $e){
            errorLog($e->getMessage());
        }
    }

    return array_slice(array_reverse($data), 0, 4);
}


/**
 * Convenience call for write log
 */
const PAYMENT_LOG_FILE = 'payment.log';
function storePayment($result){
    $filename = PAYMENT_LOG_FILE;

    hoiLog($result, $filename);
}

const ERROR_LOG_FILE = 'error.log';
function errorLog($result){
    $filename = ERROR_LOG_FILE;

    hoiLog($result, $filename);
}

/**
 * Convenience call for read lod
 */
function fetchRecentPayment(){
    $filename = PAYMENT_LOG_FILE;

    return readLog($filename);
}

/**
 * Generate shopperReference
 */

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function generateShopperReference(){
    return randomPassword();
}

/**
 * Support check GET POST
 */
function isGet(){
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

function isPost(){
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}