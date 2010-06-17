<?php

class handleLunchSpecial{
	public $menuid, $date, $adimages, $adspecial, $adheading, $adkeys, $adstats, $views;
	
	function __construct(){
		if($_REQUEST["menuid"] != "") $this->loadMenu();
		}
	
	function checkRequired(){
		$result = false;
		for($i=0;$i<$_POST["numads"];$i++){
			if($_POST["adselect"][$i]  != "" && ($_POST["adheading"][$i] == "" || $_POST["adspecial"][$i] == "")) $result = "It looks like you have an ad selected, but forgot to fill out the header and special.  Please revise ad #".($i +1).".";
			if($_POST["adheading"][$i] != "" && ($_POST["adselect"][$i] == ""  || $_POST["adspecial"][$i] == "")) $result = "It looks like you filled out heading information for an ad, but forgot to fill out the special or select the ad.  Please revise ad #".($i +1).".";
			if($_POST["adspecial"][$i] != "" && ($_POST["adheading"][$i] == "" || $_POST["adselect"][$i] == ""))  $result = "It looks like you filled out special information for an ad, but forgot to fill out the header or select the ad.  Please revise ad #".($i +1).".";
			if($result != false) break;
			}
		return($result);
		}
	
	function loadMenu(){
		$this->menuid = $_REQUEST["menuid"];
		$query_statement = "SELECT * FROM `".DB_LUNCHSPECIALMENUS."` WHERE `id` = '".$this->menuid."';";
		$query = mysql_query($query_statement);
		$rec = mysql_fetch_assoc($query);
		$this->date = $rec["date"];
		$this->views = $rec["views"];
		$query_statement = "SELECT * FROM `".DB_LUNCHSPECIALADS."` WHERE `menu` = '".$this->menuid."';";
		$query = mysql_query($query_statement);
		$i=0;
		while($rec = mysql_fetch_assoc($query)){
			$this->adkeys[$i]    = $rec["id"];
			$this->adimages[$i]  = $rec["ad"];
			$this->adheading[$i] = $rec["heading"];
			$this->adspecial[$i] = $rec["special"];
			$this->adstats[$i]   = $rec["stat"];
			$i++;
			}
		}
	
	function checkDate(){
		$return = false;
		$this->date = $_POST["year"].$_POST["month"].$_POST["day"];
		$query_statement = "SELECT * FROM `".DB_LUNCHSPECIALMENUS."` WHERE `date` = '".$this->date."' AND `id` != '".$this->menuid."';";
		$query = mysql_query($query_statement);
		if(mysql_num_rows($query) === 1){
			$query_statement = "SELECT * FROM `".DB_LUNCHSPECIALMENUS."` WHERE `date` >= '".date("Ymd")."';";
			$query = mysql_query($query_statement);
			while($rec = mysql_fetch_assoc($query)) $buildDate[$rec["date"]] = 1;
			for($i=0;$i<=1000;$i++){
				$jd_date  = gregoriantojd(substr($this->date,4,2), substr($this->date,6,2), substr($this->date,0,4))+$i;
				$exp      = explode("/", jdtogregorian($jd_date));
				$nextdate = date("Ymd", mktime(0,0,0,$exp[0],$exp[1],$exp[2]));
				if($buildDate[$nextdate] != 1){
					$nextAvail = $nextdate;
					break;
					}
				}
			$return = "That date is already taken.<br>The next available date is ".fixDate($nextAvail).".";
			}
		return($return);
		}
	
	function createAdDropDown($name="ad",$changer="",$i){
		global $advertising;
		$add_js = "";
		if($changer != "") $add_js = " onChange=\"document.getElementById('".$changer."').src=this.value;\"";
		$build .= "<select name=\"".$name."\"".$add_js.">\r";
		$build .= "<option value=\"\">Select Ad</option>\r";
		foreach($advertising as $cat => $values){
			foreach($values as $bizId => $advalue){
				foreach($advalue as $adNum => $value){
					$selectvalue = HTMLTODATADIR."/".$bizId."/".$value["file"];
					$remselection = "";
					if($this->adimages[$i] == $selectvalue) $remselection = " selected";
					$build .= "<option value=\"".$selectvalue."\"".$remselection.">".$value["num"]." - ".$value["name"]."</option>\r";
					}
				}
			}
		$build .= "</select>";
		return($build);
		}

