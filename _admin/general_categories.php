<?php

$access_level = 9;

require "_globals.php";
require SECURITY;

include CLASS_GENERAL_CATEGORIES;

$cat = new handleCategories;


if(isset($_POST["submit"])){
	$values = explode("\r\n", $_POST["categories"]);
	$cat->saveCategories($values);
	}

if(isset($_GET["m"])){
	$mess[1] = "1 Gift Cards have been created.";
	$message = $mess[$_GET["m"]];
	}

?>

<?php getHeader("admin"); ?>

<h3>Manage General Categories</h3>

<?php echo buildMessage($message); ?>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">

<h4>Categories</h4>

<p>The box below acts like a text editor.  To edit categories, click any where in the box, and you should see a cursor appear.  You can add additional 
categories or delete existing ones.  Each category must be separated by a "return" (new line).  Once you are done, click on "Save Changes".  The list will
automatically be sorted by alphabetically once changes have been saved.</p>

<input type="submit" name="submit" value="Save Changes">
<input type="reset" value="Reset Fields">
<textarea name="categories" class="cat-box"><?php echo $cat->getCategories();?></textarea>



</form>

<?php getFooter("admin"); ?>