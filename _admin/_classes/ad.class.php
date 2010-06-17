<?php

include_once ADCHEATSHEET;
$adchain = array();
class handleAds{
	public $rec,$adchain,$available_ads,$num_coupons,$page_height;
	
	function __construct(){
		global $advertising, $adchain,$biz;		
		$this->rec["marketplace_id"] = $_GET["id"];
		if(isset($_REQUEST["adid"])){
			$query_statement = "SELECT * FROM `".AD_TABLE_NAME."` WHERE `id` = '".$_REQUEST["adid"]."';";
			$query = mysql_query($query_statement);
			if(mysql_num_rows($query) != "0"){
				$rec = mysql_fetch_assoc($query);
				foreach($rec as $key => $value) $this->rec[$key] = $rec[$key];
				$ad_file_local = PATHTODATADIR."/".$this->rec["marketplace_id"]."/".$rec["file"];
				$ad_file_http  = HTMLTODATADIR."/".$this->rec["marketplace_id"]."/".$rec["file"];
				if(is_file($ad_file_local))$this->rec["imagefile"] = "<img src=\"".$ad_file_http."?nocache=".date(Ymdhis).rand(1,1000)."\" height=\"300\">\r\n";
				}
			}	
		$ad_cat = substr($biz->rec["sic_1"],0,4);
		$ad_id  = $biz->rec["record_id"];
		if(is_array($advertising[$ad_cat][$ad_id])){
			foreach($advertising[$ad_cat][$ad_id] as $key => $value){
				$available_ads[] = array("values" => $value, "key" => $ad_id);
				if($value["type"] == 2) $coupon_count++;
				}
			}
		if(!is_array($available_ads)){
			if(is_array($advertising[$ad_cat])){
				foreach($advertising[$ad_cat] as $ad_id => $value_key){
					foreach($value_key as $key => $value){
						$available_ads[] = array("values" => $value, "key" => $ad_id);
						if($value["type"] == 2) $coupon_count++;
						}
					}
				}
			}
		if(!is_array($available_ads)){
			if(is_array($advertising)){
				foreach($advertising as $cat_key => $cat_value){
					foreach($cat_value as $ad_id => $value_key){
						foreach($value_key as $key => $value){
							$available_ads[] = array("values" => $value, "key" => $ad_id);
							if($value["type"] == 2) $coupon_count++;
							}
						}
					}
				}
			}
		@shuffle($available_ads);
		$this->available_ads = $available_ads;
		$this->num_coupons = $coupon_count;
		}

	function buildAd($width, $height=""){
		if(is_array($this->available_ads)){
			$current = current($this->available_ads);
			$ad_file = HTMLTODATADIR."/".$current["key"]."/".$current["values"]["file"];
			$ad_height = @getimagesize($ad_file);
			$total_ad_height = $ad_height[1]+$this->page_height;
			while($total_ad_height >= 651){
				$current = next($this->available_ads);
				$ad_file = HTMLTODATADIR."/".$current["key"]."/".$current["values"]["file"];
				$ad_height = @getimagesize($ad_file);
				$total_ad_height = $ad_height[1]+$this->page_height;
				}
			$this->page_height = $total_ad_height;
			$height_flag = "";
			if($height != "") $height_flag = "height=".$height;
			if($current["values"]["type"] == 1) $return_ad = "<a href=\"".$current["values"]["href"]."\" target=\"_blank\"><img style=\"display: block;\" src=\"".$ad_file."\" width=".$width." ".$height_flag." border=0></a>";
			if($current["values"]["type"] == 2) $return_ad = "<a href=\"print_coupon.php?file=".$ad_file."\" target=\"_blank\"><img style=\"display: block;\" src=\"".$ad_file."\" width=".$width." ".$height_flag." border=0><span class=\"extra-small white\">Click on coupon to print</span></a>";
			next($this->available_ads);
			}
		return($return_ad);
		}

