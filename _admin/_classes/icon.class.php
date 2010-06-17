<?php

class handleIcons {
	public $rec;
	
	function __construct(){
		}
		
	function createIcon(){
		$query_statement = "INSERT INTO `".ICON_TABLE_NAME."` (`name`,`status`) VALUES ('".stripslashes($_POST["newiconname"])."','1');";
		$query = mysql_query($query_statement);
		$to_dir = PATHTOICONDIR."/";
		$mysql_id = mysql_insert_id();
		$file_name = $mysql_id.findExtension("newicon");
		$this->saveFile($_FILES["newicon"]["tmp_name"],$to_dir,$file_name);
		$this->updateData("file",$file_name,$mysql_id);
		}
	
	function changeIcon($key){
		$to_dir = PATHTOICONDIR."/";
		$file_name = $key.findExtension($key);
		$this->saveFile($_FILES[$key]["tmp_name"],$to_dir,$file_name);
		$this->updateData("file",$file_name,$key);
		}
	
	function updateData($field,$value,$id){
		$query_statement = "UPDATE `".ICON_TABLE_NAME."` SET `".addslashes($field)."` = '".addslashes($value)."' WHERE `id` = '".$id."';";
		$query = mysql_query($query_statement);
		return($build);
		}
	
	function pullIcons(){
		$query_statement = "SELECT * FROM `".ICON_TABLE_NAME."` WHERE `status` = '1' ORDER BY `name` ASC;";
		$query = mysql_query($query_statement);
		while($rec = mysql_fetch_assoc($query))
			$build .= "<div class=\"icon-manage\"><img src=\"".HTMLTOICONDIR."/".$rec["file"]."?nocache=".date(Ymdhis).rand(1,1000)."\" border=0>".$rec["name"].$this->createIconOptions($rec["id"])."</div>\r\n";
		return($build);
		}
	
	function createIconOptions($name){
		$build .= "<br style=\"display:block; clear: both;\"/>";
		$build .= "<a onclick=\"document.getElementById('update_".$name."').style.display='block'; document.getElementById('remove_".$name."').style.display='none'\" class=\"field-info expandable-link\">UPDATE</a> &nbsp;&nbsp;";
		$build .= "<a onclick=\"document.getElementById('remove_".$name."').style.display='block'; document.getElementById('update_".$name."').style.display='none'\" class=\"field-info expandable-link\">REMOVE</a> &nbsp;&nbsp;";

		$build .= "<div id=\"update_".$name."\" style=\"display:none;\"><input type=\"file\" name=\"".$name."\">";
		$build .= "<input type=\"submit\" value=\"Upload\" name=\"submit\"></div>";

		$build .= "<div id=\"remove_".$name."\" style=\"display:none;\">Are you sure you want to remove this icon? &nbsp;&nbsp;&nbsp;";
		$build .= "<a onclick=\"document.getElementById('remove_".$name."').style.display='none'\" class=\"field-info expandable-link\">NO</a> &nbsp;&nbsp;";
		$build .= "<a href=\"".$_SERVER["PHP_SELF"]."?id=".$name."&remove=yes\" class=\"field-info expandable-link\">YES</a></div>";
		return($build);
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

	function updateStatus($status,$id){
		mysql_query("UPDATE `".ICON_TABLE_NAME."` SET `status` = '".$status."' WHERE `id` = '".$id."';");
		return;
		}
	
	
	}

?>