<?php
require_once('vendor/autoload.php');
require_once('util.php');

include_once('navigator.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){ ?>
    
    <h3>Submit the PSP reference to capture</h3>
    <form method="GET" action="capture.php">
        <input type="text" name="psp_ref" />
        <button>Capture</button>
    </form>
    
<?php }

if(isset( $_GET['psp_ref'] )){
    
    $psp_ref = $_GET['psp_ref'];

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