	function buildCoupons($cat_select=""){
		global $advertising;
		if(is_array($advertising)){
				foreach($advertising as $cat_number => $details){
					foreach($details as $rec_id => $ad_number){
						foreach($ad_number as $ad_key => $values){
							if($values["type"] == 2){
								if($cat_select == "" || $values["cat_type"] == $cat_select){
									$ad_file = HTMLTODATADIR."/".$rec_id."/".$values[file];
									$category = $values[category];
									if($values[cat_color] == "") $values[cat_color] = "fff";
									if(trim($category) == "")    $category = "GENERAL";
									$build .= "<div style=\"width: 300px; height: 365px; text-align: center; margin: 2px; padding: 4px; display: block; float: left; background-color: #".$values[cat_color].";\">";
									$build .= "<span class=\"black extra-small\" style=\"margin: 0px; padding: 0px;\">".$values[cat_type]."</span><br>";
									$build .= "<span class=\"blue extra-small\" style=\"margin: 0px; padding: 0px;\">".$category."</span><br>";
									$build .= "<a href=\"print_coupon.php?file=".$ad_file."\" target=\"_blank\">";
									$build .= "<center><img style=\"display: block;\" src=\"".$ad_file."\" height=300 border=0></center>	";
									$build .= "<span class=\"extra-small blue\">Click on coupon to print</span></a>";
									$build .= "</div>";
									}
								$cats[$values["cat_type"]]++;
								}
							}
						}
					}
			$return = array(0=>$build, 1=>$cats);
			}
		return($return);
		}

	function getAdvertising($mpid){
		$query_statement = "SELECT * FROM `".AD_TABLE_NAME."` WHERE `marketplace_id` = '".$mpid."' AND `status` = '1';";
		$query = mysql_query($query_statement);
		if(mysql_num_rows($query) == "0") $build = "There are no ads assigned to this account.";
		else{
			while($rec = mysql_fetch_assoc($query)){
				$ad_file_local = PATHTODATADIR."/".$mpid."/".$rec["file"];
				$ad_file_http  = HTMLTODATADIR."/".$mpid."/".$rec["file"];
				$build .= "<div class=\"ad-gallery\"><b>".$rec["name"]."</b><br/>";
				if(is_file($ad_file_local))	$build .= "<img src=\"".$ad_file_http."?nocache=".date(Ymdhis).rand(1,1000)."\" height=300>\r\n";
				else $build .= "<img src=\"".IMAGEDIR."/nofile.jpg	?nocache=".date(Ymdhis).rand(1,1000)."\" height=300>\r\n";
				$build .= $this->createAdOptions($rec)."</div>";
				}
			}
		return($build);
		}

	function createAd(){
		$query_statement = "INSERT INTO `".AD_TABLE_NAME."` (`status`) VALUES ('0');";	
		$query = mysql_query($query_statement);
		$this->rec["id"] = mysql_insert_id();
		return(true);
		}
		
	function updateAd(){
		if($_POST["runtime"] != ""){
			$jdtoday   = gregoriantojd(date("m"),date("d"),date("Y"));
			$jdstop    = $jdtoday + $_POST["runtime"];
			$grstop    = jdtogregorian($jdstop);
			$gr_ele    = explode("/",$grstop);
			$stopdate  = date("Ymd", mktime(1,1,1,$gr_ele[0],$gr_ele[1],$gr_ele[2]));
			}else $stopdate = $_POST["stopyear"].$_POST["stopmonth"].$_POST["stopday"];
		$startdate = $_POST["startyear"].$_POST["startmonth"].$_POST["startday"];
		if($startdate == "") $startdate = date("Ymd");
		$check_ufn = "0";
		if($_POST["runtime"] == "ufn" || $_POST["ufn"] == "1") $check_ufn = "1";
		$type = "1";
		if($_POST["href"] == "") $type = "2";
		$cpm = $_POST["cpm"];
		if($cpm == "") $cpm = $_POST["scpm"];
		if($cpm == "") $cpm = 0;
		$cpm_start = $this->rec["cpm_start"];
		if($this->rec["reset_cpm"]) $cpm_start = "0";
		$cat_type = $_POST["cat_type"];
		$query_statement = "UPDATE `".AD_TABLE_NAME."` SET `name` = '".addslashes($this->rec["name"])."', `href` = '".addslashes($this->rec["href"])."', `start` = '".$startdate."', `stop` = '".$stopdate."', `status` = '1', `target` = '_blank', `type` = '".$type."', `marketplace_id` = '".$this->rec["marketplace_id"]."', `cpm_start` = '".$cpm_start."', `cpm` = '".$cpm."', `ufn` = '".$check_ufn."', `cat_type` = '".$cat_type."' WHERE `id` = '".$this->rec["id"]."';";	
		$query = mysql_query($query_statement);
		return(true);
		}
		
