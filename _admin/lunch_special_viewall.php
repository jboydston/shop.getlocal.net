<?php

require "_globals.php";
require SECURITY;
require ADCHEATSHEET;
require CLASS_LUNCHSPECIAL;

$lunch = new handleLunchSpecial;

?>

<?php getHeader("admin"); ?>

<h3>Lunch Specials</h3>
<p><b>Select the date that you would like to view</b></p>

<?php echo $lunch->listSpecials(); ?>

<?php getFooter("admin"); ?>