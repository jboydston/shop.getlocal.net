<?php

require "_admin/_globals.php";
require CLASS_MP_BUSINESS;
require CLASS_ADS;

$biz = new handleBusiness;
$ads = new handleAds;

$link_bar = listHomeCats($index_page);

?>

<?php getHeader("public"); ?>

<div id="link-column-container">
	<div id="link-column"><?php echo $link_bar;?></div>
	<div id="top-3-column"><?php echo $biz->mostRequested();?></div>
	<div class='white small' style='display: block; clear: both; text-align: center; padding: 10px 0px 10px 0px;'><?php echo COPYRIGHT; ?></div>
	</div>
<div id="content-column-content">
	<div class="content-title">Featured Merchant</div>
	<div id="content-column"><?php echo $biz->randBusinessSelect(); ?></div>
	<div class="content-title">Recent Searches</div>
	<div id="content-column-search">
		<div class="recent-search-box" style="margin-right: 20px;"><?php echo showSearchBusiness();?></div>
		<div class="recent-search-box"><span class="black large">Last 5 searches</span><br/><?php echo showRecentSearch();?></div>
		</div>
	</div>
<div id="side-column">
	<a href="coupons.php" class="small white"><img src="<?php echo IMAGEDIR; ?>/view_all_coupons.jpg" border=0 style="margin-top:10px;"></a>
	<p class="medium white"><?php echo $ads->num_coupons;?> total coupons!</p>
	<div class="coupon-box"><?php echo $ads->buildAd(200); ?></div>
	<div class="coupon-box"><?php echo $ads->buildAd(200); ?></div>
	</div>

<?php getFooter("public"); ?>