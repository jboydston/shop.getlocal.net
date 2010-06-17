<?php

require "_globals.php";
include CLASS_USERS;

$user = new handleUser;

if($_SESSION[P_SESSION_ID]){
	header("location:home.php");
	exit;
	}
	
if(isset($_GET[m])){
	$post_message[1] = "You have logged out.";
	$post_message[2] = "There was a problem accessing your account.  If you continue to see this message, please contact an administrator.";
	$message         = $post_message[$_GET[m]];
	}

if(isset($_POST["un"])) $message = $user->logInUser();
	
if(isset($message)) $show_message = "<br><span style='color:#F00;'>".$message."</span>";

?>

<html>
<head>

<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta http-equiv="content-language" content="en-us">
<meta name="rating" content="general">

</head>
<body>

If you do not have a user name or password, please contact your system administrator for access to this site.<br>

<?=$show_message?>

<pre>
<form action="index.php" method="post">
Username: <input type="text"     name="un">
Password: <input type="password" name="pw">

	  <input type="checkbox" name="rm"> Remember Me
	  
	  <input type="submit" value="Log In" id="button">
	  </form>
	  </pre>

</body>
</html>
