<?php

class handleGiftCards {
	public $rec,$id,$card_id,$key;
	
	function __construct(){
		
		}
	
	function loadCard(){
		$card_id = $_REQUEST["cid"];
		$key     = $_REQUEST["key"];
		$query_statement = "SELECT *, `".GC_TABLE_NAME."`.`id` as `main_id`, `".GENERAL_CATEGORIES."`.`id` as `category_id`, `".GENERAL_CATEGORIES."`.`name` as `category_name` FROM `".GENERAL_CATEGORIES."`, `".GC_TABLE_NAME."`, `".GC_CARDS_NAME."` WHERE `".GC_CARDS_NAME."`.`giftcard_id` = `".GC_TABLE_NAME."`.`id` AND `".GENERAL_CATEGORIES."`.`id` = `".GC_CARDS_NAME."`.`category` AND `".GC_CARDS_NAME."`.`id` = '".$card_id."' AND `".GC_CARDS_NAME."`.`key` = '".$key."';";
		$query = mysql_query($query_statement);
		if(mysql_num_rows($query) === 1){
			$this->rec = mysql_fetch_assoc($query);
			return;
			}else{
			header("location: gift_cards_missing.php?id=".$this->id);
			exit;
			}
		}
	
	function getGiftCards(){
		global $giftcard_status;
		$query_statement = "SELECT * FROM `".GC_TABLE_NAME."` WHERE `marketplace_id` = '".$this->id."';";
		$query = mysql_query($query_statement);
		if(mysql_num_rows($query) == 0) $build = "No gift cards where found.";
		else{
			$build = "<ol class=\"cardlist\" id=\"list_".$rec["id"]."\">\n";
			while($rec = mysql_fetch_assoc($query)){
				$query_statement2 = "SELECT * FROM `".GC_CARDS_NAME."` WHERE `giftcard_id` = '".$rec["id"]."';";
				$query2 = mysql_query($query_statement2);
				$build .= "<li>".stripslashes($rec["name"])." &nbsp;&nbsp; <a onclick=\"document.getElementById('subcardlist_".$rec["id"]."').style.display='block';\" class=\"field-info expandable-link\">VIEW DETAILS</a></li>";
				$stats = "";
				$listbuild = null;
				while($rec2 = mysql_fetch_assoc($query2)){
					$stats["total"]++;
					$stats[$rec2["status"]]++;
					$add_update_link = " &nbsp;&nbsp; <a href=\"gift_cards_manage.php?id=".$this->id."&cid=".$rec2["id"]."&key=".$rec2["key"]."\" class=\"extra-small expandable-link\">[VIEW]</a>";
					if($rec2["status"] == "1") $add_update_link = " &nbsp;&nbsp; <a href=\"gift_cards_manage.php?id=".$this->id."&cid=".$rec2["id"]."&key=".$rec2["key"]."\" class=\"extra-small expandable-link\">[VIEW/UPDATE]</a>";
					$listbuild .= "<li>Gift card: $".number_format($rec2["value"],2)." face value, priced at $".number_format($rec2["price"],2)." - ".$giftcard_status[$rec2["status"]].$add_update_link."</li>";
					}
				$build .= "<ol class=\"subcardlist\" id=\"subcardlist_".$rec["id"]."\" style=\"display:none;\"><p class=\"ltgreen\">".number_format($stats[1])." of ".number_format($stats["total"])." available</p>".$listbuild;
				$build .= "<p>".$rec["restrictions"]."</p>";
				$build .= "<p><a onclick=\"document.getElementById('subcardlist_".$rec["id"]."').style.display='none';\" class=\"field-info expandable-link\">HIDE DETAILS</a></p></ol>";
				}
			$build .= "</ol>";
			}
		return($build);
		}
	