	function buildForm(){
		static $number_of_ads;
		global $number_of_ads;
		$showNumRows = 5;
		$c=1;
		for($i=0;$i<$showNumRows;$i++){
			$build .= "<tr><td colspan=3><br/></td></tr>\r";
			$build .= "<tr>\r";
			$build .= "<td class=\"field-name\" valign=top>Select Ad #".$c.":</td>\r";
			$build .= "<td class=\"field-value\" valign=top>".$this->createAdDropDown("adselect[".$i."]", "adimage".$i, $i)."</td>\r";
			
			if($this->adimages[$i] != "") $build .= "<td class=\"image\" rowspan=3><img src=\"".$this->adimages[$i]."\" height=125 id=\"adimage".$i."\"></td>\r";
			else $build .= "<td class=\"image\" rowspan=3 valign=top><img src=\"".IMAGEDIR."/trans.gif\" height=125 id=\"adimage".$i."\"></td>\r";
			
			$build .= "</tr>\r";
			$build .= "<tr>\r";
			$build .= "<td class=\"field-name\" valign=top>Heading:</td>\r";
			$build .= "<td class=\"field-value\" valign=top><input type=\"text\" class=\"text\" name=\"adheading[".$i."]\" value=\"".stripslashes($this->adheading[$i])."\"></td>\r";
			$build .= "</tr>\r";
			$build .= "<tr>\r";
			$build .= "<td class=\"field-name\" valign=top>Special:</td>\r";
			$build .= "<td class=\"field-value\" valign=top><textarea name=\"adspecial[".$i."]\" class=\"special\">".stripslashes($this->adspecial[$i])."</textarea></td>\r";
			$build .= "</tr>\r";
			$c++;
			}
		$number_of_ads = $i;
		return($build);
		}

	function buildView(){
		if(is_array($this->adimages)){
			foreach($this->adimages as $key => $value){
				$ad_number = $key +1;
				$build .= "<tr><td colspan=3><br/></td></tr>\r";
				$build .= "<tr>\r";
			  $build .= "<td class=\"image\" rowspan=4 valign=top><img src=\"".$this->adimages[$key]."\" height=125></td>\r";
				$build .= "<td class=\"field-name\"  valign=top>Heading:</td>\r";
				$build .= "<td class=\"field-value\" valign=top>".stripslashes($this->adheading[$key])."</td>\r";
				$build .= "</tr>\r";
				$build .= "<tr>\r";
				$build .= "<td class=\"field-name\"  valign=top>Special:</td>\r";
				$build .= "<td class=\"field-value\" valign=top>".stripslashes($this->adspecial[$key])."</td>\r";
				$build .= "</tr>\r";
				$build .= "<tr>\r";
				$build .= "<td class=\"field-name\"  valign=top>Ad Stats:</td>\r";
				$build .= "<td class=\"field-value\" valign=top>".$this->readableStats($this->adstats[$key],"statbox".$key)."</td>\r";
				$build .= "</tr>\r";
				}
			$build .= "<tr><td colspan=3><br/></td></tr>\r";
			$number_of_ads = $i;
			}else $build = "There are no ads assigned to this menu.";
		return($build);
		}
	
