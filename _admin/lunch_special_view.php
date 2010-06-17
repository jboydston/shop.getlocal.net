<?php

require "_globals.php";
require SECURITY;
require ADCHEATSHEET;
require CLASS_LUNCHSPECIAL;

$lunch = new handleLunchSpecial;

?>

<?php getHeader("admin"); ?>

<h3>Lunch Specials</h3>

<table class="form">
	<tr>
		<td class="field-name">Date:</td>
		<td class="field-value"><?php echo fixDate($lunch->date); ?></td>
		<td></td>
	</tr>
	<tr>
		<td class="field-name">Views:</td>
		<td class="field-value"><?php echo number_format($lunch->views);?></td>
		<td></td>
	</tr>
	<tr>
		<td class="field-name">Options:</td>
		<td class="field-value"><a href="lunch_special_manage.php?menuid=<?php echo $lunch->menuid;?>">Edit</a></td>
		<td></td>
	</tr>
</table>

<table class="form">
	<?php echo $lunch->buildView(); ?>
</table>

</form>

<?php getFooter("admin"); ?>