<?php
require_once("vendor/autoload.php");

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
?>
    <script type="text/javascript" src="https://test.adyen.com/hpp/cse/js/8214942187553853.shtml"></script>
    <form method="POST" action="" id="adyen-encrypted-form">
        <input type="text" size="20" data-encrypted-name="number" value="5103 2219 1119 9245"/>
        <input type="text" size="20" data-encrypted-name="holderName" value="Anh"/>
        <input type="text" size="2" data-encrypted-name="expiryMonth" value="08"/>
        <input type="text" size="4" data-encrypted-name="expiryYear" value="2018"/>
        <input type="text" size="4" data-encrypted-name="cvc" value="737"/>
        <input type="hidden" value="2017-05-08T10:15:00.428+07:00" data-encrypted-name="generationtime"/>
        <input type="submit" value="Pay"/>
    </form>
    <div>
        <button><a href="capture.php">Capture payment</a></button>
    </div>
    <div>
        <button><a href="recurring.php">Recurring payment</a></button>
    </div>
    <script>
        // The form element to encrypt.
        var form = document.getElementById('adyen-encrypted-form');
        // See https://github.com/Adyen/CSE-JS/blob/master/Options.md for details on the options to use.
        var options = {};
        // Bind encryption options to the form.
        adyen.createEncryptedForm(form, options);
    </script>

<?php } else {
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

        'reference' => 'hoiposadyen',
        'merchantAccount' => 'TheBeerFactoryXpress'
    ];

    $client = new \Adyen\Client();
    $client->setApplicationName("Adyen PHP Api Library Example");
    $client->setUsername("ws@Company.ConnexionGroup");
    $client->setPassword("jcfqgp2pkhba");
    $client->setEnvironment(\Adyen\Environment::TEST);

    $service = new \Adyen\Service\Payment($client);
    
    $params  = $post_fields;

    try{
        $result = $service->authorise($params);
        var_dump($result);

        $log_psp_ref = fopen('psp.log', 'a');
        fwrite($log_psp_ref, json_encode($result) . PHP_EOL);
        fclose($log_psp_ref);
    }catch(\Exception $e){
        var_dump($e->getMessage());
    }
}



