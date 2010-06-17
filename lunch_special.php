<?php

$ads_to_display = 2;

require "_admin/_globals.php";
require CONFIG_ADS;
require AD_FILE;
require CLASS_LUNCHSPECIAL;

$lunch = new handleLunchSpecial;

$rand = $lunch->randomAds($ads_to_display, $_GET["menu"]);


?>

<?php include LUNCHHEADER; ?>


<?php

for($i=0;$i<count($rand);$i++){
	$lunch->updateAdStats($lunch->adkeys[$rand[$i]],"1");
	$build .= "<div class=\"lunch-special\">\r";
	$build .= "<div class=\"display-image\">\r";
	$build .= "<a href=\"lunch_special_print.php?id=".$lunch->adkeys[$rand[$i]]."\">";
	$build .= "<img src=\"".$lunch->adimages[$rand[$i]]."\">";
	$build .= "</a>";
	$build .= "</div>\r";
	$build .= "<div class=\"display-text\">\r";
	$build .= "<h3>".$lunch->adheading[$rand[$i]]."</h3>";
	$build .= "<p>".$lunch->adspecial[$rand[$i]]."</p>";
	$build .= "<p><a href=\"lunch_special_print.php?id=".$lunch->adkeys[$rand[$i]]."\">Print Me</a></p>";
	$build .= "</div>\r";
	$build .= "</div>\r";
	}

echo $build;

?>

<br style="display: block; clear: both; height: 1px;">

<?php include LUNCHFOOTER; ?>