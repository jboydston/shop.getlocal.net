<?php

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;
	
$biz = new handleBusiness;


if(isset($_POST["submit"])){
	foreach($_POST["fields"] as $db_field => $db_value) $biz->updateData($db_field, $db_value, $_POST["id"]);
	$biz->updateData("latitude", $_POST["latitude"], $_POST["id"]);
	$biz->updateData("longitude", $_POST["longitude"], $_POST["id"]);
	$biz->updateData("search_terms", $_POST["search_terms"], $_POST["id"]);

	foreach($_POST["day"] as $key => $value){
		if($value["closed"] == "on") $build .= "CL|";
		elseif($value["by_appointment"] == "on") $build .= "BA|";
		else $build .= $value["o_hour"].":".$value["o_min"]."-".$value["c_hour"].":".$value["c_min"]."|";
		}
	$business_hours = rtrim($build, "|");
	$biz->updateData("business_hours", $business_hours, $_POST["id"]);
	$message = "1 This listing has been updated.";

	if(trim($_POST["new_sd_cat"]) != "") $biz->addServiceDirectoryCat();

	$biz->__construct();
	}


if(isset($_GET["m"])){
	$mess[2] = "1 Company has been added successfully";
	$message = $mess[$_GET["m"]];
	}

$business_hours_flag_option[$biz->rec["business_hours_flag"]] = " checked";

?>

<?php getHeader("admin","yes"); ?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>


<h3>Edit General Information</h3>

<?php echo $biz->buildCard(); ?>

<?php echo buildMessage($message); ?>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">

<h4>Location</h4>
<p>In order to put this company on the map, the system needs to know the latitude and longitude of the company's location.
To find the coordinations, fill out the correct address and click on the button below.</p>

<table class="form">
	<tr>
		<td class="field-name">Company Name:</td>
		<td class="field-value"><input type="input" name="fields[business_name]" value="<?php echo stripslashes($biz->rec["business_name"]);?>" class="text"></td>
		</tr>
	<tr>
		<td class="field-name">Address:</td>
		<td class="field-value"><input type="input" name="fields[full_address]" value="<?php echo stripslashes($biz->rec["full_address"]);?>" class="text"></td>
		</tr>
	<tr>
		<td class="field-name">City:</td>
		<td class="field-value"><input type="input" name="fields[city_name]" value="<?php echo stripslashes($biz->rec["city_name"]);?>" class="text"></td>
		</tr>
	<tr>
		<td class="field-name">State:</td>
		<td class="field-value"><input type="input" name="fields[state_code]" value="<?php echo stripslashes($biz->rec["state_code"]);?>" class="tiny"></td>
		</tr>
	<tr>
		<td class="field-name">Zip:</td>
		<td class="field-value"><input type="input" name="fields[zip]" value="<?php echo stripslashes($biz->rec["zip"]);?>" class="short"></td>
		</tr>
	<tr>
		<td class="field-name">Latitude:</td>
		<td class="field-value"><input type="text" name="latitude" value="<?php echo stripslashes($biz->rec["latitude"]);?>" class="form" readonly style="border: 0;"></td>
		</tr>
	<tr>
		<td class="field-name">Longitude:</td>
		<td class="field-value"><input type="text" name="longitude" value="<?php echo stripslashes($biz->rec["longitude"]);?>" class="form" readonly style="border: 0;"></td>
		</tr>
	<tr>
		<td class="field-name"></td>
		<td class="field-value"><input type="button" value="Get Coordinates" onClick="GetCoordinates();"></td>
		</tr>
	</table>
<br/>
<table class="form">
	<tr>
		<td class="field-name">Phone Number:</td>
		<td class="field-value"><input type="input" name="fields[phone]" value="<?php echo stripslashes($biz->rec["phone"]);?>"></td>
		</tr>
	<tr>
		<td class="field-name">Web Address:</td>
		<td class="field-value"><input type="input" name="fields[web_address]" value="<?php echo stripslashes($biz->rec["web_address"]);?>" class="text"></td>
		</tr>
	<tr>
		<td class="field-name">Email Address:</td>
		<td class="field-value"><input type="input" name="fields[email_address]" value="<?php echo stripslashes($biz->rec["email_address"]);?>" class="text"></td>
		</tr>
	<tr>
		<td class="field-name">Pin Number:</td>
		<td class="field-value"><input type="input" name="fields[b_pin]" value="<?php echo stripslashes($biz->rec["b_pin"]);?>" class="text"></td>
		</tr>
	</table>
<br/>

<h4>Bid Amount & Search Terms</h4>
<p>When you list search terms, it is a good idea to list as many terms that are relivent and specific to
the company that you can think of that will help a viewer find this company.  For instance, "food" would not be
a very good search term.  Instead, put the type of food like "pizza" or "taco" or "pasta".  When listing search terms,
be sure to separate each term with a space.  Listing a term more than once will not promote the term to any higher level.
Search results and category listings will be sorted in order by the "Bid Amount".  The highest bid amount will be sorted
on top.</p>

<table class="form">
	<tr>
		<td class="field-name">Bid Amount:</td>
		<td class="field-value"><input type="input" name="fields[bid]" value="<?php echo stripslashes($biz->rec["bid"]);?>" class="small"></td>
		</tr>
	<tr>
		<td class="field-name">Search Terms:</td>
		<td class="field-value"><textarea name="search_terms" style="width:500px; height:100px;"><?php echo stripslashes($biz->rec["search_terms"]);?></textarea></td>
		</tr>
	</table>
<br/>

<h4>Service Directory</h4>
<p>The Service Directory is a directory of local businesses that offer valuable services to the community.  This page stands alone from the rest of marketplace
and can be used as a very valuable tool for the community as well as generate an additional revenue stream for advertising.</p>

<table class="form">
	<tr>
		<td class="field-name">Category:</td>
		<td class="field-value"><?php echo $biz->getServiceDirectories(); ?></td>
		</tr>
	<tr>
		<td class="field-name">Or New Category:</td>
		<td class="field-value"><input type="input" name="new_sd_cat" value="<?php echo stripslashes($_POST["new_sd_cat"]);?>" class="text"></td>
		</tr>
	<tr>
		<td class="field-name">Profile:</td>
		<td class="field-value"><textarea name="fields[sd_profile]" style="width:500px; height:100px;"><?php echo stripslashes($biz->rec["sd_profile"]);?></textarea></td>
		</tr>
	</table>
<br/>

<h4>Business Hours</h4>
<table class="form">
	<tr>
		<td class="field-name">Business Hours: <a href="#" onmouseover="drc('If this option is turned on, this company\'s business hours will be visible.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[business_hours_flag]" value="1"<?php echo $business_hours_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[business_hours_flag]" value="0"<?php echo $business_hours_flag_option[0];?>> Off</td>
		</tr>
	<?php echo $biz->buildBusinessForm(); ?>
	</table>
<br/>



<input type="submit" name="submit" value="Update">
<input type="hidden" name="id" value="<?php echo $_REQUEST["id"];?>">


</form>

<?php getFooter("admin"); ?>