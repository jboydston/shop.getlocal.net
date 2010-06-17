<?php

class handleUser{
	public $user_info, $rec;
	
	function __construct(){
		if(isset($_COOKIE[P_SESSION_ID])) $_SESSION[P_SESSION_ID] = $_COOKIE[P_SESSION_ID];
		if($_SESSION[P_SESSION_ID] != "") $this->user_info = explode("|", $_SESSION[P_SESSION_ID]);
		return;
		}

	function logInUser(){
		$message = "Please enter a user name and password.";
		if($_POST["un"] != "" && $_POST["pw"] != ""){					
			$message = "Bad username or password.";
			if($this->createSession($_POST["un"], $_POST["pw"], $_POST["rm"])){
				header("location: home.php");
				exit;
				}
			}
		return($message);
		}

	function createSession($un, $pw, $rm="off"){
		$query_statement = "SELECT * FROM `".ADMIN_TABLE_NAME."` WHERE `username` = '".addslashes($un)."';";
		$query = mysql_query($query_statement);
		if(mysql_num_rows($query) == 1){
			$rec = mysql_fetch_assoc($query);
			$pw_crypt = $this->cryptPassword($pw);
			if($pw_crypt == $rec["password"]){			
				$_SESSION[P_SESSION_ID] = $rec["id"]."|".$rec["fname"]." ".$rec["lname"]."|".$rec["access"];
				if($rm == "on") setcookie(P_SESSION_ID, $_SESSION[P_SESSION_ID], time()+315360000);
				return(true);
				}
			}
		return(false);
		}

	function cryptPassword($password){
		$pass = crypt($password,PASSWORDSEED);
		return($pass);
		}

	function authUser(){
		$query_statement = "SELECT * FROM `".ADMIN_TABLE_NAME."` WHERE `id` = '".$this->user_info[0]."';";
		$query = mysql_query($query_statement);
		if(mysql_num_rows($query) == 1) return(true);
		return(false);
		}

	function logOut(){	
		$_SESSION[P_SESSION_ID] = "";
		setcookie(P_SESSION_ID, "", -1);
		session_destroy();
		header("location: index.php?m=1");
		exit;
		return;
		}


	function loadUser($user_id=false){
		$id = $this->user_info[0];
		if($user_id !== false) $id = $user_id;
		$query_statement = "SELECT * FROM `".ADMIN_TABLE_NAME."` WHERE `id` = '".$id."';";
		$query = mysql_query($query_statement);
		$this->rec = mysql_fetch_assoc($query);
		return($build);
		}

	function getUserList(){
		global $account_status;
		$query_statement = "SELECT * FROM `".ADMIN_TABLE_NAME."`;";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query)){
			$build .= "<div style=\"display:block; clear:both;margin-bottom:10px;\">".$rec["fname"]." ".$rec["lname"]." &nbsp;&nbsp;&nbsp; \n";
			
			$build .= "<a onclick=\"document.getElementById('details_".$rec["id"]."').style.display='block'; document.getElementById('remove_".$rec["id"]."').style.display='none'\" class=\"field-info expandable-link\">DETAILS</a> &nbsp;&nbsp;";
			$build .= "<a href=\"user_manage.php?id=".$rec["id"]."\" class=\"field-info expandable-link\">EDIT</a> &nbsp;&nbsp;";

			$build .= "<div id=\"details_".$rec["id"]."\" style=\"display:none; margin: 10px 0px 10px 0px; padding: 20px; border: 1px dotted #000;\">";
			$build .= "Status: ".$account_status[$rec["status"]]."<br/>";
			$build .= "Email: ".$rec["email"]."<br/>";
			$build .= "Username: ".$rec["username"]."<br/>";
			$build .= "Password:  <a onclick=\"document.getElementById('pass_".$rec["id"]."').style.display='block';\" class=\"field-info expandable-link\">UPDATE PASSWORD</a> &nbsp;&nbsp;";
			$build .= "<div id=\"pass_".$rec["id"]."\" style=\"display:none;margin: 10px 0px; border: 1px dotted #000;padding:10px; background-color: #d6eed8;\">";
			$build .= "<table>";
			$build .= "<tr><td>New Password:</td><td><input type=\"password\" name=\"password[".$rec["id"]."]\"></td></tr>";
			$build .= "<tr><td>Confirm Password:</td><td><input type=\"password\" name=\"confirm_password[".$rec["id"]."]\"></td></tr>";
			$build .= "<tr><td></td><td><input type=\"submit\" value=\"Update\" name=\"submit\"> &nbsp;&nbsp; <a href=\"".$_SERVER["PHP_SELF"]."\" class=\"field-info expandable-link\">CANCEL</a></td></tr>";
			$build .= "</tr></table>";
			$build .= "</div>";
			$build .= "<br/><a onclick=\"document.getElementById('details_".$rec["id"]."').style.display='none'\" class=\"field-info expandable-link\">HIDE DETAILS</a> &nbsp;&nbsp;";
			$build .= "</div></div>";

			}
		return($build);
		}
	
	function checkUsername($match=false){
		$return = "2 Please insert a username.";
		if(trim($_POST["username"]) != ""){
			$return = "2 That username is already taken.  Please choose another username.";
			$query_statement = "SELECT `username` FROM `".ADMIN_TABLE_NAME."` WHERE `username` = '".addslashes($_POST["username"])."' AND `id` != '".addslashes($_POST["id"])."';";
			$query = mysql_query($query_statement);
			if(mysql_num_rows($query) == 0) return;
			}
		return($return);
		}
				
	function checkPasswords($pass1,$pass2){
		$return = "2 Please insert a password.";
		if(trim($pass1) != ""){
			$return = "2 The passwords do not match.  Please retype the passwords.";
			if($pass1 === $pass2) return;
			}elseif($_POST["id"] != "") return;
		return($return);
		}
	
	function insertUser(){
		$query_statement = "INSERT INTO `".ADMIN_TABLE_NAME."` (`username`) VALUES ('".addslashes($_POST["username"])."');";
		$query = mysql_query($query_statement);
		$this->rec["id"] = mysql_insert_id();
		return;
		}
	
	function updateUser(){
		$query_statement = "UPDATE `".ADMIN_TABLE_NAME."` SET `username` = '".addslashes($_POST["username"])."', `fname` = '".addslashes($_POST["fname"])."', `lname` = '".addslashes($_POST["lname"])."', `email` = '".addslashes($_POST["email"])."', `access` = '".$_POST["access"]."' WHERE `id` = '".$this->rec["id"]."';";
		$query = mysql_query($query_statement);
		return;
		}
	
	function updateSelf(){
		$query_statement = "UPDATE `".ADMIN_TABLE_NAME."` SET `fname` = '".addslashes($_POST["fname"])."', `lname` = '".addslashes($_POST["lname"])."', `email` = '".addslashes($_POST["email"])."' WHERE `id` = '".$this->rec["id"]."';";
		$query = mysql_query($query_statement);
		$_SESSION[P_SESSION_ID] = $this->user_info[0]."|".$_POST["fname"]." ".$_POST["lname"]."|".$this->user_info[2];
		return;
		}
	
	function updatePassword($password){
		$query_statement = "UPDATE `".ADMIN_TABLE_NAME."` SET `password` = '".$this->cryptPassword($password)."' WHERE `id` = '".$this->rec["id"]."';";
		$query = mysql_query($query_statement);
		return;
		}
	
	
	
				
	
	
	}

?>