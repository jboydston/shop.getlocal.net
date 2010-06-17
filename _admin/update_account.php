<?php

require "_globals.php";
require SECURITY;

$user->loadUser();

if(isset($_POST["submit"])){
	if($_POST["password"] != ""){
		$message = $user->checkPasswords($_POST["password"],$_POST["passwordconfirm"]);
		if($message == "") $user->updatePassword($_POST["password"]);
		}
	if($message == ""){
		$user->updateSelf();
		header("location: ".$_SERVER["PHP_SELF"]."?m=1");
		exit;
		}
	}


if(isset($_GET["m"])){
	$mess[1] = "1 Account information updated successfully.";
	$message = $mess[$_GET["m"]];
	}


?>

<?php getHeader("admin"); ?>

<h3>Update Account</h3>

<?php echo buildMessage($message); ?>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

<h4>Update Account Information</h4>

<table class="form">
	<tr>
		<td class="field-name">First Name:</td>
		<td class="field-value"><input type="text" name="fname" value="<?php echo stripslashes($user->rec["fname"]); ?>" class="text"></td>
		</tr>
	<tr>
		<td class="field-name">Last Name:</td>
		<td class="field-value"><input type="text" name="lname" value="<?php echo stripslashes($user->rec["lname"]); ?>" class="text"></td>
		</tr>
	<tr>
		<td class="field-name">Email Address:</td>
		<td class="field-value"><input type="text" name="email" value="<?php echo stripslashes($user->rec["email"]); ?>" class="text"></td>
		</tr>
	</table>

<p>To change your password, please enter your new password.  If you do not wish to change your password, leave the password fields blank.</p>

<table class="form">
	<tr>
		<td class="field-name">Password:</td>
		<td class="field-value"><input type="password" name="password" class="text"></td>
		</tr>
	<tr>
		<td class="field-name">Confirm Password:</td>
		<td class="field-value"><input type="password" name="passwordconfirm" class="text"></td>
		</tr>
	<tr>
		<td class="field-name"></td>
		<td class="field-value"><input type="submit" name="submit" value="Submit"></td>
		</tr>
	</table>


</form>


<?php getFooter("admin"); ?>