<?php

require "_admin/_globals.php";
require CLASS_ADS;

$ads = new handleAds;

$build = $ads->buildCoupons($_GET[category]);

if(is_array($build[1])){
	$options = "<a href=\"".$php_self."?category=\" class=\"blue medium\">All Coupons</a> | ";
	foreach($build[1] as $key => $value) $options .= "<a href=\"".$php_self."?category=".$key."\" class=\"blue medium\">".$key." (".$value.")</a> | ";
	$options = substr($options, 0, strlen($options)-2);	
	}
	
?>

<?php getHeader("public"); ?>

<div class="content-detail">
	
	<h5 class="gold extra-large" style="margin:0px;">Marketplace Coupons</h5>
	<h5 class="blue medium" style="margin:6px 2px;"><?=$options?></h5>
	<?=$build[0]?>

	</div>

<?php getFooter("public"); ?>
