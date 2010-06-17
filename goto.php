<?php

require "_admin/_globals.php";
require CLASS_MP_BUSINESS;

$biz = new handleBusiness;

switch($_GET["t"]){
	case "d":
		$biz->updateStats($_GET[id],"view");
		header("location: business_detail.php?id=".$_GET["id"]);
		break;
	case "w":		
		$query = mysql_query("SELECT * FROM `".MP_TABLE_NAME."` WHERE `record_id` = '".$_GET[id]."';");
		$rec   = mysql_fetch_assoc($query);	
		if($rec["web_address"] != ""){
			$biz->updateStats($_GET["id"],"click");
			$web_address = $rec["web_address"];
			if(substr($web_address, 0, 7) != "http://") $web_address = "http://".$rec["web_address"];
			header("location: ".$web_address);
		}else header("location: business_detail.php?id=$_GET[id]");
		break;
	}

?>