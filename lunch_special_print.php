<?php

$ads_to_display = 2;

require "_admin/_globals.php";
require CONFIG_ADS;
require AD_FILE;
require CLASS_LUNCHSPECIAL;

$lunch = new handleLunchSpecial;

$rand = $lunch->getAd($_GET["id"]);


?>

<?php include LUNCHHEADER; ?>


<?php

$build .= "<div class=\"lunch-special\">\r";
$build .= "<div class=\"display-image\">\r";
$build .= "<img src=\"".$lunch->adimages[$rand[$i]]."\">";
$build .= "</div>\r";
$build .= "<div class=\"display-text\">\r";
$build .= "<h3>".$lunch->adheading[$rand[$i]]."</h3>";
$build .= "<p>".$lunch->adspecial[$rand[$i]]."</p>";
$build .= "</div>\r";
$build .= "</div>\r";

echo $build;

?>

<br style="display: block; clear: both; height: 1px;">

<?php include LUNCHFOOTER; ?>