	function createGiftCards(){
		global $user;
		$temp_shorts = array("price" => $_POST["fields"]["cost"], "value" => $_POST["fields"]["face_value"]);
		$restrictions = $_POST["fields"]["restrictions"];
		foreach($temp_shorts as $key => $value) $restrictions = str_replace("[".$key."]", $value, $restrictions);
		$query_statement = "INSERT INTO `".GC_TABLE_NAME."` (`name`,`value`,`price`,`quantity`,`date_submitted`,`admin`,`marketplace_id`,`restrictions`) VALUES ('".addslashes($_POST["fields"]["name"])."','".$_POST["fields"]["face_value"]."','".$_POST["fields"]["cost"]."','".$_POST["fields"]["quantity"]."','".TODAY."','".$user->user_info[0]."','".$this->id."','".addslashes($restrictions)."');";
		mysql_query($query_statement);
		$gc_id = mysql_insert_id();		
		for($i=1;$i<=$_POST["fields"]["quantity"];$i++){
			$query_statement = "INSERT INTO `".GC_CARDS_NAME."` (`category`,`value`,`price`,`giftcard_id`,`status`,`key`,`admin`,`date_created`) VALUES ('".$_POST["fields"]["category"]."','".$_POST["fields"]["face_value"]."','".$_POST["fields"]["cost"]."','".$gc_id."','1','".genKey(80)."','".$user->user_info[0]."','".TODAY."');";
			mysql_query($query_statement);
			}		
		return;
		}
	
	function getPurchaseInfo(){
		if($this->rec["status"] == 1){
			$build  = "This gift card is still available for purchase.";
			}elseif($this->rec["status"] == 2){
			$query_statement = "SELECT *, SUBSTR(AES_DECRYPT(`cc_numb`, '".MYSQL_CRYPT_KEY."'),-4) AS `dcc_numb` FROM `".GC_INVOICES."` WHERE `id` = '".$this->rec["inv_numb"]."';";
			$query = mysql_query($query_statement);
			$rec = mysql_fetch_assoc($query);
			$build  = "<table class=\"form\">";
	    $build .= "<tr>";
		  $build .= "<td class=\"field-name\">Buyer's Name:</td>";
		  $build .= "<td class=\"field-value\">".$rec["fname"]." ".$rec["lname"]."</td>";
		  $build .= "</tr>";
	    $build .= "<tr>";
		  $build .= "<td class=\"field-name\">Address:</td>";
		  $build .= "<td class=\"field-value\">".$rec["address"]." ".$rec["city"]." ".$rec["state"]." ".$rec["zip"]."</td>";
		  $build .= "</tr>";
	    $build .= "<tr>";
		  $build .= "<td class=\"field-name\">Phone:</td>";
		  $build .= "<td class=\"field-value\">".fixPhone($rec["phone"])."</td>";
		  $build .= "</tr>";
	    $build .= "<tr>";
		  $build .= "<td class=\"field-name\">Email:</td>";
		  $build .= "<td class=\"field-value\">".$rec["email"]."</td>";
		  $build .= "</tr>";
	    $build .= "<tr>";
		  $build .= "<td class=\"field-name\">Shipped To:</td>";
		  $build .= "<td class=\"field-value\">".$rec["ship_fname"]." ".$rec["ship_lname"]."</td>";
		  $build .= "</tr>";
	    $build .= "<tr>";
		  $build .= "<td class=\"field-name\">Address:</td>";
		  $build .= "<td class=\"field-value\">".$rec["ship_address"]." ".$rec["ship_city"]." ".$rec["ship_state"]." ".$rec["ship_zip"]."</td>";
		  $build .= "</tr>";
	    $build .= "<tr>";
		  $build .= "<td class=\"field-name\">Date Sold:</td>";
		  $build .= "<td class=\"field-value\">".fixDate($this->rec["date_sold"])."</td>";
		  $build .= "</tr>";
	    $build .= "<tr>";
		  $build .= "<td class=\"field-name\">Invoice Number:</td>";
		  $build .= "<td class=\"field-value\">".$rec["id"]."</td>";
		  $build .= "</tr>";
	    $build .= "<tr>";
		  $build .= "<td class=\"field-name\">Transaction Number:</td>";
		  $build .= "<td class=\"field-value\">".$rec["trans_numb"]."</td>";
		  $build .= "</tr>";
	    $build .= "<tr>";
		  $build .= "<td class=\"field-name\">Credit Card Number:</td>";
		  $build .= "<td class=\"field-value\">**** **** **** ".$rec["dcc_numb"]."</td>";
		  $build .= "</tr>";
	    $build .= "</table>";
	    }else $build = "This gift card is not available to purchase.  See \"status\" for details.";
		return($build);
		}
	
