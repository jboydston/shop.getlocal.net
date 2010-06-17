<?php

session_start();

error_reporting(E_ALL & ~E_NOTICE); ini_set("display_errors", 1);

mysql_connect(MYSQLSERVER, MYSQLUSER, MYSQLPASS) or die("Could not connect to database.  Please contact system administrator.");
mysql_select_db(MYSQLSCHEME) or die("Could not select database.  Please contact system administrator.");


function sendMail($type, $option=false){
	global $email_subjects;
	switch($type){
		case "giftcard":
		$inv = $option;
		$query_statement = "SELECT *, SUBSTR(AES_DECRYPT(`cc_numb`, '".MYSQL_CRYPT_KEY."'), -4) AS `last_four`, `".GC_CARDS_NAME."`.`id` AS `gc_id` FROM `".GC_INVOICES."`, `".GC_TABLE_NAME."`, `".GC_CARDS_NAME."`, `".MP_TABLE_NAME."` WHERE `".GC_TABLE_NAME."`.`marketplace_id` = `".MP_TABLE_NAME."`.`record_id` AND   `".GC_CARDS_NAME."`.`giftcard_id` = `".GC_TABLE_NAME."`.`id` AND   `".GC_INVOICES."`.`id` = `".GC_CARDS_NAME."`.`inv_numb` AND   `".GC_INVOICES."`.`id` = '".$inv."' GROUP BY `business_name` ASC;";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query)){
			$build .= $rec["business_name"]."<br/>";
			$build .= "Face Value: \$".number_format($rec["value"], 2)."<br/>";
			$build .= "Purchase Price: \$".number_format($rec["price"], 2)."<br/>";
			$build .= "Card Key: ".$rec["key"]."<br/><br/>";
			$info = $rec;
			}
		$info["shopping_cart"] = $build;
		$body["admin"]    = loadTemplate("mail.admin.giftcards.php", $info);
		$body["customer"] = loadTemplate("mail.customer.giftcards.php", $info);
		mail(SEND_SMTP_TO, $email_subjects["gc_admin"],$body["admin"],SMTP_HEADERS,"-f ".SEND_SMTP_TO);
		mail($info["email"], $email_subjects["gc_customer"],$body["customer"],SMTP_HEADERS,"-f ".SEND_SMTP_TO);
		break;
		}	
	}
	
function loadTemplate($file, $rec=null){
	global $scart;
	$file = PATHTOTEMPLATESEDIT."/".$file;
	$lines = file($file);
	foreach($lines as $line_num => $line_value){
		if($line_num > 0) $working .= $line_value;
		}
	$read = $working;
	preg_match_all('([[a-z|_]+])', $read, $matches);
	if(is_array($matches)){
		foreach($matches[0] as $key => $value){
			$findme = $value;
			$rec_value = substr(trim($value, "]"), 1);
			$replacewith = $rec[$rec_value];	
			if($value == "[date]")           $replacewith = fixDate($rec[$rec_value]);
			if($value == "[phone]")          $replacewith = fixPhone($rec[$rec_value]);
			if($value == "[buyers_name]")    $replacewith = stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["fname"])." ".stripslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["lname"]);
			if($value == "[company_name]")   $replacewith = COMPANYNAME;
			if($value == "[company_phone]")  $replacewith = fixPhone(CONTACTPHONE);
			if($value == "[company_email]")  $replacewith = COMPANYEMAIL;
			if($value == "[admin_email]")    $replacewith = SEND_SMTP_TO;
			if($value == "[invoice_amount]") $replacewith = "\$".number_format($rec["amount"], 2);
			if($value == "[invoice_number]") $replacewith = $rec["inv_numb"];
			if($value == "[approval_code]")  $replacewith = $rec["trans_numb"];
			if($value == "[last_four]")      $replacewith = $rec["last_four"];
			if($value == "[giftcard_program]") $replacewith = GIFTCARD_PROGRAM;
			$read = str_replace($findme, stripslashes($replacewith), $read);
			}
		}
	return($read);
	}




