<?php

class handleShoppingCart {
	public $total;
	
	function __construct(){
		
		}
	
	function clearCart(){
		$_SESSION[SHOPPING_SESSION_ID] = null;
		return;
		}
	
	function clearItem(){
		$_SESSION[SHOPPING_SESSION_ID][$_GET["remove"]] = null;
		return;
		}
	
	function showCart(){
		$cart = "<ul id=\"shopping-cart\">";
		foreach($_SESSION[SHOPPING_SESSION_ID] as $id => $value){
			if($value == "1"){	
				$query_statement = "SELECT * FROM `".MP_TABLE_NAME."`, `".GC_TABLE_NAME."`, `".GC_CARDS_NAME."` WHERE `".MP_TABLE_NAME."`.`record_id` = `".GC_TABLE_NAME."`.`marketplace_id` AND `".GC_TABLE_NAME."`.`id` = `".GC_CARDS_NAME."`.`giftcard_id` AND `".GC_CARDS_NAME."`.`id` = '".$id."';";
				$query = mysql_query($query_statement);
				$rec = mysql_fetch_assoc($query);
				$cart .= "<li>[<a href=\"".$_SERVER["PHP_SELF"]."?remove=".$id."\" class=\"white\">X</a>] ".htmlspecialchars(stripslashes($rec["business_name"]))."<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$".number_format($rec["value"],2)." for \$".number_format($rec["price"],2)."</li>";
				$total += $rec["price"];
				}
			}
		$cart .= "</ul>";
		$build  = "<div style=\"margin-top: 10px;border-bottom:1px dotted #fff;padding-bottom: 5px;\">Total: \$".number_format($total,2)."</div>";
		$build .= $cart;
		$build .= "<form action=\"checkout.php\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Check Out\"> &nbsp;&nbsp;";
		$build .= "<a href=\"".$_SERVER["PHP_SELF"]."?empty=t\" class=\"white extra-small\">Empty Cart</a></form>";
		return($build);
		}
	
	function showCartCheckOut(){
		foreach($_SESSION[SHOPPING_SESSION_ID] as $id => $value){
			if($value == "1"){	
				$query_statement = "SELECT * FROM `".MP_TABLE_NAME."`, `".GC_TABLE_NAME."`, `".GC_CARDS_NAME."` WHERE `".MP_TABLE_NAME."`.`record_id` = `".GC_TABLE_NAME."`.`marketplace_id` AND `".GC_TABLE_NAME."`.`id` = `".GC_CARDS_NAME."`.`giftcard_id` AND `".GC_CARDS_NAME."`.`id` = '".$id."';";
				$query = mysql_query($query_statement);
				$rec = mysql_fetch_assoc($query);
				$cart .= "<span class=\"small\">".htmlspecialchars(stripslashes($rec["business_name"]))." gift card valued at \$".number_format($rec["value"],2)." for \$".number_format($rec["price"],2)."</span><br/>";
				$total += $rec["price"];
				}
			}
		$cart .= "</ul>";
		$build  = "<div style=\"margin-top: 10px;border-bottom:1px dotted #fff;padding-bottom: 5px;\">Charge Total: \$".number_format($total,2)."</div>";
		$build .= $cart;
		$this->total = $total;
		return($build);
		}
	
	function getTotal(){
		if(is_array($_SESSION[SHOPPING_SESSION_ID])){
			foreach($_SESSION[SHOPPING_SESSION_ID] as $id => $value){
				if($value == "1"){	
					$query_statement = "SELECT * FROM `".MP_TABLE_NAME."`, `".GC_TABLE_NAME."`, `".GC_CARDS_NAME."` WHERE `".MP_TABLE_NAME."`.`record_id` = `".GC_TABLE_NAME."`.`marketplace_id` AND `".GC_TABLE_NAME."`.`id` = `".GC_CARDS_NAME."`.`giftcard_id` AND `".GC_CARDS_NAME."`.`id` = '".$id."';";
					$query = mysql_query($query_statement);
					$rec = mysql_fetch_assoc($query);
					$total += $rec["price"];
					}
				}
			}
		return($total);
		}
	
	function closeCards($inv_number){
		if(is_array($_SESSION[SHOPPING_SESSION_ID])){
			foreach($_SESSION[SHOPPING_SESSION_ID] as $id => $value){
				if($value == "1"){	
					$query_statement = "UPDATE `".GC_CARDS_NAME."` SET `status` = '2', `inv_numb` = '".$inv_number."', `date_sold` = '".date("Ymd")."' WHERE `".GC_CARDS_NAME."`.`id` = '".$id."';";
					$query = mysql_query($query_statement);
					}
				}
			}
		return;
		}
	
	function addToCart(){
		$query_statement = "SELECT * FROM `".GC_CARDS_NAME."` WHERE `giftcard_id` = '".$_GET["add"]."' AND `status` = '1' ORDER BY RAND();";
		$query = mysql_query($query_statement);
		$quantity = mysql_num_rows($query);
		$message = "2 We are sorry, but that gift card has just sold out, is no longer available, or you have all cards available in your shopping cart.  <a href=\"".$_SERVER["PHP_SELF"]."?empty=t\" class=\"blue\">Click Here</a> to empty your shopping cart.";
		if($quantity > "0"){
			while($rec = mysql_fetch_assoc($query)){
				if($_SESSION[SHOPPING_SESSION_ID][$rec["id"]] == ""){
					$_SESSION[SHOPPING_SESSION_ID][$rec["id"]] = true;
					$message = "1 Gift Card has been added to your shopping cart.";
					break;
					}
				}
			}
		return($message);
		}
		
		



		
	}

?>