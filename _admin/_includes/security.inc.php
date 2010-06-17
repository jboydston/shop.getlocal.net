<?php

include CLASS_USERS;
$user = new handleUser;
if(isset($_GET["logout"])) $user->logOut();

if(false == $user->authUser()){
	$_SESSION[P_SESSION_ID] = "";
	setcookie(P_SESSION_ID, "", -1);
	session_destroy();
	header("location: index.php?m=2");
	exit;
	}

if($access_level != null){
	if($access_level > $user->user_info[2]){
		header("location: noaccess.php");
		exit;
		}
	}

?>