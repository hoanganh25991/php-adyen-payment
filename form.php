<script type="text/javascript" src="https://test.adyen.com/hpp/cse/js/8214942187553853.shtml"></script>
<form method="POST" action="" id="adyen-encrypted-form">
    <input type="text" size="20" data-encrypted-name="number" value="5555 4444 3333 1111"/>
    <input type="text" size="20" data-encrypted-name="holderName" value="Anh"/>
    <input type="text" size="2" data-encrypted-name="expiryMonth" value="08"/>
    <input type="text" size="4" data-encrypted-name="expiryYear" value="2018"/>
    <input type="text" size="4" data-encrypted-name="cvc" value="737"/>
    <input type="hidden" value="2017-05-08T10:15:00.428+07:00" data-encrypted-name="generationtime"/>
    <input type="submit" value="Pay"/>
</form>
<script>
    // The form element to encrypt.
    var form = document.getElementById('adyen-encrypted-form');
    // See https://github.com/Adyen/CSE-JS/blob/master/Options.md for details on the options to use.
    var options = {};
    // Bind encryption options to the form.
    adyen.createEncryptedForm(form, options);
</script>