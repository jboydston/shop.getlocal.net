<?php

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;
include CLASS_ADS;
	
$biz = new handleBusiness;
$ads = new handleAds;

if(isset($_POST["submit"])){
	$ads->adCreate();
	$rem_scpm[$_POST["scpm"]] = " selected";
	if($_POST["ufn"] == 1) $rem_ufn = " checked";
	$ads->createAdSheet();
	header("location: ".$_SERVER["PHP_SELF"]."?id=".$_GET["id"]."&adid=".$ads->rec["id"]."&m=1");
	exit;
	}else{
	$rem_scpm[$ads->rec["cpm"]] = " selected";
	if($ads->rec["ufn"] == 1) $rem_ufn = " checked";
	if($ads->rec["reset_cpm"] == 1) $rem_resest = " checked";
	}

if(isset($_GET["m"])){
	$mess[1] = "1 Ad created/modified successfully.";
	$message = $mess[$_GET["m"]];
	}



?>

<?php getHeader("admin"); ?>

<h3>Create a New Ad</h3>

<?php echo $biz->buildCard(); ?>

<?php echo buildMessage($message); ?>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $_GET["id"]; ?>" method="post" enctype="multipart/form-data">

<table class="form">
	<tr>
		<td class="field-name">Upload/Change Image:</td>
		<td class="field-value">
			<?php
			if($ads->rec["imagefile"] != ""){
				$build  = $ads->rec["imagefile"]."<br/>";
				$build .= "<a onclick=\"document.getElementById('change').style.display='block'\" class=\"field-info expandable-link\">CHANGE IMAGE</a> &nbsp;&nbsp;\r\n";
				$build .= "<div id=\"change\" style=\"display:none;\"><br/><input type=\"file\" name=\"ad_upload\"></div><br/>\r\n";
				}else $build  = "<input type=\"file\" name=\"ad_upload\">";
			echo $build;
			?>
			</td>
		</tr>
	<tr>
		<td class="field-name">Link To:</td>
		<td class="field-value"><input type="text" name="href" value="<?php echo stripslashes($ads->rec["href"]); ?>" class="text"> <span class="extra-small">(Leave blank if coupon)</span></td>
		</tr>
	<tr>
		<td class="field-name">Category:</td>
		<td class="field-value"><?php echo $ads->getAdCategories(); ?></td>
		</tr>
	<tr>
		<td class="field-name">Start Date:</td>
		<td class="field-value"><?php echo buildMonthSelect("startmonth",substr($ads->rec["start"],4,2));?> <?php echo buildDaySelect("startday",substr($ads->rec["start"],6,2));?> <?php echo buildYearSelect(date("Y"),date("Y")+2,"startyear",substr($ads->rec["start"],0,4));?> </td>
		</tr>
	</table>

<h4>Option 1: Stop Date and Until Further Notice</h4>

<p>This is the basic billing solution for advertising.  You can specify when this ad stops or allow it to continue to run.  You can bill based on daily, weekly, monthly or any other set period of time.
Setting the ad to Run Until Further Notice will force the ad to stay visible on the main site until an admin manually removes the ads or disables it.</p>

<table class="form">
	<tr>
		<td class="field-name">Stop Date:</td>
		<td class="field-value"><?php echo buildMonthSelect("stopmonth",substr($ads->rec["stop"],4,2));?> <?php echo buildDaySelect("stopday",substr($ads->rec["stop"],6,2));?> <?php echo buildYearSelect(date("Y"),date("Y")+2,"stopyear",substr($ads->rec["stop"],0,4));?> </td>
		</tr>
	<tr>
		<td class="field-name">Run Until Further Notice:</td>
		<td class="field-value"><input type="checkbox" name="ufn" value="1"<?php echo $rem_ufn; ?>> <span class="extra-small green">(ignores stop date)</span> </td>
		</tr>
	</table>

<h4>Option 2: Impressions <span class="small green">(if set, will ignore the first option)</span></h4>

<p>This is an alternative billing solution for advertising.  You can limit how many impressions an ad will create by setting the maxium number of times that ad can be viewed.  For example,
you can charge the "Widget Company" $250.00 per 5,000 impressions.  This type of scheduling ignores stop dates.  The ad will stop when the maxium number of impressions are viewed.  Pricing structure is
up to you.</p>

<table class="form">
	<tr>
		<td class="field-name">Limit Impressions (CPM):</td>
		<td class="field-value"><select name="scpm">
			<option value="">Select number of impressions</option>
			<option value="1000"<?php echo $rem_scpm["1000"];?>>1,000</option>
			<option value="2000"<?php echo $rem_scpm["2000"];?>>2,000</option>
			<option value="3000"<?php echo $rem_scpm["3000"];?>>3,000</option>
			<option value="4000"<?php echo $rem_scpm["4000"];?>>4,000</option>
			<option value="5000"<?php echo $rem_scpm["5000"];?>>5,000</option>
			<option value="10000"<?php echo $rem_scpm["10000"];?>>10,000</option>
			<option value="25000"<?php echo $rem_scpm["25000"];?>>25,000</option>
			<option value="50000"<?php echo $rem_scpm["50000"];?>>50,000</option>
			<option value="100000"<?php echo $rem_scpm["100000"];?>>100,000</option>
			<option value="500000"<?php echo $rem_scpm["500000"];?>>500,000</option>
			<option value="1000000"<?php echo $rem_scpm["1000000"];?>>1,000,000</option>
			</select>
			<span class="small green">or custom number</span> <input type="text" value="<?php echo $ads->rec["cpm"]; ?>" name="cpm"></td>
		</tr>
	<tr>
		<td class="field-name">Reset CPM Session:</td>
		<td class="field-value"><input type="checkbox" name="reset_cpm" value="1"<?php echo $rem_reset; ?>> Yes, reset the CPM session<br/>
														<span class="small green">Resetting the CPM session will reset the CPM counter to zero and allow this ad to have full range of impressions as
														defined by the limit.  Resetting this does not affect total impressions for statisical reports.</span></td>
		</tr>
	</table>

<h4>Create/Update Ad</h4>

<table class="form">
	<tr>
		<td class="field-name"></td>
		<td class="field-value"><input type="submit" name="submit" value="Create/Update Ad"></td>
		</tr>
	</table>

	<input type="hidden" name="adid" value="<?php echo $ads->rec["id"]; ?>">





</form>


<?php getFooter("admin"); ?>