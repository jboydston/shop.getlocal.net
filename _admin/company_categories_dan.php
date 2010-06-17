<?php

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;
	
$biz = new handleBusiness;


if(isset($_GET["submit"])){
	if($_GET["category_select"] == "") $message = "2 Please select a category.  Categories were not updated.";
	else{
		if(true === $biz->updateData($_GET["category_number"], $_GET["category_select"], $_GET["id"])) $message = "1 Category has been updated successfully.  You should see the update reflected below.";
		else $message = "2 There was an error updating this category.";
		$biz->__construct();
		}
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
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_1"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Category #2:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_2"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Category #3:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_3"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Category #4:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_4"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Category #5:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_5"]);?></td>
		</tr>
	<tr>
		<td class="field-name">Category #6:</td>
		<td class="field-value"><?php echo $biz->showCategory($biz->rec["sic_6"]);?></td>
		</tr>
	</table>


<h4>Select Categories</h4>


<form name="myform" method="get" action="<?=$PHP_SELF?>">

<p><select name="category_number">
	<option value="sic_1">Category #1</option>
	<option value="sic_2">Category #2</option>
	<option value="sic_3">Category #3</option>
	<option value="sic_4">Category #4</option>
	<option value="sic_5">Category #5</option>
	<option value="sic_6">Category #6</option>
	</select></p>

<p>You can filter the categories by typing in the space below.</p>
<input name="filter" value="<?php echo stripslashes($_GET["filter"]); ?>">
<input type="button" onClick="filterList(this.form.filter.value)" value="Filter">
<input type="button" onClick="this.form.filter.value=''" value="Clear">


<div id="category_list" name="category_list" style="height:400px;width:650px;"></div>

<script type="text/javascript">

function filterList(findme){
	var arrayvalues = new Array();
	arrayvalues["find_cat"] = findme;
	arrayvalues["selectbox_action"] = "filter_select";
	new Ajax.Updater("category_list", "<?php echo JAVASCRIPTDIR; ?>/filterlist.php", {parameters:arrayvalues,method:"get"});
	}



</script>







<input type="submit" name="submit" value="Submit">
<input type="hidden" name="id" value="<?php echo $_REQUEST["id"];?>">

	</form>

<?php getFooter("admin"); ?>