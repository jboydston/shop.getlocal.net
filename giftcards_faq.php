<?php

require "_admin/_globals.php";
require CLASS_ADS;
$ads = new handleAds;

?>

<?php getHeader("public"); ?>

<div id="link-column-container">
	</div>
<div id="content-column-content">
	<div class="content-title">Gift Cards FAQ's</div>
	<div style="margin: 20px;"><?php echo loadTemplate("faq.giftcards.php"); ?></div>
	</div>
<div id="side-column">
	<a href="coupons.php" class="small white"><img src="<?php echo IMAGEDIR; ?>/view_all_coupons.jpg" border=0 style="margin-top:10px;"></a>
	<p class="medium white"><?php echo $ads->num_coupons;?> total coupons!</p>
	<div class="coupon-box"><?php echo $ads->buildAd(200); ?></div>
	<div class="coupon-box"><?php echo $ads->buildAd(200); ?></div>
	</div>

<?php getFooter("public"); ?>