<?php

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;
	
$biz = new handleBusiness;


if(isset($_POST["submit"])){
	foreach($_POST["fields"] as $db_field => $db_value) $biz->updateData($db_field, $db_value, $_POST["id"]);
	$biz->updateData("product_text", $_POST["product_text"], $_POST["id"]);
	$message = "1 This listing has been updated.";
	$biz->__construct();
	}

$product_flag_option[$biz->rec["product_flag"]]     = " checked";

?>

<?php getHeader("admin"); ?>

<script type="text/javascript" src="<?php echo PATHTOHTML.PATHTOADMIN; ?>/ckeditor/ckeditor.js"></script>

<h3>Edit Company Profile</h3>

<?php echo $biz->buildCard(); ?>

<?php echo buildMessage($message); ?>


<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
<h4>Product</h4>
<table class="form">
	<tr>
		<td class="field-name">Product Tab: <a href="#" onmouseover="drc('You can safely turn on and off the profile tab without losing any of the information stored in this tab.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[product_flag]" value="1"<?php echo $product_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[product_flag]" value="0"<?php echo $product_flag_option[0];?>> Off</td>
		</tr>
	</table>
<br/>


<textarea name="product_text"><?php echo $biz->rec["product_text"];?></textarea>
<script type="text/javascript"> CKEDITOR.replace('product_text'); </script>

<br/>
<br/>


<input type="submit" name="submit" value="Update">
<input type="hidden" name="id" value="<?php echo $_REQUEST["id"];?>">
</form>

<?php getFooter("admin"); ?>