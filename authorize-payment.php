<?php
require_once('vendor/autoload.php');
require_once('util.php');

include_once('navigator.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        
        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Text to send if user hits Cancel button';
        exit;
        
    } else {
        echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
        echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
        
    }

    // Reuse form to ask customer input
    // credit card info
    include_once('authorize-payment-form.php');
}


if(isPost()) {
    //var_dump($_POST);

    $client_payload = $_POST['adyen-encrypted-data'];

    $params = [
        'additionalData' => [

            'card.encrypted.json' => $client_payload

        ],

        'amount' => [
            'value' => rand(100, 500) * 100,
            'currency' => 'EUR'
        ],

        'reference' => 'authorized_payment',

        'merchantAccount' => 'TheBeerFactoryXpress',
    ];

    hoiVarDump("Authorize Payment Params", $params);

    $service = new \Adyen\Service\Payment(getClient());


    try{
        
        $result = $service->authorise($params);
        hoiVarDump('Create Payment Result', $result);

        // Write log
        storePayment(compact('params', 'result'));

        hoiLog($result);

    }catch(\Exception $e){

        var_dump($e->getMessage());
    }
}



