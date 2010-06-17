<?php

require "_admin/_globals.php";

?>

<?php include PRINTHEADERFILE;?>


<img src="<?php echo IMAGEDIR; ?>/logo.jpg"><br>
<img src="<?=$_GET[file]?>"><br>
<br>
You can print this coupon and take it to the participating store to redeem it.<br>
<br>
<form>
<input type="button" value="Close Window" onClick="window.close()">
</form>	

<?php include PRINTFOOTERFILE;?>