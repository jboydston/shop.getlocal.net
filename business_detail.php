<?php

require "_admin/_globals.php";
require CLASS_MP_BUSINESS;
require CLASS_ADS;

$biz = new handleBusiness;
$ads = new handleAds;

$map_pointer[] = array("latitude" => $biz->rec["latitude"], "longitude" => $biz->rec["longitude"]);

if($biz->rec["full_address"] != "")      $build .= $biz->rec["full_address"]." ";
if($biz->rec["city_name"] != "")         $build .= $biz->rec["city_name"]." ";
if($biz->rec["state_code"] != "")        $build .= $biz->rec["state_code"]." ";
if($biz->rec["zip"] != "")               $build .= $biz->rec["zip"]." &nbsp;&nbsp;";
if($biz->rec["phone"] != "")             $build .= fixPhone($biz->rec["phone"])." &nbsp;&nbsp;";
if(trim($biz->rec["web_address"]) != "") $build .= "<a href=\"goto.php?id=".$biz->rec["record_id"]."&t=w\" class=\"medium blue underline\" target=\"_blank\">Visit Web Site</a> &nbsp;&nbsp;\r\n";
if($biz->rec["sponsor_flag"] != "")      $build .= "<br/><b><i>Sponsored Listing</i></b>\r\n";

$page_title       = PAGETITLE.": ".$biz->rec["business_name"]." ".fixPhone($biz->rec["phone"]);
$page_keywords    = $biz->rec["search_terms"]." ".$biz->rec["full_address"]." ".$biz->rec["city_name"]." ".$biz->rec["state_code"]." ".$biz->rec["zip"];
$page_description = $biz->rec["profile_text"]." ".PAGE_DESCRIPTION;

?>

<?php getHeader("public","yes"); ?>

	<?php echo $biz->buildBreadTrail("cat"); ?>
	<div style="display: block; float: right; width: 300px;">
		<div id="map" style="height:300px;margin-bottom:20px;"></div>
		<div class="coupon-box"><?php echo $ads->buildAd(300); ?></div>
		</div>
	<div style="display: block; float: left; width: 690px;">
		<p style="font-size:32px; margin-bottom: 0px;"><?php echo $biz->rec["business_name"]; ?></p>
		<p class="medium blue"><?php echo $build; ?></p>
		<?php	echo $biz->getIcons($rec["icons"]); ?>	



<script>
//<!--
function hideTabs(){
	for(i=1;i<8;i++){
		var tabid = 'tabcontent'+i;
		if(document.getElementById(tabid)){
			document.getElementById(tabid).style.display = 'none';
			}
		}
	}
function showTab(tabname){
	document.getElementById(tabname).style.display = 'block';
	}
// -->
</script>



<?php
$tab = $biz->buildContentTabs();
if(is_array($tab)){
	foreach($tab as $key => $value){
		$build_tab_header  .= "<div class=\"tab\"><a onclick=\"hideTabs(); showTab('tabcontent".$key."');\">".$value["header"]."</a></div>\r";
		$build_tab_content .= "<div id=\"tabcontent".$key."\" style=\"display:none;\" class=\"tabcontent\">".$value["content"]."</div>\r";
		}
	}


?>
	<div class="tab"><a onclick="hideTabs(); showTab('tabcontent1');">Information</a></div>
	<?php echo $build_tab_header; ?>

	<div id="tabcontent1" style="display:block;" class="tabcontent">
		<div class="building-block"><?php if($biz->rec["sponsor_flag"] == "1") echo $biz->getMedia("sponsor"); ?></div>
		<div class="building-block"><?php if($biz->rec["business_hours_flag"] == "1") echo $biz->showBusinessHours($biz->rec["business_hours"]); ?></div>
		<div class="building-block small">Is this your company?  Increase interest by adding a company profile. <a href="contact_us.php" class="small bold blue">Click here</a> to contact a representative.</div>
		<br style="display: block;clear: both;"/>
		</div>
	<?php echo $build_tab_content; ?>

	</div>

<?php getFooter("public"); ?>