	function readableStats($str,$boxname){
		if($str != ""){
			$ele = explode(";", $str);
			$build  = "<a onclick=\"document.getElementById('".$boxname."').style.display='block'\" class=\"expandable-link\">View Stats</a> | ";
			$build .= "<a onclick=\"document.getElementById('".$boxname."').style.display='none'\" class=\"expandable-link\">Hide Stats</a>";
			$build .= "<div id=\"".$boxname."\" class=\"expandable\">";
			foreach($ele as $key => $value){
				if($value != ""){
					$details = explode(",",$value);
					$statip[$details[1]]++;
					$statdate[$details[0]]++;
				$list .= "<li>".fixDate($details[0],true)." ".$details[1]."</li>";
					}
				}
			arsort($statip);
			$build .= "<h4>General Stats:</h4>\r";
			$build .= "Unique IP Addresses: ".count($statip)."<br><br>\r";
			$build .= "Top 5 IP Addresses: ";
			$build .= "<ol>";
			foreach($statip as $ip => $value){
				$build .= "<li>".$ip." (".$value." hits)</li>\r";
				$i++; if($i == 5) break;
				}
			$build .= "</ol>\r";
			$build .= "Top 5 Dates: ";
			$build .= "<ol>";
			foreach($statdate as $sday => $value){
				$build .= "<li>".fixDate($sday)." (".$value." hits)</li>\r";
				$i++; if($i == 5) break;
				}
			$build .= "</ol>\r";
			$build .= "<h4>Detail Stats:</h4>\r";
			$build .= "<ol>";
			$build .= $list;
			$build .= "</ol>\r";

			$build .= "<a class=\"extra-small expandable-link\" onclick=\"document.getElementById('".$boxname."').style.display='none'\">Click To Hide Stats</a>";
			$build .= "</ol></div>";
			}else $build = "There are no stats associated with this ad.";
		return($build);
		}

	function updateMenu(){
		$return = false;
		if($this->menuid == ""){
			$query_statement = "INSERT INTO `".DB_LUNCHSPECIALMENUS."` (`created`) VALUES ('".date("Ymd")."');";
			$query = mysql_query($query_statement);
			$this->menuid = mysql_insert_id();
			}
		$query_statement = "UPDATE `".DB_LUNCHSPECIALMENUS."` SET `date` = '".$this->date."' WHERE `id` = '".$this->menuid."';";
		$query = mysql_query($query_statement);
		
		if(is_array($this->adkeys)){
			foreach($this->adkeys as $arrayKey => $adId){
				$query_statement = "UPDATE `".DB_LUNCHSPECIALADS."` SET `ad` = '".addslashes($this->adimages[$arrayKey])."', `heading` = '".addslashes($this->adheading[$arrayKey])."', `special` = '".addslashes($this->adspecial[$arrayKey])."' WHERE `id` = '".$adId."';";
				$query = mysql_query($query_statement);
				$return = mysql_error();
				}
			}else{
			foreach($this->adimages as $key => $value){
				$query_statement = "INSERT INTO `".DB_LUNCHSPECIALADS."` (`ad`,`heading`,`special`,`menu`) VALUES ('".addslashes($this->adimages[$key])."', '".addslashes($this->adheading[$key])."', '".addslashes($this->adspecial[$key])."', '".addslashes($this->menuid)."');";
				$query = mysql_query($query_statement);
				$return = mysql_error();
				}	
			}
		return($return);
		}
	
