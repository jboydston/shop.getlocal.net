<?php

require "_admin/_globals.php";
require CLASS_ADS;
require CLASS_GIFT_CARDS;
require CLASS_SHOPPING_CART;

$ads = new handleAds;
$gcard = new handleGiftCards;
$scart = new handleShoppingCart;

if(isset($_GET["add"])){
	$message = $scart->addToCart();
	}

if(isset($_GET["empty"])){
	$message = $scart->clearCart();
	header("location: ".$_SERVER["PHP_SELF"]);
	exit;
	}

if(isset($_GET["remove"])){
	$message = $scart->clearItem();
	header("location: ".$_SERVER["PHP_SELF"]);
	exit;
	}

?>

<?php getHeader("public"); ?>

<div id="link-column-container">
	<div id="link-column">
		<div class='white extra-large' style='display: block; clear: both; text-align: center; padding: 20px 0px 10px 0px;'>Categories</div>
		<?php echo $gcard->getCategories(); ?>
		<div class='white extra-large' style='display: block; clear: both; text-align: center; padding: 20px 0px 10px 0px;'>Deals Going Fast!</div>
		<?php echo $gcard->getDeals(); ?>
		</div>
	</div>
<div id="content-column-content">
	<div class="content-title">Gift Cards</div>
	<?php echo buildMessage($message); ?>
	<?php
	if($_GET["company"] == "" && $_GET["category"] == "") echo $gcard->buildPreview(4);
	elseif($_GET["company"] != "")  echo $gcard->buildCompanyList();
	elseif($_GET["category"] != "")  echo $gcard->buildCategoryList();
	?>
	</div>
<div id="side-column">
	<?php
	if(!is_array($_SESSION[SHOPPING_SESSION_ID])){ ?>
		<a href="coupons.php" class="small white"><img src="<?php echo IMAGEDIR; ?>/view_all_coupons.jpg" border=0 style="margin-top:10px;"></a>
		<p class="medium white"><?php echo $ads->num_coupons;?> total coupons!</p>
		<div class="coupon-box"><?php echo $ads->buildAd(200); ?></div>
		<div class="coupon-box"><?php echo $ads->buildAd(200); ?></div>
	<?php }else{ echo "<span class=\"white\">".$scart->showCart()."</span>"; } ?>
	
	</div>

<?php getFooter("public"); ?>