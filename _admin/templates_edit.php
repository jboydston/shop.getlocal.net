<?php

require "_globals.php";
require SECURITY;

if(isset($_POST["submit"])){
	saveTemplate($_POST["template_select"]);
	$message = "1 Template has been updated.";
	}

$options = pullTemplates($_POST["template_select"]);

?>

<?php getHeader("admin"); ?>

<script type="text/javascript" src="<?php echo PATHTOHTML.PATHTOADMIN; ?>/ckeditor/ckeditor.js"></script>

<h3>Edit Report & Mail Templates</h3>

<?php echo buildMessage($message); ?>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
<h4>Templates</h4>

<table class="form">
	<tr>
		<td class="field-name">Select Template:</td>
		<td class="field-value"><?php echo $options["dropdown"]; ?> <input type="submit" name="file_select" value="Load"></td>
		</tr>
	</table>
</form>

<br/>
<br/>
<br/>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
Template Name: <input type="text" name="header" class="text" value="<?php echo $options["header"];?>"><br/>
<br/>
<textarea name="template_content"><?php echo $options["content"];?></textarea>
<script type="text/javascript"> CKEDITOR.replace('template_content'); </script>

<br/>
<br/>


<input type="submit" name="submit" value="Save">
<input type="hidden" name="template_select" value="<?php echo $_REQUEST["template_select"];?>">
</form>

<?php getFooter("admin"); ?>