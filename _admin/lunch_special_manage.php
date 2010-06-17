<?php

require "_globals.php";
require SECURITY;
require ADCHEATSHEET;
require CLASS_LUNCHSPECIAL;

$lunch = new handleLunchSpecial;

if(isset($_POST[submit])){
	$lunch->adimages  = $_POST["adselect"];
	$lunch->adheading = $_POST["adheading"];
	$lunch->adspecial = $_POST["adspecial"];
			
	if(false === ($error = $lunch->checkRequired())){
		$error = $lunch->checkDate();
		
		if($error == false){
			$lunch->updateMenu();
			header("location: ".$_SERVER["PHP_SELF"]."?menuid=".$lunch->menuid."&s=1");
			exit;
			}
		}
	}


if($_GET["s"]){
	$s_mess[1] = "You have successfully created/modified a lunch menu.";
	$success   = $s_mess[$_GET["s"]];
	}

?>

<?php getHeader("admin"); ?>

<h3>Lunch Specials</h3>

<?php if($error != false)   echo miniError($error); ?>
<?php if($success != false)   echo miniSuccess($success); ?>
	
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
<table class="form">
	<tr>
		<td class="field-name">Select Date:</td>
		<td class="field-value"><?php echo buildMonthSelect("month",substr($lunch->date,4,2)); ?> <?php echo buildDaySelect("day",substr($lunch->date,6,2)); ?> <?php echo buildYearSelect(date("Y"),date("Y")+5,"year",substr($lunch->date,0,4)); ?></td>
		<td></td>
	</tr>
</table>

<table class="form">
	<?php echo $lunch->buildForm(); ?>
</table>

<input type="submit" name="submit" value="Submit" style="margin: 20px 0 0 140px;">&nbsp;&nbsp;&nbsp;<a href="lunch_special_view.php?menuid=<?php echo $_REQUEST["menuid"]; ?>" class="black extra-small">Back To View</a>
<input type="hidden" name="menuid" value="<?php echo $_REQUEST["menuid"]; ?>">
<input type="hidden" name="numads" value="<?php echo $number_of_ads; ?>">
</form>

<?php getFooter("admin"); ?>