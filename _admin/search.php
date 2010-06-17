<?php

require "_globals.php";
require SECURITY;

if(isset($_GET[submit])){
	include CLASS_MP_BUSINESS;
	$biz = new handleBusiness;
	$search_result = $biz->searchFunction();
	}

$field_selected[$_GET[type]] = "selected";

?>

<?php getHeader("admin"); ?>

<h3>Search</h3>

<p>When searching for a business, you can search by either the company name, address, street, city, phone number, web address, or any of the search terms that are
assoicated with that business.  TIP! When searching by phone number, input numbers only, no symbols. Example:  (707) 555-4646 becomes 7075554646.</p> 

<?=$message_format?>

<form action="<?=$PHP_SELF?>" method="get">
	Search: <input type="text" name="search" value="<?=stripslashes($_GET["search"])?>" style="width:300px;">
	<select name="type">
		<option value="0" <?=$field_selected[0]?>>All Fields</option>
		<option value="1" <?=$field_selected[1]?>>Business Name</option>
		<option value="2" <?=$field_selected[2]?>>Street Address</option>
		<option value="3" <?=$field_selected[3]?>>City</option>
		<option value="4" <?=$field_selected[4]?>>Zip</option>
		<option value="5" <?=$field_selected[5]?>>Phone Number</option>
		<option value="6" <?=$field_selected[6]?>>Web Address</option>
		<option value="7" <?=$field_selected[7]?>>Search Terms</option>
		</select>
	<input type="submit" name="submit" value="Submit">
	</form>
<br/>
<hr/>
<br/>
<?php echo $search_result; ?>

<?php getFooter("admin"); ?>