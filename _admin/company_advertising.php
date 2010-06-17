<?php

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;
include CLASS_ADS;
	
$biz = new handleBusiness;
$ads = new handleAds;
$ads->rec["marketplace_id"] = $biz->rec["record_id"];

if(isset($_POST["submit"])){
	$ads->adCreate();
	$ads->createAdSheet();
	header("location: ".$_SERVER["PHP_SELF"]."?id=".$_GET["id"]."&m=1");
	exit;
	}

if(isset($_GET["m"])){
	$mess[1] = "1 Ad created successfully.";
	$mess[2] = "1 Ad has been deleted.";
	$message = $mess[$_GET["m"]];
	}

if($_GET["delete"] == "yes"){
	$ads->deleteAd();
	header("location: ".$_SERVER["PHP_SELF"]."?id=".$_GET["id"]."&m=2");
	exit;
	}


?>

<?php getHeader("admin"); ?>

<h3>Company Advertising</h3>

<?php echo $biz->buildCard(); ?>

<?php echo buildMessage($message); ?>

<p>This page allows you to manage the ads this company is running with marketplace.</p>


<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $_GET["id"]; ?>" method="post" enctype="multipart/form-data">

<div style="border: 1px dotted #000; padding: 20px; margin: 20px 0px;">
	<a onclick="document.getElementById('new_ad').style.display='block';" class="field-info expandable-link">QUICK CREATE</a> &nbsp;&nbsp;&nbsp;&nbsp;
	<a href="ad_manage.php?id=<?php echo $biz->rec["record_id"]; ?>" class="field-info expandable-link">CREATE NEW AD</a>
	</div>

<table class="form" id="new_ad" style="display: none; margin: 10px 0; border:1px dotted #000; padding: 15px; background-color:#cfe6d1;">
	<tr>
		<td class="field-name">Upload Image:</td>
		<td class="field-value"><input type="file" name="ad_upload"></td>
		</tr>
	<tr>
		<td class="field-name">Link To:</td>
		<td class="field-value"><input type="text" name="href" value="<?php echo stripslashes($ads->rec["href"]); ?>" class="text"> <span class="extra-small">(Leave blank if coupon)</span></td>
		</tr>
	<tr>
		<td class="field-name">Run for:</td>
		<td class="field-value"><select name="runtime">
			<option value="ufn">Until Further Notice</option>
			<option value="7">One Week</option>
			<option value="14">Two Weeks</option>
			<option value="28">Four Weeks</option>
			<option value="42">Six Weeks</option>
			<option value="31">One Month</option>
			<option value="62">Two Months</option>
			<option value="183">Six Months</option>
			<option value="365">One Year</option>
			</select>
			</td>
		</tr>
	<tr>
		<td class="field-name"></td>
		<td class="field-value"><input type="submit" name="submit" value="Create Ad"> &nbsp; <a onclick="document.getElementById('new_ad').style.display='none'"  class="field-info expandable-link">[ hide quick form ]</a></td>
		</tr>
	</table>
			
	<?php echo $ads->getAdvertising($biz->rec["record_id"]); ?>



</form>


<?php getFooter("admin"); ?>