<?php


function buildMessage($mess){
	$type = substr($mess,0,1);
	switch($type){
		case "1": $return = "<div class=\"success\">".substr($mess,2)."</div>"; break;
		case "2": $return = "<div class=\"error\">".substr($mess,2)."</div>"; break;
		}
	return($return);
	}	



if(isset($_POST["submit"])){
	$error = "";
	if($_POST["host"] == "" || $_POST["user"] == "" || $_POST["pass"] == "" || $_POST["scheme"] == "") $mess = "2 Please fill out all information";
	if(!mysql_connect($_POST["host"], $_POST["user"], $_POST["pass"])) $mess = "2 Could not connect to database.  Please verify information. Error: ".mysql_error();
	
	if(!mysql_select_db($_POST["scheme"])){
		if(!mysql_query("CREATE DATABASE `".$_POST["scheme"]."`;")) $mess = "2 Could not create database `".$_POST["scheme"]."`.  Error: ".mysql_error();
		else mysql_select_db($_POST["scheme"]);
		}
	
	if($_POST["adminpass"] == "" || $_POST["adminpass"] != $_POST["adminpassc"]) $mess = "2 Passwords are blank or do not match.  Please retype the admin password for marketplace.";
	
	if($mess == ""){
		$mess = "1 Database has been created. <a href=\"index.php\">Click Here</a> to log in and start using Marketplace.";
		
		$statement[] = "SET FOREIGN_KEY_CHECKS = 0;";
		$statement[] = "CREATE TABLE `ad_schedule` (`id` int(11) NOT NULL AUTO_INCREMENT,`name` varchar(100) NOT NULL DEFAULT '',`notes` blob NOT NULL,`start` varchar(8) NOT NULL DEFAULT '',`stop` varchar(8) NOT NULL DEFAULT '',`status` int(11) NOT NULL DEFAULT '0',`href` varchar(255) NOT NULL DEFAULT '',`target` varchar(100) NOT NULL DEFAULT '',`type` int(11) NOT NULL DEFAULT '0',`file` varchar(100) NOT NULL DEFAULT '',`ufn` int(1) NOT NULL DEFAULT '0',`marketplace_id` varchar(100) NOT NULL,`cpm_start` int(20) NOT NULL DEFAULT '0',`cpm` int(20) NOT NULL DEFAULT '0',`impressions` int(20) NOT NULL DEFAULT '0',`log` blob,`link_id` varchar(255) NOT NULL,`cat_type` char(3) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=100457 DEFAULT CHARSET=latin1;";
		$statement[] = "CREATE TABLE `admin_accounts` (`id` int(11) NOT NULL AUTO_INCREMENT,`username` varchar(20) NOT NULL,`password` varchar(20) NOT NULL,`fname` varchar(30) NOT NULL,`lname` varchar(50) NOT NULL,`email` varchar(50) NOT NULL,`access` int(3) NOT NULL,`status` int(1) NOT NULL DEFAULT '1',PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
		$statement[] = "CREATE TABLE `general_categories` (`id` int(11) NOT NULL AUTO_INCREMENT,`name` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;";
		$statement[] = "CREATE TABLE `giftcards` (`id` int(12) NOT NULL AUTO_INCREMENT,`name` varchar(255) NOT NULL,`value` int(11) NOT NULL,`price` int(11) NOT NULL,`quantity` int(10) NOT NULL,`date_submitted` char(8) NOT NULL,`admin` int(12) NOT NULL,`marketplace_id` varchar(50) NOT NULL,`restrictions` blob NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;";
		$statement[] = "CREATE TABLE `giftcards_cards` (`id` int(16) NOT NULL AUTO_INCREMENT,`category` int(11) NOT NULL,`value` int(11) NOT NULL,`price` int(11) NOT NULL,`giftcard_id` int(10) NOT NULL,`status` int(1) NOT NULL DEFAULT '1',`key` blob NOT NULL,`admin` int(11) NOT NULL,`date_created` char(8) NOT NULL,`date_sold` char(8) NOT NULL,`notes` blob NOT NULL,`inv_numb` int(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=157 DEFAULT CHARSET=latin1;";
		$statement[] = "CREATE TABLE `giftcards_invoices` (`id` int(11) NOT NULL AUTO_INCREMENT,`date` int(8) NOT NULL,`amount` int(12) NOT NULL,`status` int(1) NOT NULL,`result` blob NOT NULL,`trans_numb` varchar(20) NOT NULL,`fname` varchar(20) NOT NULL,`lname` varchar(30) NOT NULL,`address` varchar(50) NOT NULL,`city` varchar(50) NOT NULL,`state` char(2) NOT NULL,`zip` int(5) NOT NULL,`phone` char(10) NOT NULL,`email` varchar(255) NOT NULL,`ship_fname` varchar(20) NOT NULL,`ship_lname` varchar(30) NOT NULL,`ship_address` varchar(50) NOT NULL,`ship_city` varchar(50) NOT NULL,`ship_state` char(2) NOT NULL,`ship_zip` int(5) NOT NULL,`cc_name` varchar(255) NOT NULL,`cc_numb` blob NOT NULL,`cc_exp` blob NOT NULL,`cc_sec` blob NOT NULL,`cc_zip` int(5) NOT NULL,`ipaddress` varchar(15) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;";
		$statement[] = "CREATE TABLE `guide` (`id` int(11) DEFAULT NULL,`lvl1_id` varchar(20) DEFAULT NULL,`lvl1_name` varchar(255) DEFAULT NULL,`lvl2_id` int(11) DEFAULT NULL,`lvl2_name` varchar(255) DEFAULT NULL,`agent_add` int(1) NOT NULL DEFAULT '0') ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$statement[] = "CREATE TABLE `icons` (`id` int(6) NOT NULL AUTO_INCREMENT, `name` varchar(255) NOT NULL, `file` varchar(255) NOT NULL, `status` int(1) NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;";
		$statement[] = "CREATE TABLE `lunch_special_ads` (`id` int(12) NOT NULL AUTO_INCREMENT, `ad` varchar(255) NOT NULL, `heading` varchar(255) NOT NULL, `special` blob NOT NULL, `stat` blob NOT NULL, `menu` int(12) NOT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;";
		$statement[] = "CREATE TABLE `lunch_special_menus` (`id` int(12) NOT NULL AUTO_INCREMENT, `date` char(8) NOT NULL, `created` char(8) NOT NULL, `views` int(12) NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;";
		$statement[] = "CREATE TABLE `marketplace` (`record_id` varchar(255) DEFAULT NULL,`business_name` varchar(255) DEFAULT NULL,`full_address` varchar(255) DEFAULT NULL,`city_name` varchar(255) DEFAULT NULL,`state_code` varchar(255) DEFAULT NULL,`zip` int(11) DEFAULT NULL,`zip_ext` varchar(255) DEFAULT NULL,`phone` varchar(10) DEFAULT NULL,`sic_1` varchar(255) DEFAULT NULL,`sic_2` varchar(255) DEFAULT NULL,`sic_3` varchar(255) DEFAULT NULL,`sic_4` varchar(255) DEFAULT NULL,`sic_5` varchar(255) DEFAULT NULL,`sic_6` varchar(255) DEFAULT NULL,`latitude` varchar(255) DEFAULT NULL,`longitude` varchar(255) DEFAULT NULL,`email_address` varchar(255) DEFAULT NULL,`web_address` varchar(255) DEFAULT NULL,`counter_list` int(11) NOT NULL DEFAULT '0',`counter_view` int(11) NOT NULL DEFAULT '0',`counter_web` int(11) NOT NULL DEFAULT '0',`counter_click` int(11) NOT NULL DEFAULT '0',`bold_flag` int(11) DEFAULT NULL,`highlight_flag` int(11) DEFAULT NULL,`business_hours` varchar(255) DEFAULT NULL,`business_hours_flag` int(1) NOT NULL DEFAULT '0',`sponsor_flag` int(1) NOT NULL DEFAULT '0',`profile_flag` int(1) NOT NULL DEFAULT '0',`product_flag` int(1) NOT NULL DEFAULT '0',`gallery_flag` int(1) NOT NULL DEFAULT '0',`video_flag` int(1) NOT NULL DEFAULT '0',`agent_added` int(1) DEFAULT NULL,`b_pin` varchar(10) NOT NULL,`notes` blob NOT NULL,`icons` blob,`status` int(1) NOT NULL,`sd_cat` int(3) NOT NULL,`sd_profile` blob NOT NULL,`search_terms` blob NOT NULL,`profile_text` blob NOT NULL,`product_text` blob NOT NULL,`youtube` blob NOT NULL,`bid` int(10) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$statement[] = "CREATE TABLE `service_directory_cats` (`id` int(11) NOT NULL AUTO_INCREMENT, `category` varchar(255) NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;";
		$statement[] = "SET FOREIGN_KEY_CHECKS = 1;";
		$statement[] = "DELETE FROM `admin_accounts`;";
		$statement[] = "INSERT INTO `admin_accounts` (`username`,`password`,`access`) VALUES ('".$_POST["admin"]."', '".crypt($_POST["adminpass"], "mp")."','9');";
		
		foreach($statement as $key => $value) mysql_query($value);
		
		$build  = "<?php\r\n";
		$build .= "define (\"MYSQLSERVER\", \"".$_POST["host"]."\");\r\n";
    $build .= "define (\"MYSQLUSER\",   \"".$_POST["user"]."\");\r\n";
    $build .= "define (\"MYSQLPASS\",   \"".$_POST["pass"]."\");\r\n";
    $build .= "define (\"MYSQLSCHEME\", \"".$_POST["scheme"]."\");\r\n";
		$build .= "?>\r\n";
		
		$file = "_includes/mysql_settings.inc.php";
		$fopen = fopen($file, "w+");
		if(!fwrite($fopen, $build)) $mess = "2 Could not write database settings to include file.  Please check folder permissions.";
		fclose();

		}
	}else{
		$_POST["host"]   = "localhost";
		$_POST["user"]   = "";
		$_POST["pass"]   = "";
		$_POST["scheme"] = "marketplace";
		}
?>

<?php echo buildMessage($mess); ?>

<h3>Welcome to the Marketplace database install program.</h3>  

<p>To set up the Marketplace database, please fill out the following information to proceed.</p>

<style>
table.fieldset {
	margin: 10px 0px;
	}
table.fieldset td.fieldname {
	width: 150px;
	}
table.fieldset td.fieldvalue {
	width: 500px;
	}
table.fieldset td.fieldname, table.fieldset td.fieldvalue {
	vertical-align: top;
	}
form input.text {
	width: 300px;
	}
form input.tiny {
	width: 50px;
	}
form input.small {
	width: 100px;
	}
div.error {
	display: block;
	clear: both;
	padding: 10px;
	margin: 2px 0px;
	background-color: yellow;
	}

div.success {
	display: block;
	clear: both;
	padding: 10px;
	margin: 2px 0px;
	background-color: #b8dcbc;
	}

</style>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
	<table class="fieldset">
		<tr>
			<td class="fieldname">Host:</td>
			<td class="fieldvalue"><input type="text" class="text" name="host" value="<?php echo stripslashes($_POST["host"]); ?>"></td>
			</tr>
		<tr>
			<td class="fieldname">User:</td>
			<td class="fieldvalue"><input type="text" class="text" name="user" value="<?php echo stripslashes($_POST["user"]); ?>"></td>
			</tr>
		<tr>
			<td class="fieldname">Password:</td>
			<td class="fieldvalue"><input type="password" class="text" name="pass" value=""></td>
			</tr>
		<tr>
			<td class="fieldname">Database Name:</td>
			<td class="fieldvalue"><input type="text" class="text" name="scheme" value="<?php echo stripslashes($_POST["scheme"]); ?>"></td>
			</tr>
			</table>
	
	<table class="fieldset">
		<tr>
			<td class="fieldname">Marketplace Admin:</td>
			<td class="fieldvalue"><input type="text" class="text" name="admin" value="<?php echo stripslashes($_POST["admin"]); ?>"></td>
			</tr>
		<tr>
			<td class="fieldname">Password:</td>
			<td class="fieldvalue"><input type="password" class="text" name="adminpass" value=""></td>
			</tr>
		<tr>
			<td class="fieldname">Password Confirm:</td>
			<td class="fieldvalue"><input type="password" class="text" name="adminpassc" value=""></td>
			</tr>
			</table>
	
	<div style="display: none"><input type="text" name="spamstopper"></div>
	
	<input type="submit" value="Build Database" name="submit">
	
	</form>







