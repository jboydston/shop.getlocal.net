<?php

require "_admin/_globals.php";

if(isset($_POST["preview"])){
	$_SESSION[SHOPPING_SESSION_ID]["field"] = $_POST["field"];
	header("location: confirm.php");
	exit;
	}

?>

<?php getHeader("public","yes"); ?>

<script>
<!--
function copyInfo(){
	document.getElementById('field[ship_fname]').value = document.getElementById('field[fname]').value;
	document.getElementById('field[ship_lname]').value = document.getElementById('field[lname]').value;
	document.getElementById('field[ship_address]').value = document.getElementById('field[address]').value;
	document.getElementById('field[ship_city]').value = document.getElementById('field[city]').value;
	document.getElementById('field[ship_state]').value = document.getElementById('field[state]').value;
	document.getElementById('field[ship_zip]').value = document.getElementById('field[zip]').value;
	}
-->
</script>


<div id="link-column-container">

	</div>

<div id="content-column-content">

	<div class="content-title">Check Out</div>
		<div style="margin:10px;">

		<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
			
		<h3>Buyer's Information</h3>
		<table class="form">
			<tr>
				<td class="field-name">
					First Name:</td>
				<td class="field-value">
					<input type="text" class="text" id="field[fname]" name="field[fname]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["fname"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					Last Name:</td>
				<td class="field-value">
					<input type="text" class="text" id="field[lname]" name="field[lname]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["lname"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					Address:</td>
				<td class="field-value">
					<input type="text" class="text" id="field[address]" name="field[address]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["address"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					City:</td>
				<td class="field-value">
					<input type="text" class="text" id="field[city]" name="field[city]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["city"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					State:</td>
				<td class="field-value">
					<input type="text" class="small" maxlength="2" id="field[state]" name="field[state]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["state"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					Zip Code:</td>
				<td class="field-value">
					<input type="text" class="short" maxlength="5" id="field[zip]" name="field[zip]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["zip"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					Email Address:</td>
				<td class="field-value">
					<input type="text" class="text" name="field[email]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["email"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					Phone Number:</td>
				<td class="field-value">
					<input type="text" class="small" maxlength="3" name="field[areacode]"  value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["areacode"]); ?>">&nbsp;
					<input type="text" class="small" maxlength="3" name="field[citycode]"  value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["citycode"]); ?>"> - 
					<input type="text" class="short" maxlength="4" name="field[numbcode]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["numbcode"]); ?>"></td>
				</tr>
			</table>
			
		<h3>Shipping Information</h3>
		<table class="form">
			<tr>
				<td class="field-name"></td>
				<td class="field-value">
					<span class="small"><input type="checkbox" onChange="copyInfo();"> Same as billing information</span></td>
				</tr>
			<tr>
				<td class="field-name">
					First Name:</td>
				<td class="field-value">
					<input type="text" class="text" id="field[ship_fname]" name="field[ship_fname]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_fname"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					Last Name:</td>
				<td class="field-value">
					<input type="text" class="text" id="field[ship_lname]" name="field[ship_lname]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_lname"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					Address:</td>
				<td class="field-value">
					<input type="text" class="text" id="field[ship_address]" name="field[ship_address]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_address"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					City:</td>
				<td class="field-value">
					<input type="text" class="text" id="field[ship_city]" name="field[ship_city]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_city"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					State:</td>
				<td class="field-value">
					<input type="text" class="small" maxlength="2" id="field[ship_state]" name="field[ship_state]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_state"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					Zip Code:</td>
				<td class="field-value">
					<input type="text" class="short" maxlength="5" id="field[ship_zip]" name="field[ship_zip]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_zip"]); ?>"></td>
				</tr>
			</table>
			
		<h3>Credit Card Information</h3>
		<table class="form">
			<tr>
				<td class="field-name">
					Name on Card:</td>
				<td class="field-value">
					<input type="text" class="text" name="field[cc_name]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["cc_name"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					Card Number:</td>
				<td class="field-value">
					<input type="text" class="text" name="field[cc_number]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["cc_number"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					Card Expiration:</td>
				<td class="field-value">
					<select name="field[exp_month]">
						<?php
						$rem_exp_month[$_SESSION[SHOPPING_SESSION_ID]["field"]["exp_month"]] = "selected";
						for($i=1;$i<=12;$i++){
							$option_value = date("m", mktime(0,0,0,$i,1,date("Y")));
							echo "<option value=\"".$option_value."\" ".$rem_exp_month[$option_value].">".$i." ".date("F", mktime(0,0,0,$i,1,date("Y")))."</option>";
							}
						?>
						</select>
					<select name="field[exp_year]">
						<?php
						$year = date("Y");
						$rem_exp_year[$_SESSION[SHOPPING_SESSION_ID]["field"]["exp_year"]] = "selected";
						for($i=1;$i<=20;$i++){
							echo "<option value=\"".$year."\" ".$rem_exp_year[$year].">".$year."</option>";
							$year++;
							}
						?>
						</select></td>
				</tr>
			<tr>
				<td class="field-name">
					Security Code:</td>
				<td class="field-value">
					<input type="text" class="short" name="field[cc_scode]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["cc_scode"]); ?>"></td>
				</tr>
			<tr>
				<td class="field-name">
					Card Zip Code:</td>
				<td class="field-value">
					<input type="text" class="short" name="field[cc_zip]" value="<?php echo stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["cc_zip"]); ?>"></td>
				</tr>
			</table>
		
		<table class="form">
			<tr>
				<td class="field-name"></td>
				<td class="field-value">
					<input type="submit" name="preview" value="Preview Order"></td>
				</tr>
			</table>
		
		</form>
	
		</div>
	</div>

<?php getFooter("public"); ?>