	function deleteAd(){
		$query_statement = "UPDATE `".AD_TABLE_NAME."` SET `status` = '9' WHERE `id` = '".$_GET["adid"]."';";	
		$query = mysql_query($query_statement);
		return(true);
		}
		
	function uploadAd(){
		$to_dir  = PATHTODATADIR."/".$this->rec["marketplace_id"];
		if($_FILES["ad_upload"]["name"] != ""){
			$name = $this->rec["id"];
			$file_name = "ad".$name.findExtension("ad_upload");
			$this->saveFile($_FILES["ad_upload"]["tmp_name"],$to_dir,$file_name);
			$query_statement = "UPDATE `".AD_TABLE_NAME."` SET `file` = '".$file_name."' WHERE `id` = '".$this->rec["id"]."';";	
			$query = mysql_query($query_statement);
			}
		return(true);
		}
		
	function adCreate(){
		foreach($_POST as $key => $value) $this->rec[$key] = $_POST[$key];
		if($_POST["adid"] == "") $this->createAd();
		$this->updateAd();
		$this->uploadAd();
		return(true);
		}
	
	function createAdOptions($rec=""){
		$build  = "<br/>";
		$build .= "<a onclick=\"document.getElementById('details_".$rec["id"]."').style.display='block';document.getElementById('delete_".$rec["id"]."').style.display='none'\" class=\"field-info expandable-link\">DETAILS</a> &nbsp;&nbsp;\r\n";
		$build .= "<a href=\"ad_manage.php?id=".$rec["marketplace_id"]."&adid=".$rec["id"]."\" class=\"field-info expandable-link\">UPDATE</a> &nbsp;&nbsp;\r\n";
		$build .= "<a onclick=\"document.getElementById('delete_".$rec["id"]."').style.display='block';document.getElementById('details_".$rec["id"]."').style.display='none'\" class=\"field-info expandable-link\">DELETE</a> &nbsp;&nbsp;\r\n";
		$build .= "<div id=\"details_".$rec["id"]."\" style=\"display:none;\"><br/>\r\n";
		if($rec["name"] != "") $build .= "<span class=\"green\">".$rec["name"]."</span><br/>\r\n";
		if($rec["start"] >= TODAY) $build .= "Started on ".fixDate($rec["start"]).".<br/>\r\n";
		else $build .= "Starts on ".fixDate($rec["start"]).".<br/>\r\n";
		if($rec["ufn"] == "1") $build .= "Runs until further notice.<br/>\r\n";
		else{
			if($rec["stop"] >= TODAY) $build .= "Stops on ".fixDate($rec["stop"]).".<br/>\r\n";
			else $build .= "Stopped on ".fixDate($rec["stop"]).".<br/>\r\n";
			}
		if($rec["type"] == "2") $build .= "* Is a coupon that opens to a printer friendly version of itself.<br/>\r\n";
		else $build .= "* Links to ".$rec["href"]."<br/>\r\n";
		if($rec["impressions"] == "0") $build .= "* Has made no impressions yet.<br/>\r\n";
		else $build .= "* Has been shown ".number_format($rec["impressions"],0)." times.<br/>\r\n";

		if($rec["cpm"] != "0") $build .= "* Has used ".number_format($rec["cpm_start"])." of ".number_format($rec["cpm"])." and has ".number_format($rec["cpm"]-$rec["cpm_start"])." impressions remaining.<br/>\r\n";

		$build .= "<br/><a onclick=\"document.getElementById('details_".$rec["id"]."').style.display='none'\" class=\"field-info expandable-link\">Close Details</a>\r\n";
		$build .= "</div>\r\n";
		$build .= "<div id=\"delete_".$rec["id"]."\" style=\"display:none;\"><br/>\r\n";
		$build .= "Are you sure you want to delete the above ad? &nbsp;&nbsp;&nbsp;";
		$build .= "<a onclick=\"document.getElementById('delete_".$rec["id"]."').style.display='none'\" class=\"field-info expandable-link\">NO</a> &nbsp;&nbsp;";
		$build .= "<a href=\"".$_SERVER["PHP_SELF"]."?id=".$_GET["id"]."&adid=".$rec["id"]."&delete=yes\" class=\"field-info expandable-link\">YES</a>";
		$build .= "</div>\r\n";
		return($build);
		}

