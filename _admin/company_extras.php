<?php

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;
	
$biz = new handleBusiness;

if(isset($_POST["submit"])){
	foreach($_POST["fields"] as $db_field => $db_value) $biz->updateData($db_field, $db_value, $_POST["id"]);
	$biz->saveMedia();
	$biz->saveIcons();
	$message = "1 This listing has been updated.";
	$biz->__construct();
	}

if(isset($_GET["remove"]))  $biz->removeMedia($_GET["remove"]);

$business_hours_flag_option[$biz->rec["business_hours_flag"]] = " checked";
$bold_flag_option[$biz->rec["bold_flag"]]           = " checked";
$highlight_flag_option[$biz->rec["highlight_flag"]] = " checked";
$sponsor_flag_option[$biz->rec["sponsor_flag"]]     = " checked";
$profile_flag_option[$biz->rec["profile_flag"]]     = " checked";
$product_flag_option[$biz->rec["product_flag"]]     = " checked";
$gallery_flag_option[$biz->rec["gallery_flag"]]     = " checked";
$video_flag_option[$biz->rec["video_flag"]]         = " checked";

?>

<?php getHeader("admin"); ?>

<h3>Edit Company Extra's</h3>

<?php echo $biz->buildCard(); ?>

<?php echo buildMessage($message); ?>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
<h4>Extras</h4>
<table class="form">
	<tr>
		<td class="field-name">Business Hours: <a href="#" onmouseover="drc('If this option is turned on, this company\'s business hours will be visible.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[business_hours_flag]" value="1"<?php echo $business_hours_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[business_hours_flag]" value="0"<?php echo $business_hours_flag_option[0];?>> Off</td>
		</tr>
	<tr>
		<td class="field-name">Bold Name: <a href="#" onmouseover="drc('If this option is turned on, this company\'s name will be bolded within list view and search results.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[bold_flag]" value="1"<?php echo $bold_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[bold_flag]" value="0"<?php echo $bold_flag_option[0];?>> Off</td>
		</tr>
	<tr>
		<td class="field-name">Highlight Name: <a href="#" onmouseover="drc('If this option is turned on, this company\'s name will be highlighted within list view and search results.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[highlight_flag]" value="1"<?php echo $highlight_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[highlight_flag]" value="0"<?php echo $highlight_flag_option[0];?>> Off</td>
		</tr>
	<tr>
		<td class="field-name">Sponsored Listing: <a href="#" onmouseover="drc('A sponsored listing will rotate with other sponsored listings on the home page.  Upload a photo to enhance a sponsored listing.  It will also move the name of the company to the beginning of the list (in order of bid amount) in list views and search results.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[sponsor_flag]" value="1"<?php echo $sponsor_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[sponsor_flag]" value="0"<?php echo $sponsor_flag_option[0];?>> Off</td>
		</tr>
	<tr>
		<td class="field-name">Profile Tab: <a href="#" onmouseover="drc('You can safely turn on and off the profile tab without losing any of the information stored in this tab.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[profile_flag]" value="1"<?php echo $profile_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[profile_flag]" value="0"<?php echo $profile_flag_option[0];?>> Off</td>
		</tr>
	<tr>
		<td class="field-name">Product Tab: <a href="#" onmouseover="drc('You can safely turn on and off the product tab without losing any of the information stored in this tab.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[product_flag]" value="1"<?php echo $product_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[product_flag]" value="0"<?php echo $product_flag_option[0];?>> Off</td>
		</tr>
	<tr>
		<td class="field-name">Photo Gallery Tab: <a href="#" onmouseover="drc('You can safely turn on and off the photo gallery tab without losing any of the information stored in this tab.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[gallery_flag]" value="1"<?php echo $gallery_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[gallery_flag]" value="0"<?php echo $gallery_flag_option[0];?>> Off</td>
		</tr>
	<tr>
		<td class="field-name">Video Gallery Tab: <a href="#" onmouseover="drc('You can safely turn on and off the video gallery tab without losing any of the information stored in this tab.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[video_flag]" value="1"<?php echo $video_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[video_flag]" value="0"<?php echo $video_flag_option[0];?>> Off</td>
		</tr>
	</table>
<br/>


<h4>Business Logo</h4>
<table class="form">
	<tr>
		<td class="field-name">Business Logo: <a href="#" onmouseover="drc('The business logo is an added value feature that will help this company to stand out above the others.  Logos should fit inside a 200px by 100px box.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo $biz->getMedia("bizlogo","yes"); ?></td>
		</tr>
	<tr>
		<td class="field-name"></td>
		<td class="field-value"><div id="add_bizlogo" style="display:none;"><input type="file" name="bizlogo"> <input type="submit" value="Upload" name="submit"></div><div id="remove_bizlogo" style="display:none;">Are you sure you want to remove this logo?&nbsp;&nbsp;&nbsp;<a onclick="document.getElementById('remove_bizlogo').style.display='none'" class="field-info expandable-link">NO</a> <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $_GET["id"]; ?>&remove=bizlogo" class="field-info expandable-link">YES</a></div></td>
		</tr>
	</table>
<br/>



<h4>Icons</h4>

<p><?php echo $biz->pullIcons(); ?></p>

<br  style="display: block; clear: both; margin-bottom: 80px;"/>

<input type="submit" name="submit" value="Update">
<input type="hidden" name="id" value="<?php echo $_REQUEST["id"];?>">

</form>


<?php getFooter("admin"); ?>