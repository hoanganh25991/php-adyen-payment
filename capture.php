<?php
require_once('vendor/autoload.php');
require_once('util.php');

include_once('navigator.php');

if(isGet()){
    $recent_payments = fetchRecentPayment();

    echo "<h1>List recent payments</h1>";
    echo "<ul>";
    echo "<li>Capture in Adyen don't return as exception when calling it twice</li>";
    echo "<li>Please self check success at your own <a href='https://ca-test.adyen.com'>ca-test</a> account at payments panel</li>";
    echo "<li>It takes few minutes to update info in payments panel</li>";
    echo "</ul><hr/>";

    echo "<ul>";

    foreach($recent_payments as $index => $payment){ ?>
        <li>
            <div>
                <?php hoiVarDump('Payment Reference', $payment['params']['reference']); ?>
                <?php hoiVarDump('Payment PSP Reference', $payment['result']['pspReference']); ?>
                <?php hoiVarDump('Payment Params & Result', $payment); ?>
                <form method="POST">
                    <input type="hidden" name="payment_index" value="<?php echo $index; ?>"/>
                    <input type="hidden" name="action" value="capture" />
                    <button>Capture</button>
                </form>
                <hr/>
            </div>
        </li>
    <?php }

    echo "</ul>";
}

if(isPost()){
    $wantCapture = isset($_POST['action'])
                   && $_POST['action'] == 'capture'
                   && isset($_POST['payment_index']);

    if($wantCapture){
        // Which payment want to capture
        $data          = fetchRecentPayment();
        // Simple load by index
        // When new payment created while recapture code
        // >>> index wrong
        $payment_index = $_POST['payment_index'];
        $payment       = $data[$payment_index];
        // Get info from that payment to capture
        $psp_ref  = $payment['result']['pspReference'];
        $value    = $payment['params']['amount']['value'];
        $currency = $payment['params']['amount']['currency'];

        $params = [
            'merchantAccount' => 'TheBeerFactoryXpress',

            'modificationAmount' => [

                'value' => $value,
                'currency' => $currency,

            ],

            'originalReference' => $psp_ref,

            'reference' => 'capture_payment',
        ];

        hoiVarDump('Capture Params', $params);

        $service = new \Adyen\Service\Modification(getClient());

        try{
            $result = $service->capture($params);
            hoiVarDump('Capture Result', $result);

            // Write log
            hoiLog($result);

        }catch(\Exception $e){

            var_dump($e->getMessage());
        }
    }
}


