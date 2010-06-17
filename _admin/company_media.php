<?php

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;
	
$biz = new handleBusiness;

if(isset($_POST["submit"])){
	foreach($_POST["fields"] as $db_field => $db_value) $biz->updateData($db_field, $db_value, $_GET["id"]);
	$biz->saveMedia();
	$biz->__construct();
	}

if(isset($_GET["remove"]))  $biz->removeMedia($_GET["remove"]);

$sponsor_flag_option[$biz->rec["sponsor_flag"]] = " checked";
$gallery_flag_option[$biz->rec["gallery_flag"]] = " checked";
$video_flag_option[$biz->rec["video_flag"]]     = " checked";

?>

<?php getHeader("admin"); ?>

<h3>Viewing Company Media</h3>

<?php echo $biz->buildCard(); ?>


<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $_GET["id"]; ?>" method="post" enctype="multipart/form-data">

<h4>Sponsor Photo</h4>
<table class="form">
	<tr>
		<td class="field-name">Sponsored Listing: <a href="#" onmouseover="drc('A sponsored listing will rotate with other sponsored listings on the home page.  Upload a photo to enhance a sponsored listing.  It will also move the name of the company to the beginning of the list (in order of bid amount) in list views and search results.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[sponsor_flag]" value="1"<?php echo $sponsor_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[sponsor_flag]" value="0"<?php echo $sponsor_flag_option[0];?>> Off &nbsp;&nbsp;&nbsp; <input type="submit" value="Update" name="submit"></td>
		</tr>
	<tr>
		<td class="field-name">Sponsored Photo: <a href="#" onmouseover="drc('The sponsored photo will show up under the company\'s profile as well as rotate the main position on the home page.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo $biz->getMedia("sponsor","yes"); ?></td>
		</tr>
	<tr>
		<td class="field-name"></td>
		<td class="field-value"><div id="add_sponsor" style="display:none;"><input type="file" name="sponsor"> <input type="submit" value="Upload" name="submit"></div><div id="remove_sponsor" style="display:none;">Are you sure you want to remove this photo?&nbsp;&nbsp;&nbsp;<a onclick="document.getElementById('remove_sponsor').style.display='none'" class="field-info expandable-link">NO</a> <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $_GET["id"]; ?>&remove=sponsor" class="field-info expandable-link">YES</a></div></td>
		</tr>
	</table>


<h4>Gallery Photos</h4>
<table class="form">
	<tr>
		<td class="field-name">Photo Gallery Tab: <a href="#" onmouseover="drc('You can safely turn on and off the photo gallery tab without losing any of the information stored in this tab.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[gallery_flag]" value="1"<?php echo $gallery_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[gallery_flag]" value="0"<?php echo $gallery_flag_option[0];?>> Off &nbsp;&nbsp;&nbsp; <input type="submit" value="Update" name="submit"></td>
		</tr>
	<tr>
		<td class="field-name">Gallery Photo: <a href="#" onmouseover="drc('The gallery photos will show up under the company\'s profile.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo $biz->getMedia("gallery","yes"); ?></td>
		</tr>
	<tr>
		<td class="field-name"></td>
		<td class="field-value">
			<div id="add_gallery_new" style="display:none;"><input type="file" name="gallery"><input type="submit" value="Upload" name="submit"></div>
			</td>
		</tr>
	</table>



<h4>Company Videos</h4>
<table class="form">
	<tr>
		<td class="field-name">Video Listing: <a href="#" onmouseover="drc('You can turn on and off the video listing without losing the video.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><input type="radio" name="fields[video_flag]" value="1"<?php echo $video_flag_option[1];?>> On &nbsp;&nbsp;&nbsp; <input type="radio" name="fields[video_flag]" value="0"<?php echo $video_flag_option[0];?>> Off &nbsp;&nbsp;&nbsp; <input type="submit" value="Update" name="submit"></td>
		</tr>
	<tr>
		<td class="field-name">Video File: <a href="#" onmouseover="drc('If this company has a video saved in .mov format at 640px by 480px, you can add it to the video tab.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo $biz->getMedia("video","yes"); ?> <?php echo $biz->getMedia("youtube","yes"); ?></td>
		</tr>
	<tr>
		<td class="field-name"></td>
		<td class="field-value">
			<div id="add_video_new" style="display:none;"><span class="small green">UPLOAD .MOV VIDEO</span> &nbsp;<input type="file" name="video"><input type="submit" value="Upload" name="submit"><br/><br/><span class="small green">OR LINK TO YOUTUBE</span><br/><textarea name="youtube" style="margin: 4px 0px; padding: 4px; width: 500px; height: 100px;"><?php echo stripslashes($biz->rec["youtube"]); ?></textarea><br/><input type="submit" value="Submit" name="submit"></div>
			</td>
		</tr>
	</table>


</form>



<?php getFooter("admin"); ?>