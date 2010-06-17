<?php

class handleBusiness {
	public $rec, $id;
	
	function __construct(){
		if(isset($_REQUEST["id"]) || $this->id != ""){
			$id = $_REQUEST["id"];
			if($id == "") $id = $this->id;
			$query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE `record_id` = '".$id."';";
			$query           = mysql_query($query_statement);
			$this->rec       = mysql_fetch_assoc($query);
			}
		}
	
	function randBusinessSelect(){		
		$query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE `sponsor_flag` = '1' AND `status` != '9' ORDER BY RAND() LIMIT 1;";
		$query           = mysql_query($query_statement);
		$rec             = mysql_fetch_assoc($query);
		$this->id      = $rec["record_id"];
		$this->name    = $rec["business_name"];
		$this->address = $rec["full_address"];
		$this->city    = $rec["city_name"];
		$this->state   = $rec["state_code"];
		$this->zip     = $rec["zip"];
		$this->web     = $rec["web_address"];
		$this->phone   = $rec["phone"];
		$photo = HTMLTODATADIR."/".$this->id."/sponsor.jpg";
		if(@!file($photo)) $photo = HTMLTODATADIR."/".$this->id."/biz_photo.jpg";
		if(@!file($photo)) $photo = IMAGEDIR."/nophoto.jpg";
		$build  = "<a href=\"goto.php?id=".$this->id."&t=d\">";
		$build .= "<img src=\"".$photo."\" style=\"border: 2px solid #818181; margin: 0px 8px 8px 0px; display: block; float: left; width: 300px; padding: 2px;\">";
		$build .= "<span class=\"large blue\">".stripslashes($this->name)."</span><br/>\r";
		$build .= "<span class=\"medium blue\">".stripslashes($this->address)."\r";
		if(trim($this->city) != "")  $build .= stripslashes($this->city).", ";
		if(trim($this->state) != "") $build .= stripslashes($this->state)." ";
		if(trim($this->zip) != "0")  $build .= stripslashes($this->zip);
		$build .= "</span><br/>\r";
		$build .= "<span class=\"extra-small blue\">Get Listing Information and More</span></a>";
		return($build);	
		}
	
	function cleanUp($str){
		$chars = " abcdefghijklmnopqrstuvwxyz ";
		$name = strtolower($str);
		for($i=0; $i <= strlen($name)+1; $i++){
			$letter = substr($name, $i, 1);
			if(strpos($chars, $letter) || $letter === " ") $rebuild .= $letter;
			}
		return($rebuild);
		}
	