	function editStatus(){
		global $giftcard_status; 
		if($this->rec["status"] != 1) return($giftcard_status[$this->rec["status"]]);
		else{
			$build  = $giftcard_status[$this->rec["status"]]." &nbsp;&nbsp; <span class=\"small green\">Change to: </span>";
			$build .= "<select name=\"status\">";
			foreach($giftcard_status as $key => $value){
				if($key !== 2) $build .= "<option value=\"".$key."\">".$value."</option>";
				}
			$build .= "</select> <input type=\"submit\" name=\"submit\" value=\"Update\">";
			}
		return($build);
		}
	
	function editCategory(){
		if($this->rec["status"] == "1"){
			$build  = " &nbsp;&nbsp; <span class=\"small green\">Change to: </span>";
			$build .= "<select name=\"category\">";
			$query_statement = "SELECT * FROM `".GENERAL_CATEGORIES."` ORDER BY `name` ASC;";
			$query = mysql_query($query_statement);
			$rem_category[$this->rec["category_id"]] = "selected";
			while($rec = mysql_fetch_assoc($query)) $build .= "<option value=\"".$rec["id"]."\" ".$rem_category[$rec["id"]].">".$rec["name"]."</option>";
			$build .= "</select> <input type=\"checkbox\" name=\"change_series\"> <span class=\"small green\">Change series  <a href=\"#\" onmouseover=\"drc('If this option is turned on, all cards in this group will be update to the new category.  If you just want to change this one card, leave this box unchecked.','Marketplace Help Tool'); return true;\" onmouseout=\"nd(); return true;\" class=\"field-info\">[?]</a></span> &nbsp;&nbsp; <input type=\"submit\" name=\"submit\" value=\"Update\">";
			return($build);
			}else return;
		}
	
	function updateSeriesCategory(){
		$query_statement = "UPDATE `".GC_CARDS_NAME."` SET `category` = '".$_POST["category"]."' WHERE `giftcard_id` = '".$this->rec["giftcard_id"]."' AND `status` = '1';";
		$query = mysql_query($query_statement);
		if("" == mysql_error()) return(true);
		return(false);
		}


	function updateData($field,$value,$id){
		$query_statement = "UPDATE `".GC_CARDS_NAME."` SET `".addslashes($field)."` = '".addslashes($value)."' WHERE `id` = '".$this->rec["id"]."';";
		$query = mysql_query($query_statement);
		if("" == mysql_error()) return(true);
		return(false);
		}
	
	function updateNotes($mess){
		$notes = date("Y-m-d H:i")." ".addslashes($mess);
		$query_statement = "UPDATE `".GC_CARDS_NAME."` SET `notes` = CONCAT(`notes`,'".$notes."') WHERE `id` = '".$this->rec["id"]."';";
		$query = mysql_query($query_statement);
		}
		
