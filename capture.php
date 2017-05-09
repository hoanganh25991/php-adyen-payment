<?php
require_once('vendor/autoload.php');
require_once('util.php');

include_once('navigator.php');

if(isGet()){
    $recent_payments = fetchRecentPayment();

    echo "<h1>List 5 recent payments:</h1>";

    echo "<ul>";

    foreach($recent_payments as $index => $payment){ ?>
        <li>
            <div>
                <?php var_dump('Payment PSP Reference', $payment['result']['pspReference'], $payment); ?>
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


        $service = new \Adyen\Service\Modification(getClient());

        try{
            $result = $service->capture($params);
            var_dump($result);

            // Write log
            hoiLog($result);

        }catch(\Exception $e){

            var_dump($e->getMessage());
        }
    }
}


