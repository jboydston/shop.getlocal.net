<?php

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;

$biz = new handleBusiness;

?>

<?php getHeader("admin"); ?>

<h3>Manage Gift Cards</h3>

<?php echo $biz->buildCard(); ?>

The gift card you are trying to access cannot be found.

<?php getFooter("admin"); ?>