	function searchBusinesses($search,$city="",$alpha="",$page="1"){
		global $show_number_of_businesses,$alpha_keys;
		$search      = addslashes($search);
		$search_term = $this->cleanUp($search);
		$page_limit = $page*$show_number_of_businesses;
		$limit = " LIMIT ".($page_limit-$show_number_of_businesses).",".$page_limit;
		$query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE `business_name` LIKE '%".$search."%' OR `search_terms` LIKE '%".$search_term."%' HAVING status != '9' ORDER BY bid DESC, sponsor_flag DESC".$limit.";";
		if($_GET["c"] == "" && $city != "" && $alpha == "") $query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE `business_name` LIKE '%".$search."%' OR `search_terms` LIKE '%".$search_term."%' HAVING status != '9' AND `city_name` = '".$city."'".$limit.";";
		if($_GET["c"] == "" && $city == "" && $alpha != "") $query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE `business_name` LIKE '%".$search."%' OR `search_terms` LIKE '%".$search_term."%' HAVING status != '9' AND business_name LIKE '".$alpha."%'".$limit.";";
		if($_GET["c"] == "" && $city != "" && $alpha != "") $query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE `business_name` LIKE '%".$search."%' OR `search_terms` LIKE '%".$search_term."%' HAVING status != '9' AND `city_name` = '".$city."' AND business_name LIKE '".$alpha."%'".$limit.";";
		if($_GET["c"] == "y") $query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE `sic_1` LIKE '".$search."%' OR `sic_2` LIKE '".$search."%' OR `sic_3` LIKE '".$search."%' OR `sic_4` LIKE '".$search."%' OR `sic_5` LIKE '".$search."%' OR `sic_6` LIKE '".$search."%' HAVING status != '9' ORDER BY sponsor_flag DESC".$limit.";";
		if($_GET["c"] == "y" && $city != "" && $alpha == "") $query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE `sic_1` LIKE '".$search."%' OR `sic_2` LIKE '".$search."%' OR `sic_3` LIKE '".$search."%' OR `sic_4` LIKE '".$search."%' OR `sic_5` LIKE '".$search."%' OR `sic_6` LIKE '".$search."%' HAVING status != '9' AND `city_name` = '".$city."' ORDER BY sponsor_flag DESC".$limit.";";
		if($_GET["c"] == "y" && $city == "" && $alpha != "") $query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE `sic_1` LIKE '".$search."%' OR `sic_2` LIKE '".$search."%' OR `sic_3` LIKE '".$search."%' OR `sic_4` LIKE '".$search."%' OR `sic_5` LIKE '".$search."%' OR `sic_6` LIKE '".$search."%' HAVING status != '9' AND business_name LIKE '".$alpha."%' ORDER BY sponsor_flag DESC".$limit.";";
		if($_GET["c"] == "y" && $city != "" && $alpha != "") $query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE `sic_1` LIKE '".$search."%' OR `sic_2` LIKE '".$search."%' OR `sic_3` LIKE '".$search."%' OR `sic_4` LIKE '".$search."%' OR `sic_5` LIKE '".$search."%' OR `sic_6` LIKE '".$search."%' HAVING status != '9' AND business_name LIKE '".$alpha."%' ORDER BY sponsor_flag DESC".$limit.";";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query)){
			$this->updateStats($rec["record_id"],"list");
			$weight    = "normal"; if($rec["bold_flag"] == 1) $weight = "bold";
			$highlight = "hl-white"; if($rec["highlight_flag"] == 1) $highlight = "hl-yellow";
			$list .= "<a href=\"goto.php?id=".$rec["record_id"]."&t=d\" class=\"large blue ".$weight." ".$highlight."\" style=\"display: block;\">".htmlspecialchars(stripslashes($rec["business_name"]))."</a>\r\n";				
			$list .= "<a href=\"goto.php?id=".$rec["record_id"]."&t=d\" class=\"small blue normal\" style=\"display: block;\">\r\n";
			if($rec["full_address"] != "")  $list .= $rec["full_address"].", \r\n";
			if($rec["city_name"] != "")     $list .= $rec["city_name"].", ";
			if($rec["state_code"] != "")    $list .= $rec["state_code"]." ";
			if($rec["zip"] != "")           $list .= $rec["zip"]."\r\n";
			if($rec["sponsor_flag"] == "1") $list .= fixPhone($rec["phone"])."\r\n";
			$list .= "</a>\r\n";
			$list .= "\t\t\t\t<a href=\"goto.php?id=".$rec["record_id"]."&t=d\" class=\"extra-small blue normal\">Get Listing Information and More</a><br/><br/>\r\n";
			$map_pointer[] = array("latitude" => $rec["latitude"], "longitude" => $rec["longitude"], "title" => $rec["business_name"]);
			if($search_flag != 1 && $rec["sponsor_flag"] == 1){
				$photo = HTMLTODATADIR."/".$rec["record_id"]."/sponsor.jpg";
				if(@!file($photo)) $photo = IMAGEDIR."/nophoto.jpg";
				$top_search  = "<a href=\"goto.php?id=".$rec['record_id']."&t=d\" style=\"display: block;\"><img src=\"".$photo."\" style=\"width: 75px; border: 2px solid #818181; padding: 2px;\"></a>\r\n";				
				$top_search .= "<a href=\"goto.php?id=".$rec['record_id']."&t=d\" class=\"medium blue\" style=\"display: block;\">".htmlspecialchars(stripslashes($rec["business_name"]))."</a>\r\n";				
				$top_search .= "<a href=\"goto.php?id=".$rec['record_id']."&t=d\" class=\"small blue\"  style=\"display: block;\">".fixPhone($rec["phone"])."</a>\r\n";				
				$search_flag = 1;
				$file = SEARCHEDMERCHANTSFILE;
				$fopen = fopen($file, "w+");
				fwrite($fopen, $top_search);
				fclose($fopen);
				}
			$letters = strtoupper(substr($rec["business_name"], 0, 1));
			$letter_guide[$letters]++;
			$get_city[$rec["city_name"]] = true;
			}
		@ksort($get_city);
		@ksort($letter_guide);

		$city_list = "<br/><div style=\"display: block; clear: both; margin: 5px 18px;\" class=\"normal\">Click city to refine search:</div>";
		if(is_array($get_city)){
			foreach($get_city as $city_name => $city_value) $city_list .= "<a href=\"".$PHP_SELF."?search=".$_GET["search"]."&city=".$city_name."&c=".$_GET["c"]."&p=".$_GET["p"]."\" class=\"small white bold\" style=\"margin-bottom: 4px; display: block;\">".strtoupper($city_name)."</a>\r\n";
			}
		if($city != "") $city_list .= "<a href=\"".$PHP_SELF."?search=".$search."&p=".$_GET["p"]."&c=".$_GET["c"]."\" class=\"medium white bold\">Back to All Cities</a><br/>\r\n";


