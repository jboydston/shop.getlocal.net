<?php

$access_level = 9;

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;
include CLASS_GIFT_CARDS;

$biz = new handleBusiness;
$gcard = new handleGiftCards;

$gcard->id = $biz->rec["record_id"];
$gcard->loadCard();

if(isset($_POST["submit"])){
	$gcard->updateData("status",$_POST["status"],$gcard->rec["id"]);
	$gcard->updateData("category",$_POST["category"],$gcard->rec["id"]);
	if($_POST["change_series"] == "on") $gcard->updateSeriesCategory();
	if($_POST["status"] != "1") $gcard->updateNotes($user->user_info[1]." changed status to ".$giftcard_status[$_POST["status"]]."<br/>\n");
	header("location:".$_SERVER["PHP_SELF"]."?id=".$biz->rec["record_id"]."&cid=".$gcard->rec["id"]."&key=".$gcard->rec["key"]."&m=1");
	exit;
	}

if(isset($_GET["m"])){
	$mess[1] = "1 Gift Card have been updated.";
	$message = $mess[$_GET["m"]];
	}

?>

<?php getHeader("admin"); ?>

<h3>Manage Gift Card</h3>

<?php echo $biz->buildCard(); ?>

<?php echo buildMessage($message); ?>

<form action="<?php echo $_SERVER["PHP_SELF"];?>?id=<?php echo $_GET["id"];?>&cid=<?php echo $_GET["cid"];?>&key=<?php echo $_GET["key"];?>" method="post">

<h4>Title: <?php echo stripslashes($gcard->rec["name"]); ?></h4>

<table class="form">
	<tr>
		<td class="field-name">Category:</td>
		<td class="field-value"><?php echo $gcard->rec["category_name"];?> <?php echo $gcard->editCategory();?></td>
		</tr>
	<tr>
		<td class="field-name">Face Value:</td>
		<td class="field-value">$<?php echo number_format($gcard->rec["value"],2);?></td>
		</tr>
	<tr>
		<td class="field-name">Price to Purchase:</td>
		<td class="field-value">$<?php echo number_format($gcard->rec["price"],2);?></td>
		</tr>
	<tr>
		<td class="field-name">Date Created:</td>
		<td class="field-value"><?php echo fixDate($gcard->rec["date_created"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Status:</td>
		<td class="field-value"><?php echo $gcard->editStatus();?></td>
		</tr>
	<tr>
		<td class="field-name">Notes:</td>
		<td class="field-value"><?php echo $gcard->rec["notes"];?></td>
		</tr>
	</table>

<h4>Purchasing Information</h4>

<?php echo $gcard->getPurchaseInfo();?>

</form>

<?php getFooter("admin"); ?>