	function getCategoriesOption(){
		$query_statement = "SELECT * FROM `".GENERAL_CATEGORIES."` ORDER BY `name` ASC;";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query)) $build .= "<option value=\"".$rec["id"]."\">".$rec["name"]."</option> ";
		return($build);
		}
		
	function getCategories(){
		$query_statement = "SELECT * FROM `".GC_CARDS_NAME."` WHERE `status` = '1';";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query)) $count[$rec["category"]]++;
		$query_statement = "SELECT * FROM `".GENERAL_CATEGORIES."` ORDER BY `name` ASC;";
		$query = mysql_query($query_statement);
		while($ord = mysql_fetch_assoc($query)){
			if($count[$ord["id"]] > 0) $build .= "<a href=\"".$_SERVER["PHP_SELF"]."?category=".$ord["id"]."\" class=\"white bold large\">".$ord["name"]." <span class=\"small normal\">(".$count[$ord["id"]].")</span></a> ";
			}
		return($build);
		}
		
	function getDeals(){
		$query_statement = "SELECT * FROM `".MP_TABLE_NAME."`, `".GC_TABLE_NAME."` WHERE`".MP_TABLE_NAME."`.`record_id` = `".GC_TABLE_NAME."`.`marketplace_id` ORDER BY RAND() LIMIT 0,10;";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query)){
			$query_statement = "SELECT * FROM `".GC_CARDS_NAME."` WHERE `giftcard_id` = '".$rec["id"]."' AND `status` = '1';";
			$queryA = mysql_query($query_statement);
			$count = mysql_num_rows($queryA);
			if($count == "0") $count = "sold out";
			$build .= "<a href=\"".$_SERVER["PHP_SELF"]."?company=".$rec["record_id"]."\" class=\"white\">".htmlspecialchars(stripslashes($rec["business_name"]))." <span class=\"small normal\">(".$count.")</span></a> ";
			}
		return($build);
		}
		
	function buildPreview($count=1){
		$query_statement = "SELECT * FROM `".MP_TABLE_NAME."`, `".GC_TABLE_NAME."` WHERE `".MP_TABLE_NAME."`.`record_id` = `".GC_TABLE_NAME."`.`marketplace_id` ORDER BY RAND();";
		$query = mysql_query($query_statement);
		$counter = 1;
		while($rec = mysql_fetch_assoc($query)){
			$query_statement = "SELECT * FROM `".GC_CARDS_NAME."` WHERE `giftcard_id` = '".$rec["id"]."' AND `status` = '1';";
			$queryA = mysql_query($query_statement);
			$quantity = mysql_num_rows($queryA);
			if($count != "0" && $counter <= $count){
				$build .= "<div class=\"gift-preview\">";
				$logo = PATHTODATADIR."/".$rec["record_id"]."/bizlogo.jpg";
				if(is_file($logo)) $build .= "<img src=\"".HTMLTODATADIR."/".$rec["record_id"]."/bizlogo.jpg\" border=1>";
				$build .= "<p class=\"gc-header\" style=\"margin-bottom: 6px;\">".htmlspecialchars(stripslashes($rec["business_name"]))."</p>";
				$build .= "<p class=\"gc-special\">List Price: <strike>\$".number_format($rec["value"],2)."</strike><br/>";
				$build .= "<p class=\"gc-special\">Sale Price: <span class=\"red\"><b>\$".number_format($rec["price"],2)."</b></span><br/>";
				if($quantity > 0) $build .= "Only ".$quantity." left!<br/>";
				else $build .= "Sold Out!<br/>";
				$build .= "<a href=\"".$_SERVER["PHP_SELF"]."?add=".$rec["id"]."\" class=\"add-to-cart-small\">Add To Cart</a>";
				$build .= "<a href=\"".$_SERVER["PHP_SELF"]."?company=".$rec["record_id"]."\" class=\"add-to-cart-info\">More Info</a>";
				$build .= "</div>";
				$counter++;
				}
			}
		return($build);
		}

	function buildCompanyList(){
		$query_statement = "SELECT * FROM `".MP_TABLE_NAME."` WHERE `".MP_TABLE_NAME."`.`record_id` = '".$_GET["company"]."';";
		$query1 = mysql_query($query_statement);
		$rec1 = mysql_fetch_assoc($query1);
		$logo = PATHTODATADIR."/".$rec1["record_id"]."/bizlogo.jpg";
		$build .= "<div class=\"gift-company\">";
		if(is_file($logo)) $build .= "<img src=\"".HTMLTODATADIR."/".$rec1["record_id"]."/bizlogo.jpg\" border=1><br/>";
		$build .= "<b>".htmlspecialchars(stripslashes($rec1["business_name"]))."</b><br/>";
		if($rec1["full_address"] != "") $build .= htmlspecialchars(stripslashes($rec1["full_address"]))."\r\n";
		if($rec1["city_name"] != "")    $build .= $rec1["city_name"]." ";
		if($rec1["state_code"] != "")   $build .= $rec1["state_code"]." ";
		if($rec1["zip"] != "")          $build .= $rec1["zip"]."<br/>\r\n";
		if($rec1["phone"] != "")        $build .= fixPhone($rec1["phone"])."\r\n";
		$build .= "<br/><a href=\"business_detail.php?id=".$rec1["record_id"]."\" class=\"small blue bold\">MAP</a>\r\n";
		$build .= "</div>";
		$query_statement = "SELECT * FROM `".GC_TABLE_NAME."` WHERE `".GC_TABLE_NAME."`.`marketplace_id` = '".$rec1["record_id"]."';";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query)){
			$query_statement = "SELECT * FROM `".GC_CARDS_NAME."` WHERE `giftcard_id` = '".$rec["id"]."' AND `status` = '1';";
			$queryA = mysql_query($query_statement);
			$quantity = mysql_num_rows($queryA);
			if($quantity > "0"){
				$recA = mysql_fetch_assoc($queryA);
				$i++;
				$cards .= "<div class=\"gift-company\">\r\n";
				$cards .= "<span class=\"black\">List Price: </span><span class=\"gc-special\"><strike>\$".number_format($rec["value"],2)."</strike></span><br/>\r\n";
				$cards .= "<span class=\"black\">Sales Price: </span><span class=\"gc-special\">\$".number_format($rec["price"],2)."</span><br/>\r\n";
				$cards .= "<span class=\"black\">Qty. Available: </span><span class=\"gc-special\">".$quantity."</span><br/>\r\n";
				$cards .= "<span class=\"extra-small black\">See Restriction List #".$i."</span><br/>\r\n";
				$cards .= "<a href=\"".$_SERVER["PHP_SELF"]."?company=".$_GET["company"]."&add=".$rec["id"]."\" class=\"add-to-cart\">Add To Cart</a>\r\n";
				$cards .= "</div>\r\n";
				$restriction_box .= "<div class=\"gift-restrictions\"><u>Restriction List #".$i."</u><br/>".$rec["restrictions"]."</div>";
				}
			}
		$build .= $cards;
		$build .= "<div class=\"gift-list\">".$rec1["profile_text"]."</div>";
		$build .= $restriction_box;
		return($build);
		}

	function buildCategoryList(){
		$build = "<h3 style=\"margin: 15px 10px 0px 15px;\">".$this->getCategoryName($_GET["category"])."</h3>";
		$query_statement = "SELECT * FROM `".MP_TABLE_NAME."`, `".GC_TABLE_NAME."` WHERE `".MP_TABLE_NAME."`.`record_id` = `".GC_TABLE_NAME."`.`marketplace_id` ORDER BY `business_name` ASC;";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query)){
			$query_statement = "SELECT * FROM `".GC_CARDS_NAME."` WHERE `giftcard_id` = '".$rec["id"]."' AND `status` = '1' AND `category` = '".$_GET["category"]."';";
			$queryA = mysql_query($query_statement);
			$quantity = mysql_num_rows($queryA);
			if($quantity > "0"){
				$recA = mysql_fetch_assoc($queryA);
				$build .= "<div class=\"gift-list\">";
				$logo = PATHTODATADIR."/".$rec["record_id"]."/bizlogo.jpg";
				if(is_file($logo)) $build .= "<img src=\"".HTMLTODATADIR."/".$rec["record_id"]."/bizlogo.jpg\" border=1><br/>";
				$build .= "<span class=\"gc-header\">".htmlspecialchars(stripslashes($rec["business_name"]))."</span><br/>";
				$build .= "<span class=\"gc-special\">\$".number_format($rec["value"],2)." <span class=\"small black\">for only</span> \$".number_format($rec["price"],2)."</span>&nbsp;&nbsp;";
				$build .= "Only ".$quantity." left!<br/>";
				$build .= "<a href=\"".$_SERVER["PHP_SELF"]."?category=".$_GET["category"]."&add=".$rec["id"]."\" class=\"blue\">Add To Cart</a>";
				$build .= "</div>";
				}
			}
		return($build);
		}

	function getCategoryName($number){
		$query_statement = "SELECT * FROM `".GENERAL_CATEGORIES."` WHERE `id` = '".$number."';";
		$query = mysql_query($query_statement);
		$rec = mysql_fetch_assoc($query);
		$name = $rec["name"];
		return($name);
		}











		
	}

?>