		if(is_array($letter_guide)){
			$alpha_pages = "<a href=\"".$PHP_SELF."?search=".$_GET["search"]."&alpha=&city=".$_GET["city"]."&p=".$_GET["p"]."&c=".$_GET["c"]."\" class=\"page-alpha blue\" style=\"width: 26px;\">ALL</a>\r\n";
			for($i=0;$i<strlen($alpha_keys);$i++){
				$current = substr($alpha_keys, $i, 1);
				$bold = "";
				if($_GET["alpha"] == $current) $bold = "style=\"background-color: yellow;\"";
				$alpha_pages .= "<a href=\"".$PHP_SELF."?search=".$_GET["search"]."&alpha=".$current."&city=".$_GET["city"]."&p=".$_GET["p"]."&c=".$_GET["c"]."\" class=\"page-alpha blue\" ".$bold.">".$current."</a>\r\n";
				}
			}
		if($_GET["c"] == "" && $search_term != ""){
			$file = SEARCHEDTERMSFILE;
			$lines = file($file);
			$build_search = "";
			foreach($lines as $line_num  => $line_value) $build_search .= $line_value;
			$fopen = fopen($file, "w+");
			fwrite($fopen, date("Ymd")." ".$search_term."\r\n".stripslashes($build_search));
			fclose($fopen);
			}
		$return["letter"]   = $alpha_pages;
		$return["cities"]   = $city_list;
		$return["biz_list"] = $list;
		$return["cords"]    = $map_pointer;
		return($return);
		}
		
	function buildBreadTrail($type){
		$cat  = $this->rec["sic_1"];
		$name = $this->rec["business_name"];
		$query_statement = "SELECT * FROM `".CAT_TABLE_NAME."` WHERE `id` = '".$cat."';";
		$query = mysql_query($query_statement);
		$rec   = mysql_fetch_assoc($query);
		$build  = "<p class=\"small blue\">\r\n";
		$build .= "<a href=\"index.php\" class=\"small blue\">HOME</a> > \r\n";
		if($type == "cat")    $build .= "<a href=\"search.php?search=".substr($cat,0,4)."&c=y\" class=\"small blue\">".$rec["lvl1_name"]."</a> > ".$name;
		if($type == "search") $build .= "SEARCH: ".$search;
		$build .= "</p>\r\n";
		return($build);
		}
	
	function getIcons($icons){
		$current_logos = explode(";", $icons);
		if(is_array($current_logos)){
			$build = "<p>";
			foreach($current_logos as $key => $file){
					if($file != ""){
					$query_statement = "SELECT * FROM `".ICON_TABLE_NAME."` WHERE `id` = '".$file."';";
					$query = mysql_query($query_statement);
					$rec   = mysql_fetch_assoc($query);
					$build .= "<img src=\"".HTMLTOICONDIR."/".$rec["file"]."\" alt=\"".$rec["name"]."\"> ";
					}
				}
			$build .= "</p>";
			}
		return($build);
		}
	
	function buildContentTabs(){
		if($this->rec["profile_flag"] == 1){
			$build[2]["header"] = "Profile";
			$build[2]["content"] = $this->rec["profile_text"];
			}
		if($this->rec["product_flag"] == 1){
			$build[3]["header"] = "Product";
			$build[3]["content"] = $this->rec["product_text"];
			}
		if($this->rec["gallery_flag"] == 1){
			$build[4]["header"] = "Photos";
			$build[4]["content"] = $this->getMedia("gallery","no");
			}
		if($this->rec["video_flag"] == 1){
			$build[5]["header"] = "Videos";
			$build[5]["content"] = $this->getMedia("video","no");
			}
		return($build);
		}
	
	function listCats($search="", $style=0){
		$counter = 0;
		$search = addslashes($search);
		$query_statement = "SELECT * FROM `".CAT_TABLE_NAME."` GROUP BY lvl1_name;";
		if($search != "") $query_statement = "SELECT * FROM `".CAT_TABLE_NAME."` WHERE lvl1_name LIKE '%".$search."%' GROUP BY lvl1_name;";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query)){
				$first_letter = strtoupper(substr($rec["lvl1_name"], 0, 1));
				if($last_letter != $first_letter && $style == 0){
					$result .= "<br/><a name=\"".$first_letter."\" class=\"large bold blue\">".$first_letter."</a>";
					$result .= " - <a href=\"#top\" class=\"italic small blue\">Back to top</a><hr>\r\n";
					$alpha  .= "<a href=\"#".$first_letter."\" class=\"large bold blue\">".$first_letter."</a> ";
					}
				$result .= "<a href=\"list_businesses.php?cat=".$rec["lvl1_id"]."\" class=\"small white bold\" style=\"margin-bottom: 4px; display: block;\">".$rec["lvl1_name"]."</a>\r\n";
				$counter++;
				$last_letter = $first_letter;
			}	
		$return[0][display] = $alpha."<br/><br/>\r\n".$result;
		$return[0][counter] = $counter;
		$return[1][display] = "<br/><div style=\"display: block; clear: both; margin: 5px 18px;\" class=\"normal\">Results for \"".$search."\" within category names:<br/></div>\r\n".$result;
		$return[1][counter] = $counter;
		return($return[$style]);
		}	
                                                                                                                                                                                                                                                            /*
	ADMIN FUNCTIONS START HERE <------------------------------------------------------------------------------------------------------------ 
                                                                                                                                                                                                                                                            */ 	
	function createNewCompany(){
		$key = "MP".date("Ymdhis").rand(1000,9999);
		$query_statement = "INSERT INTO `".MP_TABLE_NAME."` (`record_id`, `agent_added`) VALUES ('".$key."','1');";
		$query = mysql_query($query_statement);
		$this->id = $key;
		$this->__construct();
		}
		
	function searchFunction($search=""){
		if(isset($_GET["search"])) $search = addslashes($_GET["search"]);
		if(trim($search) != ""){
			if(strlen($search) > 2){
				$nogo = false;
				if(substr($search,0,13) == "Field Search:") $nogo = true;
				if($_SESSION["returnsearch"] != "" && $nogo == false){
					$querys = explode(";", $_SESSION["returnsearch"]);
					$reverse = array_reverse($querys, false);
					for($i=1;$i<=5;$i++){
						if($reverse[$i] == $search) $nogo = true;
						}
					}
				if($nogo == false) $_SESSION["returnsearch"] = $_SESSION["returnsearch"].$search.";";

				if(substr($search,0,13) != "Field Search:"){
					$critieria[0] = "`business_name` LIKE '%".$search."%' OR `full_address` LIKE '%".$search."%' OR `city_name` LIKE '%$search%' OR `zip` LIKE '%".$search."%' OR `phone` LIKE '%".$search."%' OR `web_address` LIKE '%".$search."%'";
					$critieria[1] = "`business_name` LIKE '%".$search."%'";
					$critieria[2] = "`full_address`  LIKE '%".$search."%'";
					$critieria[3] = "`city_name`     LIKE '%".$search."%'";
					$critieria[4] = "`zip`           LIKE '%".$search."%'";
					$critieria[5] = "`phone`         LIKE '%".$search."%'";
					$critieria[6] = "`web_address`   LIKE '%".$search."%'";
					$critieria[7] = "`search_terms`  LIKE '%".$search."%'";
					$query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE ".$critieria[$_GET["type"]]." ORDER BY `business_name` ASC LIMIT 0,100;";
					}else{
					$search_options = substr($search,13);
					$critieria["sponsor"]   = "`sponsor_flag` = '1'";
					$critieria["web"]       = "`web_address` = ''";
					$critieria["agent"]     = "`agent_added` = '1'";
					$critieria["bold"]      = "`bold_flag` = '1'";
					$critieria["highlight"] = "`highlight_flag` = '1'";
					$critieria["icons"]     = "`icons` != ''";
					$query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE ".$critieria[$search_options]." ORDER BY `business_name` ASC LIMIT 0,100;";
					}
				$query = mysql_query($query_statement);
				$number_return = mysql_num_rows($query);
				if($number_return != 0){
					$return = "Found ".$number_return." records!";
					if($number_return >= 100) $return = "Found over ".$number_return." records! But to avoid server overload, only the first 100 results are displayed."; 
					while($rec = mysql_fetch_assoc($query)){
						$return .= $this->buildCard($rec);
						}
					}else $return = "There where no records that match your search.";
				}else $return = "Due to the large amount of data in the database, search must be 3 or more characters long.";
			}else $return = "Please enter something in the search field.";
		
		return($return);
		}

	function streetSearchFunction($search=""){
		if(isset($_GET["street"])) $street = addslashes($_GET["street"]);
		if(isset($_GET["city"])) $city = addslashes($_GET["city"]);
		if(trim($street) != ""){
			if(strlen($street) > 2){
				$query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE `full_address` LIKE '%".$street."%' AND `city_name` LIKE '%".$city."%' ORDER BY `business_name` ASC;";
				$query = mysql_query($query_statement);
				echo mysql_error();
				$number_return = mysql_num_rows($query);
				if($number_return != 0){
					$return = "Found ".$number_return." records!";
					while($rec = mysql_fetch_assoc($query)) $return .= $this->buildCard($rec);
					}else $return = "There where no records that match your search.";
				}else $return = "Due to the large amount of data in the database, search must be 3 or more characters long.";
			}else $return = "Please enter something in the search field.";
		
		return($return);
		}

	function buildCard($rec=""){
		if($rec == "") $rec = $this->rec;
		$able_link = "<a href=\"confirm_action.php?id=".$rec["record_id"]."&action=disable\" class=\"extra-small green bold\">DISABLE</a>\r\n";
		$style = "black";
		if($rec[status] == "2"){
			$able_link = "<a href=\"confirm_action.php?id=".$rec["record_id"]."&action=enable\" class=\"extra-small green bold\">ENABLE</a>\r\n";
			$style = "red";
			}
		$result  = "<p class=\"ltgreen\"><span class=\"large ".$style." bold\">".stripslashes($rec["business_name"])."</span>&nbsp;&nbsp;&nbsp;".stripslashes($rec["full_address"])." ".stripslashes($rec["city_name"])." ".$rec["state_code"]." ".$rec["zip"]."<br/>\r\n";
		if($rec["phone"] != "") $result .= fixPhone($rec["phone"])."&nbsp;&nbsp;&nbsp;".$rec["web_address"]."<br/>\r\n";
		$result .= "<a href=\"company_view.php?id=".$rec["record_id"]."\"        class=\"extra-small green bold\">VIEW</a>&nbsp;&nbsp;\r\n";
		$result .= "<a href=\"company_edit.php?id=".$rec["record_id"]."\"        class=\"extra-small green bold\">GENERAL & SEARCH TERMS</a>&nbsp;&nbsp;\r\n";
		$result .= "<a href=\"company_media.php?id=".$rec["record_id"]."\"       class=\"extra-small green bold\">MEDIA</a>&nbsp;&nbsp;\r\n";
		$result .= "<a href=\"company_profile.php?id=".$rec["record_id"]."\"     class=\"extra-small green bold\">PROFILE</a>&nbsp;&nbsp;\r\n";
		$result .= "<a href=\"company_product.php?id=".$rec["record_id"]."\"     class=\"extra-small green bold\">PRODUCT</a>&nbsp;&nbsp;\r\n";
		$result .= "<a href=\"company_categories.php?id=".$rec["record_id"]."\"  class=\"extra-small green bold\">CATEGORIES</a>&nbsp;&nbsp;\r\n";
		$result .= "<a href=\"company_advertising.php?id=".$rec["record_id"]."\" class=\"extra-small green bold\">ADVERTISING</a>&nbsp;&nbsp;\r\n";
		$result .= "<a href=\"company_extras.php?id=".$rec["record_id"]."\"      class=\"extra-small green bold\">EXTRAS & ICONS</a>&nbsp;&nbsp;\r\n";
		$result .= "<a href=\"gift_cards.php?id=".$rec["record_id"]."\"          class=\"extra-small green bold\">GIFT CARDS</a>&nbsp;&nbsp;\r\n";
		$result .= $able_link;
		$result .= "</p>\r\n";
		return($result);
		}
	
	function showCategory($cat_number, $field=""){
		$query_statement = "SELECT * FROM `".CAT_TABLE_NAME."` WHERE `id` = '".$cat_number."';";
		$query = mysql_query($query_statement);
		if(mysql_num_rows($query) >= 1){
			$rec   = mysql_fetch_assoc($query);	
			$return = $rec["lvl1_id"]." ".$rec["lvl1_name"];
			if($rec["lvl2_name"] != "") $return .= " - ".$rec["lvl2_name"];
			$return .= " &nbsp;&nbsp;&nbsp; <a href=\"".$_SERVER["PHP_SELF"]."?id=".$_REQUEST["id"]."&remove=".$field."\" class=\"field-info expandable-link\">[ remove ]</a>";
			}
		else $return = "Category not found.";
		return($return);
		}

	function showBusinessHours($str){
		$day_key = array(0 => "Sun", 1 => "Mon", 2 => "Tue", 3 => "Wed", 4 => "Thu", 5 => "Fri", 6 => "Sat");
		$days    = explode("|", $str);
		$result  = "<div class=\"hofo-container\">\r\n";
		$result .= "<h5 class=\"medium black\" style=\"margin: 3px 0px;\"><u>Business Hours</u></h5>\r\n";
		foreach($days as $key => $hours){
			if($hours != "00:00-00:00"){
				$subresult .= "\t<div class=\"hofo-days small\">\r\n";
				$subresult .= "\t".$day_key[$key]."</div>\r\n";
				$subresult .= "\t<div class=\"hofo-hours small\">\r\n";
				$time = null;
				if($hours == "CL")     $time = "Closed";
				elseif($hours == "BA") $time = "By Appointment";
				else{
					$hour = explode("-", $hours);
					$time = standardTime($hour[0])." - ".standardTime($hour[1]);
					}
				$subresult .= "\t".$time."</div>\r\n";
				}
			}
		if($subresult != "") $result .= $subresult."</div>\r\n";
		else $result = "Hours not available.  Contact company for hours of operation.";
		return($result);
		}

	function listCategories(){
		$query_statement = "SELECT * FROM `".CAT_TABLE_NAME."`;";
		if(trim($_POST["filter"]) != "") $query_statement = "SELECT * FROM `".CAT_TABLE_NAME."` WHERE `lvl1_name` LIKE '%".$_POST["filter"]."%' OR `lvl1_name` LIKE '%".$_POST["filter"]."%';";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query)){
			$id = $rec["lvl1_id"].$rec["lvl2_id"]."00";
			$build .= "<option value=\"".$rec["id"]."\">".$id." ".$rec["lvl1_name"]." ".$rec["lvl2_name"]."</option>\r\n";
			}
		return($build);
		}
	
	function updateData($field,$value,$id){
		$query_statement = "UPDATE `".MP_TABLE_NAME."` SET `".addslashes($field)."` = '".addslashes($value)."' WHERE `record_id` = '".$id."';";
		$query = mysql_query($query_statement);
		if("" == mysql_error()) return(true);
		return(false);
		}

	function buildBusinessForm(){
		$elements = explode("|", $this->rec["business_hours"]);
				for($i=0;$i<=6;$i++){
			$check_ba = "";
			if($elements[$i] == "BA") $check_ba = " checked";
			$check_cl = "";
			if($elements[$i] == "CL") $check_cl = " checked";
			$open_hour  = substr($elements[$i],0,2);
			$open_min   = substr($elements[$i],3,2);
			$close_hour = substr($elements[$i],6,2);
			$close_min  = substr($elements[$i],9,2);
			$build .= "<tr>\r\n";
			$build .= "<td class=\"field-name\">".date("l", mktime(0,0,0,11,$i+1,2009)).":</td>\r\n";
			$build .= "<td class=\"field-value\">";
			$build .= "Open from <select name=\"day[".$i."][o_hour]\">".$this->buildHourSelect($open_hour)."</select>\r\n";
			$build .= "<select name=\"day[".$i."][o_min]\">".$this->buildMinuteSelect($open_min)."</select>";
			$build .= " to <select name=\"day[".$i."][c_hour]\">".$this->buildHourSelect($close_hour)."</select>\r\n";
			$build .= "<select name=\"day[".$i."][c_min]\">".$this->buildMinuteSelect($close_min)."</select>&nbsp;&nbsp;";
			$build .= "<input type=\"checkbox\" name=\"day[".$i."][by_appointment]\"".$check_ba."> By Appointment&nbsp;&nbsp;";
			$build .= "<input type=\"checkbox\" name=\"day[".$i."][closed]\"".$check_cl."> Closed";
			$build .= "</td>\r\n";
			$build .= "</tr>\r\n";
			}
		return($build);
		}

	function buildHourSelect($selected){
		for($i=0;$i<=23;$i++){
			$select = "";
			if($i == $selected) $select = " selected";
			$build .= "<option value=\"".date("H",mktime($i,0,0,11,1,2009))."\"".$select.">".date("G",mktime($i,0,0,11,1,2009))."</option>\r\n";
			}
		return($build);
		}

	function buildMinuteSelect($selected){
		for($i=0;$i<=59;$i++){
			$select = "";
			if($i == $selected) $select = " selected";
			$build .= "<option value=\"".date("i",mktime(0,$i,0,11,1,2009))."\"".$select.">".date("i",mktime(0,$i,0,11,1,2009))."</option>\r\n";
			}
		return($build);
		}

	function getMedia($type,$modify="no"){
		switch($type){
			case "bizlogo":
				$photo = PATHTODATADIR."/".$this->rec["record_id"]."/bizlogo.jpg";
				if(is_file($photo)){
					$build .= "<img src=\"".HTMLTODATADIR."/".$this->rec["record_id"]."/bizlogo.jpg"."?nocache=".date("Ymdhis")."\">";
					if($modify=="yes") $build .= $this->createMediaOptions($type,"bizlogo.jpg");
					}else{
					if($modify=="yes") $build .= "<a onclick=\"document.getElementById('add_bizlogo').style.display='block';\" class=\"field-info expandable-link\">ADD BUSINESS LOGO PHOTO</a>";
					}
				break;
			case "sponsor":
				$photo = PATHTODATADIR."/".$this->rec["record_id"]."/sponsor.jpg";
				if(is_file($photo)){
					$build .= "<img src=\"".HTMLTODATADIR."/".$this->rec["record_id"]."/sponsor.jpg"."?nocache=".date("Ymdhis")."\" width=300>";
					if($modify=="yes") $build .= $this->createMediaOptions($type,"sponsor.jpg");
					}else{
					if($modify=="yes") $build .= "<a onclick=\"document.getElementById('add_sponsor').style.display='block';\" class=\"field-info expandable-link\">ADD SPONSOR PHOTO</a>";
					}
				break;
			case "gallery":
				$dir     = PATHTODATADIR."/".$this->rec["record_id"];
				$dirhttp = HTMLTODATADIR."/".$this->rec["record_id"];
				$files = scandir($dir);
				if(is_array($files)){
					foreach($files as $key => $file){
						if(substr($file,0,7) == "gallery") $gallery[] = $file;
						}
					}
				if(is_array($gallery)){
					foreach($gallery as $key => $value){
						$build .= "<div class=\"photo-gallery-preview\"><img src=\"".$dirhttp."/".$value."?nocache=".date("Ymdhis")."\" height=300>";
						if($modify=="yes") $build .= $this->createMediaOptions($value,$value,"yes","no");
						$build .= "</div>";
						}
					}
				if($modify=="yes") $build .= "<a onclick=\"document.getElementById('add_gallery_new').style.display='block';\" class=\"field-info expandable-link\">ADD NEW GALLERY PHOTO</a>";
				break;
			case "video":
				$dir     = PATHTODATADIR."/".$this->rec["record_id"];
				$dirhttp = HTMLTODATADIR."/".$this->rec["record_id"];
				$files = scandir($dir);
				if(is_array($files)){
					foreach($files as $key => $file){
						if(substr($file,0,5) == "video")   $video_gallery[] = $file;
						if(substr($file,0,7) == "youtube") $youtube_gallery[] = $file;
						}
					}
				if(is_array($video_gallery)){
					foreach($video_gallery as $key => $value){
						$videohttp = HTMLTODATADIR."/".$this->rec["record_id"]."/".$value;
						$build .= "<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"400\" height=\"320\">\r";
						$build .= "<param name=\"SRC\" value=\"".$videohttp."\">\r <param name=\"AUTOPLAY\" value=\"true\">\r <param name=\"CONTROLLER\" value=\"true\">\r";
						$build .= "<embed src=\"".$videohttp."\" scale=\"tofit\" autoplay=\"false\" controller=\"true\" pluginspage=\"http://www.apple.com/quicktime/download/\" width=\"400\" height=\"320\"></embed></object>\r";
						if($modify=="yes") $build .= $this->createMediaOptions($value,$value,"yes","no");
						$build .= "<br/><br/>";
						}
					}
				if(is_array($youtube_gallery)){
					foreach($youtube_gallery as $key => $value){
						$videohttp = PATHTODATADIR."/".$this->rec["record_id"]."/".$value;
						$fopen = fopen($videohttp, "r");
						$fread = fread($fopen, filesize($videohttp));
						$build .= $fread;
						if($modify=="yes") $build .= $this->createMediaOptions($value,$value,"yes","no");
						$build .= "<br/><br/>";
						}
					}
				if($modify=="yes") $build .= "<a onclick=\"document.getElementById('add_video_new').style.display='block';\" class=\"field-info expandable-link\">ADD NEW VIDEO</a>";
				if($modify=="yes") $build .= $this->createMediaOptions("gallery_new","gallery_new","no");
				break;
			}
		return($build);
		}
	
	function createMediaOptions($type,$file,$exists="yes",$showupdate="yes"){
		if($exists == "yes"){ 
			$build  = "<br/>";
			if($showupdate == "yes") $build .= "<a onclick=\"document.getElementById('add_".$type."').style.display='block'; document.getElementById('remove_".$type."').style.display='none'\" class=\"field-info expandable-link\">UPDATE</a> &nbsp;&nbsp;";
			$build .= "<a onclick=\"document.getElementById('remove_".$type."').style.display='block'; document.getElementById('add_".$type."').style.display='none'\" class=\"field-info expandable-link\">REMOVE</a> &nbsp;&nbsp;";
			}
		$build .= "<div id=\"remove_".$type."\" style=\"display:none;\">Are you sure you want to remove this? &nbsp;&nbsp;&nbsp;";
		$build .= "<a onclick=\"document.getElementById('remove_".$type."').style.display='none'\" class=\"field-info expandable-link\">NO</a> &nbsp;&nbsp;";
		$build .= "<a href=\"".$_SERVER["PHP_SELF"]."?id=".$_GET["id"]."&remove=".$file."\" class=\"field-info expandable-link\">YES</a></div>";
		return($build);
		}

	function saveMedia(){
		$to_dir = PATHTODATADIR."/".$this->rec["record_id"];
		if($_FILES["sponsor"]["name"] != ""){
			$name = "sponsor";
			$file_name = $name.".jpg";
			$to_file   = $to_dir."/".$file_name;
			$this->saveFile($_FILES[$name]["tmp_name"],$to_dir,$file_name);
			}
		if($_FILES["gallery"]["name"] != ""){
			$name = "gallery_".date("Ymdhis");
			$file_name = $name.findExtension("gallery");
			$to_file   = $to_dir."/".$file_name;
			$this->saveFile($_FILES["gallery"]["tmp_name"],$to_dir,$file_name);
			$i++;
			}
		if($_FILES["video"]["name"] != ""){
			$name = "video_".date("Ymdhis");
			$file_name = $name.".mov";
			$to_file   = $to_dir."/".$file_name;
			$this->saveFile($_FILES["video"]["tmp_name"],$to_dir,$file_name);
			}
		if($_POST["youtube"] != ""){
			$name = "youtube_".date("Ymdhis");
			$file_name = $name.".txt";
			$to_file   = $to_dir."/".$file_name;
			$fopen = fopen($to_file, "w");
			fwrite($fopen,stripslashes($_POST["youtube"]));
			fclose($fopen);
			}
		if($_FILES["bizlogo"]["name"] != ""){
			$name = "bizlogo";
			$file_name = $name.".jpg";
			$to_file   = $to_dir."/".$file_name;
			$this->saveFile($_FILES[$name]["tmp_name"],$to_dir,$file_name);
			}
		return($return);
		}

	function saveFile($from_file,$to_dir,$file_name){
		if(!is_dir($to_dir)) mkdir($to_dir) or die("Error: Could not make data directory - ".$to_dir.".  Please check folder permissions.");
		$to_file = $to_dir."/".$file_name;
		if(is_file($to_file)){
			copy($to_file, $to_dir."/".date("Ymdhis").$file_name);
			unlink($to_file);
			}
		copy($from_file,$to_file);
		unlink($from_file);
		}

	function removeMedia($file){
		$to_dir  = PATHTODATADIR."/".$this->rec["record_id"];
		$to_file = $to_dir."/".$file;
		copy($to_file,$to_dir."/".date("Ymdhis").$file);
		unlink($to_file) or die("Please check file permissions.");
		return($return);
		}
	
	function updateStatus($status){
		mysql_query("UPDATE `".MP_TABLE_NAME."` SET `status` = '".$status."' WHERE `record_id` = '".$this->rec["record_id"]."';");
		return;
		}
	
	function pullIcons($biz_only="no"){
		$query_statement = "SELECT * FROM `".ICON_TABLE_NAME."` WHERE `status` = '1' ORDER BY `name` ASC;";
		$query = mysql_query($query_statement);
		$icons = explode(";", $this->rec["icons"]);
		if(is_array($icons)){
			foreach($icons as $key => $icon) $rem_icon[$icon] = " checked";
			}
		while($rec = mysql_fetch_assoc($query)){
			if($biz_only == "no")      $build .= "<div class=\"icon-select\"><input type=\"checkbox\" name=\"icon[]\" value=\"".$rec["id"]."\"".$rem_icon[$rec["id"]]."><img src=\"".HTMLTOICONDIR."/".$rec["file"]."?nocache=".date(Ymdhis).rand(1,1000)."\" border=0>".$rec["name"]."</div>\r\n";
			elseif($biz_only == "yes" && $rem_icon[$rec["id"]] == " checked") $build .= "<div class=\"icon-select\"><img src=\"".HTMLTOICONDIR."/".$rec["file"]."?nocache=".date(Ymdhis).rand(1,1000)."\" border=0>".$rec["name"]."</div>\r\n";
			}
		return($build);
		}
	
	function saveIcons(){
		if(is_array($_POST["icon"])){
			foreach($_POST["icon"] as $key => $icon) $build .= $icon.";";
			}
		mysql_query("UPDATE `".MP_TABLE_NAME."` SET `icons` = '".$build."' WHERE `record_id` = '".$this->rec["record_id"]."';");
		return;
		}

	function getServiceDirectories(){
		$query_statement = "SELECT * FROM `".SD_TABLE_NAME."` ORDER BY `category` ASC;";
		$query = mysql_query($query_statement);
		$build  = "<select name=\"fields[sd_cat]\">";
		$build .= "<option value=\"\">Do not add this business to the Service Directory page.</option>\r\n";
		while($rec = mysql_fetch_assoc($query)){
			$rem_service_dir[$this->rec["sd_cat"]] = " selected";
			$build .= "<option value=\"".$rec["id"]."\"".$rem_service_dir[$rec["id"]].">".stripslashes($rec["category"])."</option>\r\n";
			}
		$build .= "</select>";
		return($build);
		}

	function addServiceDirectoryCat(){
		$query_statement = "SELECT * FROM `".SD_TABLE_NAME."` WHERE `category` = '".addslashes($_POST["new_sd_cat"])."';";
		$query = mysql_query($query_statement);
		if(mysql_num_rows($query) >= 1){
			$rec = mysql_fetch_assoc($query);
			$id = $rec["id"];
			}else{
			$query_statement = "INSERT INTO `".SD_TABLE_NAME."` (`category`) VALUES ('".addslashes($_POST["new_sd_cat"])."');";
			$query = mysql_query($query_statement);
			$id = mysql_insert_id();
			}
		$this->updateData("sd_cat", $id, $_POST["id"]);
		return;
		}






                                                                                                                                                                                                                                                            /*
	NEW PUBLIC FUNCTIONS START HERE <------------------------------------------------------------------------------------------------------------ 
                                                                                                                                                                                                                                                            */ 
	function mostRequested(){
		global $home_page_cats;
		$index_page = $_GET["p"];
		if($index_page == "") $index_page = array_rand($home_page_cats);
		foreach($home_page_cats[$index_page]["subs"] as $key => $values) $mysql .= " OR `sic_1` LIKE '".$key."%' OR `sic_2` LIKE '".$key."%' OR `sic_3` LIKE '".$key."%' OR `sic_4` LIKE '".$key."%' OR `sic_5` LIKE '".$key."%' OR `sic_6` LIKE '".$key."%'";
		$build = "<div class='black extra-large' style='display: block; clear: both; text-align: center; padding: 15px 0px 10px 0px;'>Most Requested</div>";
		$query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE '1'='2' $mysql HAVING `counter_view` >= '1' AND status != '9' ORDER BY `counter_view` DESC LIMIT 2;";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query)){
			$this->updateStats($rec["record_id"],"list");
			$build .= "<a href=\"goto.php?id=".$rec['record_id']."&t=d\" class=\"large\">".$rec['business_name']."<br/>\r <span class=\"extra-small\">Get Listing Information</span></a>\r";
			}
		return($build);
		}
	
	function updateStats($id,$type){
		if($type == "view")  $query_statement = "UPDATE `".MP_TABLE_NAME."` SET `counter_view` = `counter_view`+1 WHERE `record_id` = '".$id."';";
		if($type == "list")  $query_statement = "UPDATE `".MP_TABLE_NAME."` SET `counter_list` = `counter_list`+1 WHERE `record_id` = '".$id."';";
		if($type == "click") $query_statement = "UPDATE `".MP_TABLE_NAME."` SET `counter_web`  = `counter_web`+1  WHERE `record_id` = '".$id."';";
		mysql_query($query_statement);
		return;
		}
	
	function cardSericeDirectory($rec){
		$result = "";
		if($rec["sponsor_flag"] == "1") $result .= "<img src=\"".IMAGEDIR."/sponsor_logo.jpg\" style=\"display: block; float: left; border:0; margin: 0px 10px 0px 0px;;\">\r\n";
		$bold = "";
		if($rec["bold_flag"] == "1") $bold = " bold";
		$result .= "<span class=\"large black".$bold."\">".stripslashes($rec["business_name"])."</span>&nbsp;&nbsp;\r\n";
		$result .= "<span class=\"medium blue\">";
		if($rec["phone"] != "") $result .= fixPhone($rec["phone"])."\r\n";
		if(trim($rec["web_address"]) != "") $result .= " | <a href=\"goto.php?id=".$rec['record_id']."&t=w\" class=\"medium blue underline\" target=\"_blank\">Visit Web Site</a>\r\n";
		$result .= "</span>";
		$result .= "<span class=\"medium blue\">";
		if(trim($rec["full_address"]) != "") $result .= "<br/>".stripslashes($rec["full_address"]).", \r\n";
		if(trim($rec["city_name"]) != "") $result .= stripslashes($rec["city_name"]).", ";
		if(trim($rec["state_code"]) != "") $result .= $rec["state_code"]." ";
		if(trim($rec["zip"]) != "" && trim($rec["zip"]) != 0) $result .= $rec["zip"]."\r\n";
		if($rec["sd_profile"] != "") $result .= "</span><span class='medium black'><br/><i>".$rec["sd_profile"]."</i>\r\n";
		if($rec["sponsor_flag"] == "1") $result .= "<br/><a href=\"goto.php?id=".$rec["record_id"]."&t=d\" class='medium blue'>Click for Profile</a>\r\n";
		$result .= "</span><br/>\r\n";		
		return($result);
		}
	
	
	
	}

?>