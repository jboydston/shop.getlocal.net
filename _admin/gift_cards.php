<?php

$access_level = 9;

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;
include CLASS_GIFT_CARDS;

$biz = new handleBusiness;
$gcard = new handleGiftCards;

$gcard->id = $biz->rec["record_id"];

$preload_restrictions = pullTemplates("standard.restrictions.giftcards.php");

if(isset($_POST["submit"])){
	if(trim($_POST["fields"]["name"]) != "") $gcard->createGiftCards();
	header("location:".$_SERVER["PHP_SELF"]."?id=".$biz->rec["record_id"]."&m=1");
	exit;
	}

if(isset($_GET["m"])){
	$mess[1] = "1 Gift Cards have been created.";
	$message = $mess[$_GET["m"]];
	}


?>

<?php getHeader("admin"); ?>

<script type="text/javascript" src="<?php echo PATHTOHTML.PATHTOADMIN; ?>/ckeditor/ckeditor.js"></script>

<h3>Manage Gift Cards</h3>

<?php echo $biz->buildCard(); ?>

<?php echo buildMessage($message); ?>

<form action="<?php echo $_SERVER["PHP_SELF"];?>?id=<?php echo $_GET["id"];?>" method="post">

<h4>Gift Card</h4>

<a onclick="document.getElementById('new_giftcard').style.display='block';" class="field-info expandable-link">CREATE NEW GIFT CARDS</a>

<table class="form" id="new_giftcard" style="display: none;">
	<tr>
		<td class="field-name">Name:</td>
		<td class="field-value"><input type="input" name="fields[name]" value="<?php echo stripslashes($_POST["fields"]["name"]);?>" class="text"></td>
		</tr>
	<tr>
		<td class="field-name">Quantity:</td>
		<td class="field-value"><select name="fields[quantity]"><?php $rem_quantity[$_POST["fields"]["quantity"]]="selected"; for($i=1;$i<=50;$i++) echo "<option value=\"".$i."\" ".$rem_quantity[$i].">".number_format($i)."</option>"; ?></select></td>
		</tr>
	<tr>
		<td class="field-name">Face Value:</td>
		<td class="field-value"><select name="fields[face_value]"><?php $rem_face_value[$_POST["fields"]["face_value"]]="selected"; for($i=1;$i<=500;$i++) echo "<option value=\"".$i."\" ".$rem_face_value[$i].">\$".number_format($i)."</option>"; ?></select></td>
		</tr>
	<tr>
		<td class="field-name">Price to Purchase:</td>
		<td class="field-value"><select name="fields[cost]"><?php $rem_cost[$_POST["fields"]["cost"]]="selected"; for($i=1;$i<=500;$i++) echo "<option value=\"".$i."\" ".$rem_cost[$i].">\$".number_format($i)."</option>"; ?></select></td>
		</tr>
	<tr>
		<td class="field-name">Category:</td>
		<td class="field-value"><select name="fields[category]"><?php $rem_category[$_POST["fields"]["category"]]="selected"; echo $gcard->getCategoriesOption(); ?></select> &nbsp;&nbsp; <a href="general_categories.php" class="field-info expandable-link">EDIT CATEGORIES</a></td>
		</tr>
	<tr>
		<td class="field-name">Restrictions:</td>
		<td class="field-value"><textarea name="fields[restrictions]"><?php echo $preload_restrictions["content"];?></textarea><script type="text/javascript"> CKEDITOR.replace('fields[restrictions]', { height : '300', toolbar : 'MyToolbarShort'}); </script></td>
		</tr>
	<tr>
		<td class="field-name"></td>
		<td class="field-value"><input type="submit" name="submit" value="Create"> &nbsp;&nbsp; 
		<a onclick="document.getElementById('new_giftcard').style.display='none';" class="field-info expandable-link">CLOSE</a>
		</td>
		</tr>
	</table>

<h4>Current Gift Cards</h4>

<?php echo $gcard->getGiftCards(); ?>



</form>

<?php getFooter("admin"); ?>