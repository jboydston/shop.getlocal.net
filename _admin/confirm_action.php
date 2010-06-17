<?php

require "_globals.php";
require SECURITY;

include CLASS_MP_BUSINESS;
$biz = new handleBusiness;


switch ($_GET["action"]){
  case "disable":
		$options = "<p>Are you sure you want to disable this business?</p><a href=\"".$_SERVER["PHP_SELF"]."?id=".$_GET["id"]."&action=".$_GET["action"]."&option=yes\" class=\"expandable-link\">YES</a> &nbsp;&nbsp;  <a href=\"company_view.php?id=".$_GET["id"]."\" class=\"expandable-link\">NO</a>\r\n";
		if($_GET["option"] == "yes"){
			$biz->updateStatus(2);
			$options = "<p><a href=\"".$_SERVER["PHP_SELF"]."?id=".$_GET["id"]."&action=enable&option=yes\" class=\"green\">Click here</a> to re-enable this business.</p>";
			$message = "1 Company has been disabled";
			$biz->__construct();
			}
		break;
  case "enable":
		$options = "<p>Are you sure you want to enable this business?</p><a href=\"".$_SERVER["PHP_SELF"]."?id=".$_GET["id"]."&action=".$_GET["action"]."&option=yes\" class=\"expandable-link\">YES</a> &nbsp;&nbsp;  <a href=\"company_view.php?id=".$_GET["id"]."\" class=\"expandable-link\">NO</a>\r\n";
		if($_GET["option"] == "yes"){
			$biz->updateStatus(1);
			$options = "<p><a href=\"".$_SERVER["PHP_SELF"]."?id=".$_GET["id"]."&action=disable&option=yes\" class=\"green\">Click here</a> to disable this business.</p>";
			$message = "1 Company has been enabled";
			$biz->__construct();
			}
		break;
	}


?>



<?php getHeader("admin"); ?>

<h3>Confirm Action</h3>

<?php echo $biz->buildCard(); ?>

<?php echo buildMessage($message); ?>

<?php echo $options; ?>

<?php getFooter("admin"); ?>