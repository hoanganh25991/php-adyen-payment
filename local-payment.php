<?php
require_once('vendor/autoload.php');
require_once('util.php');

include_once('navigator.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    // Build params to look up local payment methods available
    $sessionValidity = date(DATE_ATOM, mktime(date("H") + 10, date("i"), date("s"), date("m"), date("j"), date("Y")));

    $hmacKey = "1A5A7536C714996E517B928B5504435D9F991C92402BBE30ED382F78186FD3C6";

    $params = [
        // Important info
        'paymentAmount'     => 20000,
        'currencyCode'      => 'USD',
        'skinCode'          => 'BXsl0kmS',
        'merchantAccount'   => 'TheBeerFactoryXpress',
        'sessionValidity'   => "'.$sessionValidity.'",

        // Optional
        'merchantReference' => 'get_payment_methods',
        'countryCode'       => 'NL',
        'shopperLocale'     => 'n1_NL'
    ];

    // Self compute signature
    $merchantSig = \Adyen\Util\Util::calculateSha256Signature($hmacKey, $params);

    // Then reappend to params request
    $params["merchantSig"] = $merchantSig;

    $service = new \Adyen\Service\DirectoryLookup(getClient());

    try{

        $result = $service->directoryLookup($params);
        var_dump($result);

        // Write log
        hoiLog($result);

    }catch(\Exception $e) {

        var_dump($e->getMessage());

    }
}
