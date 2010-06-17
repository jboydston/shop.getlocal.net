<?php

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;
	
$biz = new handleBusiness;

if(isset($_POST["submit"])){
	if($_POST["category_select"] == "") $message = "2 Please select a category.  Categories were not updated.";
	else{
		if(true === $biz->updateData($_POST["category_number"], $_POST["category_select"], $_GET["id"])) $message = "1 Category has been updated successfully.  You should see the update reflected below.";
		else $message = "2 There was an error updating this category.";
		$biz->__construct();
		}
	}

if(isset($_GET["remove"])){
	$message = "2 There was an error removing this category.  Categories were not updated.";
	if(true === $biz->updateData($_GET["remove"],"",$_GET["id"])) $message = "1 Category has been removed.  You should see the update reflected below.";
	$biz->__construct();
	}

?>

<?php getHeader("admin"); ?>

<h3>Update Company Categories</h3>

<?php echo $biz->buildCard(); ?>

<?php echo buildMessage($message); ?>

<p>Each company can have up to six categories that they can be placed.  You don't have to use all six, but the more categories you select will increase this company's visibility.</p>

<h4>Categories</h4>
<table class="form">
	<tr>
		<td class="field-name">Category #1:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_1"], "sic_1");?></td>
		</tr>
	<tr>
		<td class="field-name">Category #2:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_2"], "sic_2");?></td>
		</tr>
	<tr>
		<td class="field-name">Category #3:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_3"], "sic_3");?></td>
		</tr>
	<tr>
		<td class="field-name">Category #4:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_4"], "sic_4");?></td>
		</tr>
	<tr>
		<td class="field-name">Category #5:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_5"], "sic_5");?></td>
		</tr>
	<tr>
		<td class="field-name">Category #6:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_6"], "sic_6");?></td>
		</tr>
	</table>


<h4>Select Categories</h4>


<form method="post" action="<?=$PHP_SELF?>?id=<?php echo $_GET["id"];?>">

<p><select name="category_number">
	<?php $rem_cat[$_POST["category_number"]] = "selected"; ?>
	<option value="sic_1" <?php echo $rem_cat["sic_1"]; ?>>Category #1</option>
	<option value="sic_2" <?php echo $rem_cat["sic_2"]; ?>>Category #2</option>
	<option value="sic_3" <?php echo $rem_cat["sic_3"]; ?>>Category #3</option>
	<option value="sic_4" <?php echo $rem_cat["sic_4"]; ?>>Category #4</option>
	<option value="sic_5" <?php echo $rem_cat["sic_5"]; ?>>Category #5</option>
	<option value="sic_6" <?php echo $rem_cat["sic_6"]; ?>>Category #6</option>
	</select></p>

<p>You can filter the categories by typing in the space below.</p>
<input name="filter" value="<?php echo stripslashes($_POST["filter"]); ?>">
<input type="submit" name="filter_cats" value="Filter">
</form>

<form method="post" action="<?=$PHP_SELF?>?id=<?php echo $_GET["id"];?>">
<select name="category_select" style="width:650px;margin: 10px 0px;display:block;clear:both;" size="16">
	<?php echo $biz->listCategories();?>
	</select>

<input type="submit" name="submit" value="Submit">
<input type="hidden" name="category_number" value="<?php echo $_POST["category_number"]; ?>">
<input type="hidden" name="filter" value="<?php echo $_POST["filter"]; ?>">

</form>

<?php getFooter("admin"); ?>