	function listSpecials(){
		$query_statement = "SELECT * FROM `".DB_LUNCHSPECIALMENUS."` ORDER BY `date` ASC;";
		$query = mysql_query($query_statement);
		if(mysql_num_rows($query) > 0){
			while($rec = mysql_fetch_assoc($query)){
				$month = substr($rec["date"],4,2);
				$day   = substr($rec["date"],6,2);
				$year  = substr($rec["date"],0,4);
				$array[$year][$month][$day] = "<li><a href=\"lunch_special_view.php?menuid=".$rec["id"]."\">".date("l, F d, Y", mktime(0,0,0,$month,$day,$year))."</a></li>\r";
				}
			
			$build = "<ul class=\"listyear\">";
			foreach($array as $keyYear => $valueYear){
				$build .= "<li><a class=\"expandable-link\" onclick=\"document.getElementById('".$keyYear."box').style.display='block'\">".$keyYear."</a></li>\r";
				$build .= "<div class=\"expandable\" id=\"".$keyYear."box\">\r";
				$build .= "<ul class=\"listmonth\">";
				foreach($valueYear as $keyMonth => $valueMonth){
					$build .= "<li><a class=\"expandable-link\" onclick=\"document.getElementById('".$keyYear.$keyMonth."box').style.display='block'\">".date("F", mktime(0,0,0,$keyMonth,1,$keyYear))."</a></li>\r";
					$build .= "<div class=\"expandable\" id=\"".$keyYear.$keyMonth."box\">\r";
					$build .= "<ul class=\"listday\">\r";
					foreach($valueMonth as $keyDay => $link){
						$build .= $link;
						}
					$build .= "<li><a class=\"expandable-link extra-small\" onclick=\"document.getElementById('".$keyYear.$keyMonth."box').style.display='none'\">Hide ".date("F Y", mktime(0,0,0,$keyMonth,1,$keyYear))."</a></li>\r";
					$build .= "</ul>\r";
					$build .= "</div>\r";
					}
				$build .= "<li><a class=\"expandable-link extra-small\" onclick=\"document.getElementById('".$keyYear."box').style.display='none'\">Hide ".date("Y", mktime(0,0,0,1,1,$keyYear))."</a></li>\r";
				$build .= "</ul>\r";
				$build .= "</div>\r";
				}
			$build .= "</ul>\r";
			}else $build = "There are currently no available menus.";
		return($build);
		}
	
	
	function findLastDate(){
		$this->date = date("Ymd");
		$query_statement = "SELECT * FROM `".DB_LUNCHSPECIALMENUS."` WHERE `date` = '".$this->date."';";
		$query = mysql_query($query_statement);
		if(mysql_num_rows($query) != 1){
			$query_statement = "SELECT * FROM `".DB_LUNCHSPECIALMENUS."` WHERE `date` < '".date("Ymd")."';";
			$query = mysql_query($query_statement);
			while($rec = mysql_fetch_assoc($query)) $buildDate[$rec["date"]] = 1;
			for($i=0;$i<=1000;$i++){
				$jd_date  = gregoriantojd(substr($this->date,4,2), substr($this->date,6,2), substr($this->date,0,4))-$i;
				$exp      = explode("/", jdtogregorian($jd_date));
				$nextdate = date("Ymd", mktime(0,0,0,$exp[0],$exp[1],$exp[2]));
				if($buildDate[$nextdate] == 1){
					$nextAvail = $nextdate;
					break;
					}
				}
			$return = "That date is already taken.<br>The next available date is ".fixDate($nextAvail).".";
			}else $nextAvail = $this->date;
		return($nextAvail);
		}
	
	function randomAds($amount,$menu=false){
		
		if($menu == false) $query_statement = "SELECT * FROM `".DB_LUNCHSPECIALMENUS."` WHERE `date` = '".$this->findLastDate()."';";
		else $query_statement = "SELECT * FROM `".DB_LUNCHSPECIALMENUS."` WHERE `id` = '".$menu."';";
		$query = mysql_query($query_statement);
		$rec = mysql_fetch_assoc($query); 
		
		$query_statement = "UPDATE `".DB_LUNCHSPECIALMENUS."` SET `views` = (`views`+1) WHERE `id` = '".$rec["id"]."';";
		$query = mysql_query($query_statement);

		$query_statement = "SELECT * FROM `".DB_LUNCHSPECIALADS."` WHERE `menu` = '".$rec["id"]."';";
		$query = mysql_query($query_statement);
		$i=0;
		while($adrec = mysql_fetch_assoc($query)){
			$this->adkeys[$i]    = $adrec["id"];
			$this->adimages[$i]  = $adrec["ad"];
			$this->adheading[$i] = $adrec["heading"];
			$this->adspecial[$i] = $adrec["special"];
			$i++;
			}
		$array = array_rand($this->adkeys, $amount);
		return($array);
		}
	
	function updateAdStats($id,$action){
		$str = date("Ymd").",".$_SERVER["REMOTE_ADDR"].",".$action.";";
		$query_statement = "UPDATE `".DB_LUNCHSPECIALADS."` SET `stat` = CONCAT(`stat`,'".$str."') WHERE `id` = '".$id."';";
		$query = mysql_query($query_statement);
		}
	
	
	}



?>