	function saveFile($from_file,$to_dir,$file_name){
		if(!is_dir($to_dir)) mkdir($to_dir) or die("Error: Could not make data directory - ".$to_dir.".  Please check folder permissions.");
		$to_file = $to_dir."/".$file_name;
		if(is_file($to_file)){
			copy($to_file, $to_dir."/".date("Ymdhis").$file_name);
			unlink($to_file);
			}
		copy($from_file,$to_file) or die("Error: Could not copy file.");
		unlink($from_file);
		return;
		}

	function createAdSheet(){
		global $service_directory_categories;
		$today = date("Ymd");
		$query_statement = "SELECT * FROM `".AD_TABLE_NAME."`,`".GENERAL_CATEGORIES."` WHERE `stop` >= '".TODAY."' OR `ufn` = '1' HAVING `link_id` = '' AND `status` = '1' AND `start` <= '".TODAY."' AND `".AD_TABLE_NAME."`.`cat_type` = `".GENERAL_CATEGORIES."`.`id`;";
		$query = mysql_query($query_statement);
		if(mysql_num_rows($query) > 0){	
			$build  = "<?php\n";
			$build .= "// CREATED ON ".date("Y-m-d H:i:s")."\n";
			while($rec = mysql_fetch_assoc($query)){
				$new_query_statement = "SELECT `record_id`,`business_name`,`sic_1`,`sic_2`,`sic_3`,`sic_4`,`sic_5`,`sic_6` FROM `".MP_TABLE_NAME."` WHERE `record_id` = '".$rec["marketplace_id"]."';";
				$new_query = mysql_query($new_query_statement);
				$mprec = mysql_fetch_assoc($new_query);
				$sic = $mprec["sic_1"];
				if($sic == "") $sic = $mprec["sic_2"];
				if($sic == "") $sic = $mprec["sic_3"];
				if($sic == "") $sic = $mprec["sic_4"];
				if($sic == "") $sic = $mprec["sic_5"];
				if($sic == "") $sic = $mprec["sic_6"];
				if($sic != ""){
					$build .= "\$"."advertising[\"".substr($sic, 0, 4)."\"][\"".$rec["marketplace_id"]."\"][] = ";
					$build .= "array(\n";
					$build .= "\"name\"          => \"".$mprec["business_name"]."\",\n";
					$build .= "\"num\"           => \"".$rec["id"]."\",\n";
					$build .= "\"target\"        => \"".$rec["target"]."\",\n";
					$build .= "\"file\"          => \"".$rec["file"]."\",\n";
					$build .= "\"type\"          => \"".$rec["type"]."\",\n";
					$build .= "\"href\"          => \"".$rec["href"]."\",\n";
					$build .= "\"group_id\"      => \"".$rec["cpm"]."\",\n";
					$build .= "\"lunch_special\" => \"".$rec["lunch_special"]."\",\n";
					$build .= "\"start\"         => \"".$rec["start"]."\",\n";
					$build .= "\"stop\"          => \"".$rec["stop"]."\",\n";
					$build .= "\"cat_type\"      => \"".$rec["name"]."\",\n";
					$build .= ");\n";
					}else $warning .= $mprec["business_name"]." is not listed under any category and could not publish its ad.<br>";
				}	
			$build .= "?>\n";
			}	
		$tfile = fopen(ADCHEATSHEET, "w");
		fwrite($tfile, $build);	
		fclose($tfile);
		return(true);
		}

	function getAdCategories(){
		$query_statement = "SELECT * FROM `".GENERAL_CATEGORIES."` ORDER BY `name` ASC;";
		$query = mysql_query($query_statement);
		$build  = "<select name=\"cat_type\">";
		while($rec = mysql_fetch_assoc($query)){
			$rem_cat[$this->rec["cat_type"]] = " selected";
			$build .= "<option value=\"".$rec["id"]."\"".$rem_cat[$rec["id"]].">".stripslashes($rec["name"])."</option>\r\n";
			}
		$build .= "</select>";
		return($build);
		}


	}

?>