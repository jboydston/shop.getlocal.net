<?php

require "_globals.php";
require SECURITY;

if(isset($_GET[submit])){
	include CLASS_MP_BUSINESS;
	$biz = new handleBusiness;
	$search_result = $biz->streetSearchFunction();
	}

$field_selected[$_GET[type]] = "selected";

?>

<?php getHeader("admin"); ?>

<h3>Street Search</h3>

<p>For all companies located on a specific street, enter the street name and the city.  To make sure you have the specific street you want.</p> 

<?=$message_format?>

<form action="<?=$PHP_SELF?>" method="get">
	Street: <input type="text" name="street" value="<?=stripslashes($_GET["street"])?>" style="width:250px;"> &nbsp;&nbsp;
	City:   <input type="text" name="city"   value="<?=stripslashes($_GET["city"])?>"   style="width:150px;"> &nbsp;&nbsp;
	<input type="submit" name="submit" value="Submit">
	</form>
<br/>
<hr/>
<br/>
<?php echo $search_result; ?>

<?php getFooter("admin"); ?>