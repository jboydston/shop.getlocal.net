<?php

require "_admin/_globals.php";
require CLASS_SHOPPING_CART;

$scart = new handleShoppingCart;

if(isset($_POST["submit"])){
	$message = null;
	if($_POST["agreement"] != "yes") $message = "2 You must agree to the terms and conditions below in order to purchase gift card(s).";
	
	if($message == null){	
		getPaymentClass();
		$pay = new handlePayment;
		$pay->preloadPayment($scart->getTotal());
		$pay->savePaymentRecord();
		$result = $pay->processInvoice();
		$scart->closeCards($pay->id);
		sendMail("giftcard",$pay->id);
		$message = $result["message"];
		}
	}

?>

<?php getHeader("public","yes"); ?>

<div id="link-column-container">

	</div>

<div id="content-column-content">

	<div class="content-title">Check Out</div>
		<div style="margin:10px;">
		<?php echo buildMessage($message); ?>
	
		<h3>Buyer's Information</h3>
		<table class="form">
			<tr>
				<td class="field-name">First Name:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["fname"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">Last Name:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["lname"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">Address:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["address"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">City:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["city"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">State:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["state"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">Zip Code:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["zip"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">Email Address:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["email"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">Phone Number:</td>
				<td class="field-value">(<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["areacode"]); ?>) <?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["citycode"]); ?>-<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["numbcode"]); ?></td>
				</tr>
			</table>
			
		<h3>Shipping Information</h3>
		<table class="form">
			<tr>
				<td class="field-name">First Name:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_fname"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">Last Name:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_lname"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">Address:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_address"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">City:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_city"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">State:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_state"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">Zip Code:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_zip"]); ?></td>
				</tr>
			</table>
			
			
		<h3>Credit Card Information</h3>
		<table class="form">
			<tr>
				<td class="field-name">Name on Card:</td>
				<td class="field-value"><?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["cc_name"]); ?></td>
				</tr>
			<tr>
				<td class="field-name">Card Number:</td>
				<td class="field-value">**** **** **** <?php echo substr($_SESSION[SHOPPING_SESSION_ID]["field"]["cc_number"],-4); ?></td>
				</tr>
			<tr>
				<td class="field-name">Card Expiration:</td>
				<td class="field-value">**/****</td>
				</tr>
			<tr>
				<td class="field-name">Security Code:</td>
				<td class="field-value">***</td>
				</tr>
			<tr>
				<td class="field-name">Card Zip Code:</td>
				<td class="field-value">*****</td>
				</tr>
			</table>
	
	
		<h3>Purchase Information</h3>
		<?php echo $scart->showCartCheckOut(); ?>
		
		<br/>
		
		<?php if($result["result"] != "1") { ?>
		
		<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
	
		<?php echo loadTemplate("terms.conditions.giftcards.php", $rec);?>
		<input type="checkbox" name="agreement" value="yes"> I AGREE TO THE ABOVE STATEMENT
		<br/>
		<br/>
		<input type="submit" name="submit" value="Submit Order" onclick="document.getElementById('processing-box').style.display='block';document.getElementById('submit-box').style.display='none';"> &nbsp;&nbsp; <a href="checkout.php" class="blue small">Make Changes</a>
		
		<p style="display: none;" id="processing-box">Processing your request.  Do not refresh the page or you will be charged twice.</p>
		
		</form>

		<?php } ?>
		
		<?php if($result["result"] == "1") $scart->clearCart(); ?>

		</div>
	</div>

<?php getFooter("public"); ?>