<?php

class handleCategories {
	public $rec;
	
	function __construct(){
		
		}
				
	function getCategories(){
		$query_statement = "SELECT * FROM `".GENERAL_CATEGORIES."` WHERE `id` != '1' ORDER BY `name` ASC;";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query)) $build .= $rec["name"]."\r";
		return($build);
		}
	
	function saveCategories($cats){
		if(is_array($cats)){
			$query_statement = "SELECT * FROM `".GENERAL_CATEGORIES."`;";
			$query = mysql_query($query_statement);
			while($rec = mysql_fetch_assoc($query)){
				if(in_array($rec["name"], $cats)) $build[$rec["id"]] = $rec["name"];
				}
			foreach($cats as $key => $value){
				if(@!in_array($value, $build)) {
					if(trim($value) != "") $build[] = $value;
					}
				}
			mysql_query("DELETE FROM `".GENERAL_CATEGORIES."` WHERE id != '1';");
			mysql_query("INSERT INTO `".GENERAL_CATEGORIES."` (`id`,`name`) VALUES ('1','Other');");
			if(is_array($build)){
				foreach($build as $key => $value){
					$query_statement = "INSERT INTO `".GENERAL_CATEGORIES."` (`id`,`name`) VALUES ('".$key."','".$value."');";
					$query = mysql_query($query_statement);
					}
				}
			}
		return;
		}
		
		
	}

?>