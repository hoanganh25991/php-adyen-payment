<?php
require_once("vendor/autoload.php");

if(!isset( $_GET['psp_ref'] )){ ?>
    <h3>Submit the PSP reference to capture</h3>
    <form method="GET" action="capture.php">
        <input type="text" name="psp_ref" />
        <button>Capture</button>
    </form>
<?php
}else{
    $psp_ref = $_GET['psp_ref'];
    $client = new \Adyen\Client();
    $client->setApplicationName("Adyen PHP Api Library Example");
    $client->setUsername("ws@Company.ConnexionGroup");
    $client->setPassword("jcfqgp2pkhba");
    $client->setEnvironment(\Adyen\Environment::TEST);

// initialize service
    $service = new \Adyen\Service\Modification($client);

//$recurring = ['contract' => \Adyen\Contract::RECURRING];

//$params = [
//    'merchantAccount' => 'TheBeerFactoryXpress',
//    'originalReference' => $psp_ref,
//    'recurring' => [
//        'contract' => "RECURRING,ONECLICK"
//    ],
//    'shopperReference' => 1
//];

    $params = [
        'merchantAccount' => 'TheBeerFactoryXpress',
        'modificationAmount' => [
            'value' => 20000,
            'currency' => 'USD',
        ],
        'originalReference' => $psp_ref,
        'reference' => 'hoiposayden',
    ];

    var_dump($params);

    try{
        $result = $service->capture($params);
        var_dump($result);
    }catch(\Exception $e){
        var_dump($e->getMessage());
    }
}


