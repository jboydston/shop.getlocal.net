<?php

require "_admin/_globals.php";

if(isset($_POST["submit"])){
	if($_POST["business_name"] == "") $message = "2 Please fill out all fields.";
	foreach($_POST as $key => $value) $_POST[$key] = htmlspecialchars($value);
	if($message == null){
		$message = "1 Your message has been received.  Someone will contact you within the next couple of days.";
		$build  = stripslashes($_POST["name"])."<br/>\r";
		$build .= stripslashes($_POST["business_name"])."<br/>\r";
		$build .= fixPhone($_POST["area_code"].$_POST["city_code"].$_POST["xchg_code"])."<br/>\r";
		$build .= stripslashes($_POST["web_address"])."<br/>\r";
		$build .= stripslashes($_POST["notes"])."<br/>\r";
		$subject = "Marketplace email from ".$_POST["business_name"];		
		mail(SEND_SMTP_TO, $subject, $build, SMTP_HEADERS, "-f".SMTP_FROM_EMAIL);
		}
	}

?>

<?php getHeader("public"); ?>

<?php echo buildMessage($message); ?>

<p class="medium">For all corrections, updates, and advertising opportunities, contact our sales department at
<?php echo fixPhone(CONTACTPHONE); ?> or use the form below.</p>

<form action="<?=$PHP_SELF?>" method="post">
<div class="form-row">
	<div class="field-name">Your Name:</div>
	<div class="field-value"><input type="text" name="name" value="<?=stripslashes($_POST["name"])?>" class="form"></div>
	</div>

<div class="form-row">
	<div class="field-name">Business Name:</div>
	<div class="field-value"><input type="text" name="business_name" value="<?=stripslashes($_POST["business_name"])?>" class="form"></div>
	</div>

<div class="form-row">
	<div class="field-name">Phone:</div>
	<div class="field-value">
		<input type="text" name="area_code" maxlength="3" value="<?=stripslashes($_POST["area_code"])?>" class="form small">
		<input type="text" name="city_code" maxlength="3" value="<?=stripslashes($_POST["city_code"])?>" class="form small">
		<input type="text" name="xchg_code" maxlength="4" value="<?=stripslashes($_POST["xchg_code"])?>" class="form small"></div>
	</div>

<div class="form-row">
	<div class="field-name">Web Site:</div>
	<div class="field-value"><input type="text" name="web_address" value="<?=stripslashes($_POST["web_address"])?>" class="form"></div>
	</div>

<div class="form-row">
	<p>Please describe the problem, change, or new addition.</p>
	<textarea name="notes" rows="10" cols="60"><?=stripslashes($_POST["notes"])?></textarea>
	</div>

	<input type="submit" name="submit" value="Submit">
	</form>



	
<?php getFooter("public"); ?>