<?php
require_once('vendor/autoload.php');
require_once('util.php');

include_once('navigator.php');

session_start();

if(isGet()){
    
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
    echo "<h1>Click to pay to create recurring payment first time</h1>";
    include_once('form.php');

    echo "<h1>Reuse recurring payment</h1>";
    echo "<p>If you success create recurring payment first time, click reuse</p>";
    echo "<p>If want to submit shopperReference, fullfill the input</p>";
    ?>

    <form method="POST">
        <input type="hidden" name="action" value="reuse_recurring_payment"/>
        <input type="text" name="shopperReference" placeholder="shopperReference">
        <input type="text" name="amount_value" value="<?php echo rand(100, 500) * 100;?>" />
        <input type="text" name="amount_currency" value="EUR" />
        <button>Reuse</button>
    </form>


<?php }


if(isPost()){

    //var_dump($_POST);
    $createRecurringPaymentFirsttime = isset($_POST['adyen-encrypted-data']);

    if($createRecurringPaymentFirsttime){
        $client_payload = $_POST['adyen-encrypted-data'];

        $shopperReference = generateShopperReference();

        $_SESSION['lastShopperReference'] = $shopperReference;

        $params = [
            'additionalData' => [

                'card.encrypted.json' => $client_payload

            ],

            'amount' => [
                'value' => rand(100, 500) * 100,
                'currency' => 'EUR'
            ],

            'reference' => 'recurring_payment_firsttime',

            'merchantAccount' => 'TheBeerFactoryXpress',

            // Required fields for RECURRING
            'recurring' => [
                'contract' => \Adyen\Contract::RECURRING,
            ],

            'shopperReference' => $shopperReference,

            'shopperInteraction' => 'ContAuth',
        ];

        var_dump('Params for recurring payment', $params);
        var_dump('Difference keys compare to normal authorzied payment', ['recurring', 'shopperReference', 'shopperInteraction']);
        var_dump('This first time will create the shopperReference for recurring payment later use', ['shopperReference' => $shopperReference]);

        $service = new \Adyen\Service\Payment(getClient());

        try{
            $result = $service->authorise($params);
            var_dump($result);

            // Write log
            storePayment(compact('params', 'result'));
            hoiLog($result);

        }catch(\Exception $e){

            var_dump($e->getMessage());

        }
    }

    $reuseRecurringPayment = isset($_POST['action'])
                             && $_POST['action'] == 'reuse_recurring_payment';

    if($reuseRecurringPayment){
        $value    = $_POST['amount_value'];
        $currency = $_POST['amount_currency'];

        $shopperReference = $_SESSION['lastShopperReference'];

        if(!empty($_POST['shopperReference'])){
            $shopperReference = $_POST['shopperReference'];
        }

        $params = [
            'amount' => [
                'value' => $value,
                'currency' => $currency
            ],

            'reference' => 'reuse_recurring_payment',

            'merchantAccount' => 'TheBeerFactoryXpress',

            // Required fields for RECURRING

            'recurring' => [
                'contract' => \Adyen\Contract::RECURRING,
            ],

            'shopperReference' => $shopperReference,

            'shopperInteraction' => 'ContAuth',

            'selectedRecurringDetailReference' => 'LATEST',
        ];

        var_dump($params);

        $service = new \Adyen\Service\Payment(getClient());

        try{
            $result = $service->authorise($params);
            var_dump($result);

            // Write log
            storePayment(compact('params', 'result'));
            hoiLog($result);

        }catch(\Exception $e){

            var_dump($e->getMessage());

        }
    }


}