function pullTemplates($template=false){
	$dropdown .= "<select name=\"template_select\">";
	$files = dir(PATHTOTEMPLATESEDIT);
	while(false !== ($file = $files->read())){
		if(substr($file,-4) == ".php"){
			$lines = file(PATHTOTEMPLATESEDIT."/".$file);
			$rem_template_select[$_POST["template_select"]] = " selected";
			$dropdown .= "<option value=\"".$file."\"".$rem_template_select[$file].">".stripslashes($lines[0])."</option>";
			if($file == $template){
				$header = $lines[0];
				foreach($lines as $line_num => $value){
					if($line_num > 0) $content .= $value;
					}
				}
			}
		}
	$dropdown .= "</select>";
	$option["dropdown"] = stripslashes($dropdown);
	$option["header"]   = stripslashes($header);
	$option["content"]  = stripslashes($content);
	return($option);
	}

function saveTemplate($template){
	$string = $_POST["header"]."\r\n".$_POST["template_content"];
	$file = PATHTOTEMPLATESEDIT."/".$template;
	$open = fopen($file, "w");
	$write = fwrite($open, $string);
	fclose($open);
	}

	
function standardTime($time){
	$formatted = date("g:i a", mktime(substr($time, 0, 2), substr($time, 3, 2)));
	return($formatted);
	}
		
function cleanUp($str){
	$chars = " abcdefghijklmnopqrstuvwxyz ";
	$name = strtolower($str);
	for($i=0; $i <= strlen($name)+1; $i++){
		$letter = substr($name, $i, 1);
		if(strpos($chars, $letter) || $letter === " ")
			$rebuild .= $letter;
		}
	return($rebuild);
	}

function buildDaySelect($name="day",$select=""){
	$build = "<select name=\"$name\">\r";
	if($_POST[$name] == "") $_POST[$name] = date("d");
	if($select == "") $rem_selection[$_POST[$name]] = " selected";
	else $rem_selection[$select] = " selected";
	for($i=1;$i<=31;$i++){
		$value = date("d", mktime(0,0,0,1,$i,date("Y")));
		$build .= "\t<option value=\"".$value."\"".$rem_selection[$value].">".$i."</option>\r";
		}
	$build .= "\t</select>\r";
	return($build);
	}

function buildMonthSelect($name="month",$select=""){
	$build = "<select name=\"$name\">\r";
	if($_POST[$name] == "") $_POST[$name] = date("m");
	if($select == "") $rem_selection[$_POST[$name]] = " selected";
	else $rem_selection[$select] = " selected";
	for($i=1;$i<=12;$i++){
		$value = date("m", mktime(0,0,0,$i,1,date("Y")));
		$build .= "\t<option value=\"".$value."\"".$rem_selection[$value].">".$i." ".date("F", mktime(0,0,0,$i,1,date("Y")))."</option>\r";
		}
	$build .= "\t</select>\r";
	return($build);
	}

function buildYearSelect($start,$stop,$name="year",$select=""){
	$build = "<select name=\"$name\">\r";
	if($_POST[$name] == "") $_POST[$name] = $start;
	if($select == "") $rem_selection[$_POST[$name]] = " selected";
	else $rem_selection[$select] = " selected";
	$direction = "down";
	if($stop > $start) $direction = "up";
	switch($direction){
		case "down";
			$count = $start-$stop;
			for($i=0;$i<=$count;$i++){
				$value = $start-$i;
				$build .= "\t<option value=\"".$value."\"".$rem_selection[$value].">".$value."</option>\r";
				}
			break;
		case "up";
			$count = $stop-$start;
			for($i=0;$i<=$count;$i++){
				$value = $start+$i;
				$build .= "\t<option value=\"".$value."\"".$rem_selection[$value].">".$value."</option>\r";
				}
			break;
		}
	$build .= "\t</select>\r";
	return($build);
	}

function fixDate($str, $short=false){
	$formatted = date("l, F d, Y", mktime(0,0,0,substr($str, 4, 2), substr($str, 6, 2), substr($str, 0, 4)));
	if($short == true) $formatted = date("m-d-Y", mktime(0,0,0,substr($str, 4, 2), substr($str, 6, 2), substr($str, 0, 4)));
	return($formatted);
	}

function miniError($e){
	$mess = "<div id=\"mini-error\"><b>ERROR!!!</b> <ul>".$e."</ul></div>";
	return($mess);
	}

function miniSuccess($e){
	$mess = "<div id=\"mini-success\"><b>Success!</b> <ul>".$e."</ul></div>";
	return($mess);
	}

