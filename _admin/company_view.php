<?php

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;
	
$biz = new handleBusiness;
?>

<?php getHeader("admin"); ?>

<h3>Viewing Company Information</h3>

<?php echo $biz->buildCard(); ?>


<h4>Statistics</h4>
<table class="form">
	<tr>
		<td class="field-name">Company Hits: <a href="#" onmouseover="drc('Each time this company is listed either within a list, a search, home page, etc, this stat will increase by one.  This is also known as impressions.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo number_format($biz->rec["counter_list"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Profile Views: <a href="#" onmouseover="drc('Each time a viewer clicks on the company\'s listing and views the profile page, this stat will increase by one.  This is also known as pageviews.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo number_format($biz->rec["counter_view"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Web Click Thrus: <a href="#" onmouseover="drc('Each time a viewer clicks on the company\'s web address and continues on to the company\'s web site (if available), this stat will increase by one.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo number_format($biz->rec["counter_web"]);?></td>
		</tr>
	</table>


<h4>Extras <a href="company_extras.php?id=<?php echo $biz->rec["record_id"];?>" class="field-info">[ update ]</a></h4>
<table class="form">
	<tr>
		<td class="field-name">Business Hours: <a href="#" onmouseover="drc('If this option is turned on, this company\'s business hours will be visible.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo lightSwitch($biz->rec["business_hours_flag"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Bold Name: <a href="#" onmouseover="drc('If this option is turned on, this company\'s name will be bolded within list view and search results.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo lightSwitch($biz->rec["bold_flag"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Highlight Name: <a href="#" onmouseover="drc('If this option is turned on, this company\'s name will be highlighted within list view and search results.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo lightSwitch($biz->rec["highlight_flag"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Sponsored Listing: <a href="#" onmouseover="drc('A sponsored listing will rotate with other sponsored listings on the home page.  Upload a photo to enhance a sponsored listing.  It will also move the name of the company to the beginning of the list (in order of bid amount) in list views and search results.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo lightSwitch($biz->rec["sponsor_flag"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Profile Tab: <a href="#" onmouseover="drc('You can safely turn on and off the profile tab without losing any of the information stored in this tab.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo lightSwitch($biz->rec["profile_flag"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Product Tab: <a href="#" onmouseover="drc('You can safely turn on and off the product tab without losing any of the information stored in this tab.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo lightSwitch($biz->rec["product_flag"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Photo Gallery Tab: <a href="#" onmouseover="drc('You can safely turn on and off the photo gallery tab without losing any of the information stored in this tab.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo lightSwitch($biz->rec["gallery_flag"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Video Gallery Tab: <a href="#" onmouseover="drc('You can safely turn on and off the video gallery tab without losing any of the information stored in this tab.','Marketplace Help Tool'); return true;" onmouseout="nd(); return true;" class="field-info">[?]</a></td>
		<td class="field-value"><?php echo lightSwitch($biz->rec["video_flag"]);?></td>
		</tr>
	</table>


<h4>Icons <a href="company_extras.php?id=<?php echo $biz->rec["record_id"];?>" class="field-info">[ update ]</a></h4>
<table class="form">
	<tr>
		<td class="field-name">Active Icons:</td>
		<td class="field-value"><?php echo $biz->pullIcons("yes"); ?></td>
		</tr>
	</table>


<h4>Tab Information</h4>
<table class="form">
	<tr>
		<td class="field-name">Profile Text:</td>
		<td class="field-value">
			<a onclick="document.getElementById('profile_text').style.display='block'" class="field-info expandable-link">[ show ]</a>
			<a onclick="document.getElementById('profile_text').style.display='none'"  class="field-info expandable-link">[ hide ]</a>
			<a href="company_profile.php?id=<?php echo $biz->rec["record_id"];?>"      class="field-info expandable-link">[ update ]</a>
			<br/>
			<div id="profile_text" style="display:none;border:1px dotted #666;margin:5px;padding:5px;width:550px;"><?php echo $biz->rec["profile_text"];?></div></td>
		</tr>
	<tr>
		<td class="field-name">Product Text:</td>
		<td class="field-value">
			<a onclick="document.getElementById('product_text').style.display='block'" class="field-info expandable-link">[ show ]</a>
			<a onclick="document.getElementById('product_text').style.display='none'"  class="field-info expandable-link">[ hide ]</a>
			<a href="company_product.php?id=<?php echo $biz->rec["record_id"];?>"      class="field-info expandable-link">[ update ]</a>
			<br/>
			<div id="product_text" style="display:none;border:1px dotted #666;margin:5px;padding:5px;width:550px;"><?php echo $biz->rec["product_text"];?></div></td>
		</tr>
	</table>


<h4>General & Site Information <a href="company_edit.php?id=<?php echo $biz->rec["record_id"];?>" class="field-info">[ update ]</a></h4>
<table class="form">
	<tr>
		<td class="field-name">Web Address:</td>
		<td class="field-value"><?php echo $biz->rec["web_address"];?></td>
		</tr>
	<tr>
		<td class="field-name">Email Address:</td>
		<td class="field-value"><?php echo $biz->rec["email_address"];?></td>
		</tr>
	<tr>
		<td class="field-name">Latitude:</td>
		<td class="field-value"><?php echo $biz->rec["latitude"];?></td>
		</tr>
	<tr>
		<td class="field-name">Longitude:</td>
		<td class="field-value"><?php echo $biz->rec["longitude"];?></td>
		</tr>
	<tr>
		<td class="field-name">Search Terms:</td>
		<td class="field-value"><?php echo $biz->rec["search_terms"];?></td>
		</tr>
	<tr>
		<td class="field-name">Business Hours:</td>
		<td class="field-value"><?php echo $biz->showBusinessHours($biz->rec["business_hours"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Additional Notes:</td>
		<td class="field-value"><?php echo $biz->rec["notes"];?></td>
		</tr>
	</table>


<h4>Category Information <a href="company_categories.php?id=<?php echo $biz->rec["record_id"];?>" class="field-info">[ update ]</a></h4>
<table class="form">
	<tr>
		<td class="field-name">Category #1:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_1"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Category #2:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_2"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Category #3:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_3"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Category #4:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_4"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Category #5:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_5"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Category #6:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_6"]);?></td>
		</tr>
	</table>

<?php getFooter("admin"); ?>