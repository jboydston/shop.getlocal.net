<?php

require "_globals.php";
require SECURITY;

include CLASS_ICONS;
	
$icon = new handleIcons;

if(isset($_POST["submit"])){
	if($_POST["newiconname"] != ""){
		$icon->createIcon();
		$message = "1 Icon has been added.";
		}
	foreach($_FILES as $key => $values){
		if($values["error"] == 0) $icon->changeIcon($key);
		}
	}

if($_GET["remove"] == "yes"){
	$icon->updateStatus("9",$_GET["id"]);
	$message = "1 Icons has been removed.";
	}

?>

<?php getHeader("admin"); ?>

<h3>Manage Available Icons</h3>

<?php echo buildMessage($message); ?>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
<h4>Create a New Icon</h4>

<p>Icons should not be more than 100px wide and 50px tall and should be saved as either a JPG, JPEG, GIF, or PNG.</p>

<table class="form">
	<tr>
		<td class="field-name">New Icon Name:</td>
		<td class="field-value"><input type="text" name="newiconname" value=""></td>
		</tr>
	<tr>
		<td class="field-name">New Icon Image:</td>
		<td class="field-value"><input type="file" name="newicon"> <input type="submit" name="submit" value="Create"></td>
		</tr>
	</table>



<h4>Manage Icons</h4>


<p><?php echo $icon->pullIcons(); ?></p>
</form>


<?php getFooter("admin"); ?>