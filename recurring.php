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
   
    // Reuse form to ask customer
    // Input credit card info
    include_once('form.php');

}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    var_dump($_POST);

    $client_payload = $_POST['adyen-encrypted-data'];

    $params = [
        'additionalData' => [

            'card.encrypted.json' => $client_payload

        ],

        'card' => [
            'number'      => '5555 4444 3333 1111',
            'expiryMonth' => '8',
            'expiryYear'  => '2018',
            'cvc'         => '737',
            'holderName'  => 'Anh',
        ],  

        'amount' => [
            
            'value' => 20000,
            'currency' => 'EUR',
            
        ],

        'reference' => 'recurring_payment',

        'merchantAccount' => 'TheBeerFactoryXpress',

//        'shopperEmail' => 's.hopper@test.com',

//        'shopperIP' => '61.294.12.12',

        'recurring' => [
            
            'contract' => \Adyen\Contract::RECURRING,

            'recurringDetailName' => '1'
//            'contract' => 'RECURRING,ONECLICK',

        ],

        'shopperReference' => '1',

        //        'shopperReference' => 'Simon Hopper',
//
        'shopperInteraction' => 'Ecommerce',
//
        'selectedRecurringDetailReference' => 'LATEST',
//
//        'selectedBrand' => '',

    ];

    var_dump($params);

    $service = new \Adyen\Service\Recurring(getClient());

    try{
        $result = $service->listRecurringDetails($params);
        var_dump($result);

        // Write log
        hoiLog($result);
       
    }catch(\Exception $e){
        
        var_dump($e->getMessage());
        
    }
}



