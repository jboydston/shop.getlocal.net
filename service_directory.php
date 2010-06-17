<?php

require "_admin/_globals.php";
require CLASS_MP_BUSINESS;
require CLASS_ADS;

$biz = new handleBusiness;

$catquery = mysql_query("SELECT * FROM `".SD_TABLE_NAME."` ORDER BY `category`;");
while($catrec = mysql_fetch_assoc($catquery)){
	$sd_cats[$catrec[id]] = $catrec[category];
	$order_cat .= " `sd_cat` = '".$catrec[id]."',";
	}
$query = mysql_query("SELECT * FROM `".MP_TABLE_NAME."` WHERE `sd_cat` != '' ORDER BY ".$order_cat." `business_name` ASC;");
while($rec = mysql_fetch_assoc($query)){
	$business[$rec["sd_cat"]][] = $biz->cardSericeDirectory($rec);
	}
if(is_array($sd_cats)){
	foreach($sd_cats as $key => $value){
		if(is_array($business[$key])){
			$build_sd .= "<div class='sd-title'>".$value." - <a href=\"#top\" class=\"small white\">Back To Top</a><a name=\"".$value."\"></a></div>";
			$build_cats .= "<a href=\"#".$value."\" class='medium'>".$value."</a>";
			foreach($business[$key] as $subkey => $card){
				$build_sd .= $card."<br>";
				}
			}
		}
	}

$page_title = PAGETITLE." Service Directory";

?>

<?php getHeader("public","yes"); ?>

<div class="content-full">
	<div id="sd-column-container">
		<div id="sd-column">
			<div class='white extra-large' style='display: block; clear: both; text-align: center; padding: 20px 0px 10px 0px;'>Service Directory</div>
			<?=$build_cats?>
			</div>
		</div>
	<div id="sd-content">
		<h3>Service Directory</h3>
		<?=$build_sd?>
		</div>
	</div>

<?php getFooter("public"); ?>