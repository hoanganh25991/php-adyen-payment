<?php
require_once('vendor/autoload.php');
require_once('util.php');

include_once('navigator.php');

/**
 * Needed config to create params
 */
$skinCode        = "BXsl0kmS"; // your skinCode
$merchantAccount = "TheBeerFactoryXpress"; // your merchantAccount
$hmacKey         = "1A5A7536C714996E517B928B5504435D9F991C92402BBE30ED382F78186FD3C6"; // your Hmac Key
$sessionValidity = date( DATE_ATOM, mktime(date("H") + 10, date("i"), date("s"), date("m"), date("j"), date("Y")));

/**
 * Params to call need signed
 * @param $hmacKey
 * @param $params
 * @return mixed
 */
function addMerchantSig($hmacKey, $params){
    // The character escape function
    $escapeval = function($val) {
        return str_replace(':','\\:',str_replace('\\','\\\\',$val));
    };

    // Sort the array by key using SORT_STRING order
    ksort($params, SORT_STRING);
    // Generate the signing data string
    $signData = implode(":",array_map($escapeval,array_merge(array_keys($params), array_values($params))));
    // base64-encode the binary result of the HMAC computation
    $merchantSig = base64_encode(hash_hmac('sha256',$signData,pack("H*" , $hmacKey),true));
    $params["merchantSig"] = $merchantSig;
    
    return $params;
}

if(isGet()){
    // Initialize client
    $client = getClient();

    // Payment-specific details
    $params = array(
        "paymentAmount"     => "1000",
        "currencyCode"      => "EUR",
        "merchantReference" => "Get Payment methods",
        "skinCode"          => $skinCode,
        "merchantAccount"   => $merchantAccount,
        "sessionValidity"   => $sessionValidity,
        "countryCode"       => "NL",
        "shopperLocale"     => "nl_NL",
    );
    
    // Initialize service
    $service = new Adyen\Service\DirectoryLookup($client);
    $params  = addMerchantSig($hmacKey, $params);
    // convert the result into an array
    $result  = $service->directoryLookup($params);
    // needs to have an array with the result
    hoiVarDump('Directory Lookup', $result);
}


