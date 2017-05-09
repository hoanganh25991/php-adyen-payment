<?php


// Adyen base on current time of submit form
// To validate if request after 24h is invalid
// Dynamic generate as format "YYYY-MM-DDTHH:mm:ss.sssZ"
// example: 2017-05-09T19:53:39+07:00
$generationtime = date(DATE_W3C, mktime(date("H"), date("i"), date("s"), date("m"), date("j"), date("Y")));
?>
<h3>Authorize Payment Form</h3>
<script type="text/javascript" src="https://test.adyen.com/hpp/cse/js/8214942187553853.shtml"></script>
<form method="POST" action="" id="adyen-encrypted-form">
    <input type="text" size="20" data-encrypted-name="number" value="5555 4444 3333 1111"/>
    <input type="text" size="20" data-encrypted-name="holderName" value="Anh"/>
    <input type="text" size="2" data-encrypted-name="expiryMonth" value="08"/>
    <input type="text" size="4" data-encrypted-name="expiryYear" value="2018"/>
    <input type="text" size="4" data-encrypted-name="cvc" value="737"/>
    <input type="hidden" value="<?php echo $generationtime; ?>" data-encrypted-name="generationtime"/>
    <input type="submit" value="Pay"/>
</form>
<ul>
    <li>Default value for card-number, holder-name,... fulfilled. Feel free to submit your own info.</li>
    <li>To capture authorzied payment. <a href="capture.php">Go to Capture</a></li>
</ul>
<script>
    // The form element to encrypt.
    var form = document.getElementById('adyen-encrypted-form');
    // See https://github.com/Adyen/CSE-JS/blob/master/Options.md for details on the options to use.
    var options = {};
    // Bind encryption options to the form.
    adyen.createEncryptedForm(form, options);
</script>