function fixPhone($phone){
	$num = "(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone, 6);
	return($num);
	}

function lightSwitch($str){
	$return = "Off";
	if($str == 1) $return = "<span class=\"red\"><b>On</b></span>";
	return($return);
	}

function returnToSearch(){
	$return = "You have no search query's for this session.";
	if(isset($_SESSION["returnsearch"])){
		$build = "Return to Search: ";
		$querys = explode(";", $_SESSION["returnsearch"]);
		$reverse = array_reverse($querys, false);
		for($i=1;$i<=5;$i++) $build .= "<a href=\"search.php?search=".$reverse[$i]."&submit=submit&type=0\" class=\"green\">".$reverse[$i]."</a>,";
		$return = rtrim($build, ",");
		}
	return($return);
	}

function buildMessage($mess){
	$type = substr($mess,0,1);
	switch($type){
		case "1":
			$return = "<div class=\"success\">".substr($mess,2)."</div>";
			break;
		case "2":
			$return = "<div class=\"error\">".substr($mess,2)."</div>";
			break;
			}
	return($return);
	}	

function getHeader($type,$include_google_maps=""){
	global $home_page_cats,$map_pointer,$body_vars,$zoom,$add_pointers,$page_title,$page_description,$page_keywords;
	if(!isset($_GET["printme"])){
		if($type == "admin") require ADMINHEADERFILE;
		if($type == "public") require SITEHEADERFILE;
		} else require PRINTHEADERFILE;
	}

function getFooter($type){	
	if(!isset($_GET["printme"])){
		if($type == "admin") require ADMINFOOTERFILE;
		if($type == "public") require SITEFOOTERFILE;
		}else require PRINTFOOTERFILE;
	}

function findExtension($name){
	$filetype = strtolower($_FILES[$name]["type"]);
	$ext = ".jpg";
	if(strpos($filetype, "gif")) $ext = ".gif";
	elseif(strpos($filetype, "png")) $ext = ".png";
	elseif(strpos($filetype, "shockwave")) $ext = ".swf";
	return($ext);
	}

function genKey($len="random"){
	if($len == "random") $len = rand(53,81);
	$str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	for($i=1;$i<=$len;$i++){
		$rand = rand(1, strlen($str));
		$build .= substr($str,$rand-1, 1);
		}
	return($build);
	}

function listHomeCats(){
	global $home_page_cats, $page_title;
	$index_page = $_GET["p"];
	if($index_page == "") $index_page = array_rand($home_page_cats);
	$build = "<div class='white extra-large' style='display: block; clear: both; text-align: center; padding: 20px 0px 10px 0px;'>".$home_page_cats[$index_page]["name"]."</div>";
	$page_title = PAGETITLE.": ".$home_page_cats[$index_page]["name"];
	foreach($home_page_cats[$index_page]["subs"] as $key => $values){
		$css_filler = "";
		if($_GET["search"] == $key){
			$css_filler = " background-color: #dbf9d8; color: #000;";
			$page_title = PAGETITLE.": ".$home_page_cats[$index_page]["name"]." - ".$values;
			}
		$build .= "<a href=\"search.php?p=".$index_page."&search=".$key."&c=y\" class='medium' style=\"".$css_filler."\">".$values."</a>\r";
		}
	return($build);
	}
	
function showRecentSearch($limit=5){
	$lines = file(SEARCHEDTERMSFILE);
	$i = 1;
	foreach($lines as $line_num  => $line_value){
		$search_term = substr($line_value, 9);
		if($last_term != $search_term){
			if($i <= $limit){
				$build .= "<a href=\"search.php?search=".$search_term."\" class=\"blue medium\">".$search_term."</a><br/>";
				$i++;
				}else	break;
			}
		$last_term = $search_term;
		}
	return($build);
	}

function showSearchBusiness(){
	$lines = file(SEARCHEDMERCHANTSFILE);
	foreach($lines as $line_num  => $line_value) $build .= $line_value;
	return($build);
	}
	
function getPaymentClass(){
	switch(PAYMENT_CLASS){
		case "authorize.net":
			require AUTHORIZE_PCLASS;
			break;
		}
	}
	

	
	
	
	
	
	
	
	
			
?>