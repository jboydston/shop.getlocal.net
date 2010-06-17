<?php

require "_globals.php";
require SECURITY;

include CLASS_ADS;
	
if(isset($_GET["rebuild"])){
	$ads = new handleAds;
	$message = "1 Ads have been rebuilt.";
	}
	
?>

<?php getHeader("admin"); ?>

<h3>Rebuild Ad Database</h3>

<?php echo buildMessage($message); ?>

<p>Ads and coupons are automatically published anytime an ad or coupon is created or modified.  However, you can rebuild the ad database when ads get out of sync.</p>
<p>To rebuild the database, click on the below link.  You may rebuild the database as many times as you would like with out breaking anything,
but please inform a system administrator if you need to consistently rebuild the database.</p>

<a href="<?php echo $_SERVER["PHP_SELF"]; ?>?rebuild=yes">Rebuild Ad Database</a>

<?php getFooter("admin"); ?>