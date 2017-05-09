<ul>
    <li>If you've successed create recurring payment first time, click [reuse]</li>
    <li>If you want to reuse with specific [shopperReference], fulfill the input</li>
</ul>
<form method="POST">
    <input type="hidden" name="action" value="reuse_recurring_payment"/>
    <input type="text" name="shopperReference" placeholder="shopperReference">
    <input type="text" name="amount_value" value="<?php echo rand(100, 500) * 100;?>" />
    <input type="text" name="amount_currency" value="EUR" />
    <button>Reuse</button>
</form>