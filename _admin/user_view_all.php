<?php

$access_level = 9;

require "_globals.php";
require SECURITY;

if(isset($_POST["submit"])){
	foreach($_POST["password"] as $id => $password){
		if($password != ""){
			$userid = $id;
			break;
			}
		}
	$user->rec["id"] = $userid;
	$message = $user->checkPasswords($_POST["password"][$userid],$_POST["confirm_password"][$userid]);
	if($message == ""){
		$user->updatePassword($_POST["password"][$userid]);
		header("location: ".$_SERVER["PHP_SELF"]."?m=1");
		exit;
		}
	}

if(isset($_GET["m"])){
	$mess[1] = "1 Password updated successfully.";
	$message = $mess[$_GET["m"]];
	}


?>

<?php getHeader("admin"); ?>

<h3>Manage Users</h3>

<?php echo buildMessage($message); ?>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

<h4>Create a new user</h4>

<p>To create a new user, <a href="user_manage.php">click here</a>.

<h4>Modify existing user</h4>

<table class="form">
	<tr>
		<td class="field-name">Current Users</td>
		<td class="field-value"><?php echo $user->getUserList(); ?></td>
		</tr>
	</table>


</form>


<?php getFooter("admin"); ?>