<?php

$access_level = 9;

require "_globals.php";
require SECURITY;

if(isset($_POST["submit"])){
	$user->rec = $_POST;
		$rem_access[$user->rec["access"]] = "checked";
		$message = $user->checkUsername();
		if($message == "") $message = $user->checkPasswords($_POST["password"],$_POST["passwordconfirm"]);
		if($message == ""){
			if($_POST["id"] == "") $user->insertUser();
			else $user->id = $_POST["id"];
			$user->updateUser();
			$user->updatePassword($_POST["password"]);
			header("location: ".$_SERVER["PHP_SELF"]."?m=1&id=".$user->rec["id"]);
			exit;
			}
	}elseif($_GET["id"]){
	$user->loadUser($_GET["id"]);
	$rem_access[$user->rec["access"]] = "checked";
	$editpasstitle = "New ";
	}else{
	$rem_access[1] = "checked";
	}
	

if(isset($_GET["m"])){
	$mess[1] = "1 User created/updated successfully.";
	$message = $mess[$_GET["m"]];
	}



?>

<?php getHeader("admin"); ?>

<h3>Manage Users</h3>

<?php echo buildMessage($message); ?>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

<h4>Create/Edit a user</h4>

<table class="form">
	<tr>
		<td class="field-name">User Name:</td>
		<td class="field-value"><input type="text" name="username" value="<?php echo stripslashes($user->rec["username"]); ?>" class="text"></td>
		</tr>
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
		<td class="field-name"><?php echo $editpasstitle; ?>Password:</td>
		<td class="field-value"><input type="password" name="password" class="text"></td>
		</tr>
	<tr>
		<td class="field-name">Confirm Password:</td>
		<td class="field-value"><input type="password" name="passwordconfirm" class="text"></td>
		</tr>
	</table>


<h4>Account Permissions</h4>

<p>Administrator accounts have permissions to add new users or update existing users.  They also have permission to set access levels.</p>

<input type="radio" name="access" value="1" <?php echo $rem_access[1];?>> USER - Access to read and edit general marketplace information.<br/>
<input type="radio" name="access" value="5" <?php echo $rem_access[5];?>> ACCOUNTING - Account to access report information.<br/>
<input type="radio" name="access" value="9" <?php echo $rem_access[9];?>> ADMINISTRATOR - Access to all features of marketplace including create/modify users and add gift cards.<br/>

<p><input type="submit" name="submit" value="Submit"></p>
<input type="hidden" name="id" value="<?php echo $user->rec["id"];?>">

</form>


<?php getFooter("admin"); ?>