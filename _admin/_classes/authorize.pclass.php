<?php

class handlePayment{
	
	public $id, $cc_name, $cc_number, $cc_exp, $cc_scode;
	public $fname, $lname, $address, $city, $state, $zip, $phone, $email, $cc_zip, $amount, $result, $trans_numb;
	public $ship_fname, $ship_lname, $ship_address, $ship_city, $ship_state, $ship_zip;
	
	function __construct(){
		}

	function preloadPayment($amount){
		$this->fname     = addslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["fname"]);
		$this->lname     = addslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["lname"]);
		$this->address   = addslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["address"]);
		$this->city      = addslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["city"]);
		$this->state     = addslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["state"]);
		$this->zip       = $_SESSION[SHOPPING_SESSION_ID]["field"]["zip"];
		$this->phone     = $_SESSION[SHOPPING_SESSION_ID]["field"]["areacode"].$_SESSION[SHOPPING_SESSION_ID]["field"]["citycode"].$_SESSION[SHOPPING_SESSION_ID]["field"]["numbcode"];
		$this->email     = addslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["email"]);
		$this->ship_fname     = addslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_fname"]);
		$this->ship_lname     = addslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_lname"]);
		$this->ship_address   = addslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_address"]);
		$this->ship_city      = addslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_city"]);
		$this->ship_state     = addslashes($_SESSION[SHOPPING_SESSION_ID]["field"]["ship_state"]);
		$this->ship_zip       = $_SESSION[SHOPPING_SESSION_ID]["field"]["ship_zip"];
		$this->cc_name   = $_SESSION[SHOPPING_SESSION_ID]["field"]["cc_name"];
		$this->cc_number = $_SESSION[SHOPPING_SESSION_ID]["field"]["cc_number"];
		$this->cc_exp    = $_SESSION[SHOPPING_SESSION_ID]["field"]["exp_month"].$_SESSION[SHOPPING_SESSION_ID]["field"]["exp_year"];
		$this->cc_scode  = $_SESSION[SHOPPING_SESSION_ID]["field"]["cc_scode"];
		$this->cc_zip    = $_SESSION[SHOPPING_SESSION_ID]["field"]["cc_zip"];
		$this->amount    = $amount;
		}
	
	function savePaymentRecord(){
		$query_statement = "INSERT INTO `".GC_INVOICES."` (`date`,`amount`,`status`,`fname`,`lname`,`address`,`city`,`state`,`zip`,`phone`,`email`,`ship_fname`,`ship_lname`,`ship_address`,`ship_city`,`ship_state`,`ship_zip`,`cc_name`,`cc_numb`,`cc_exp`,`cc_sec`,`cc_zip`,`ipaddress`) VALUES ('".date("Ymd")."','".$this->amount."','0','".$this->fname."','".$this->lname."','".$this->address."','".$this->city."','".$this->state."','".$this->zip."','".$this->phone."','".$this->email."','".$this->ship_fname."','".$this->ship_lname."','".$this->ship_address."','".$this->ship_city."','".$this->ship_state."','".$this->ship_zip."','".$this->cc_name."', AES_ENCRYPT('".$this->cc_number."', '".MYSQL_CRYPT_KEY."'),AES_ENCRYPT('".$this->cc_exp."', '".MYSQL_CRYPT_KEY."'),AES_ENCRYPT('".$this->cc_scode."', '".MYSQL_CRYPT_KEY."'),'".$this->cc_zip."','".$_SERVER["REMOTE_ADDR"]."');";
		$query = mysql_query($query_statement);
		$this->id = mysql_insert_id();
		if(mysql_error() == null) return(true);
		else return(false);
		}
		
	
	function updateInvoice($field, $value){
		$query_statement = "UPDATE `".GC_INVOICES."` SET `".$field."` = '".$value."' WHERE `id` = '".$this->id."';";
		$query = mysql_query($query_statement);
		}
		
	function processInvoice(){
		$capturetype = "AUTH_CAPTURE";
		
		$test_mode = "FALSE";
		if($this->cc_number == PAYMENT_TESTCARD || PAYMENT_MODE == "test") $test_mode = "TRUE";

		$authnet_values = array(
			"x_version"		   => PAYMENT_VERSION,
			"x_login"		     => PAYMENT_USER,
			"x_tran_key"	   => PAYMENT_KEY,
			"x_test_request" => $test_mode,
			"x_delim_char"	 => "|",
			"x_delim_data"	 => "TRUE",
			"x_type"		     => $capturetype,
			"x_invoice_num"  => $this->id,
			"x_amount"		   => $this->amount,
			"x_first_name"	 => $this->cc_fname,
			"x_last_name"	   => $this->cc_lname,
			"x_description"	 => $this->authnet_values["prod_title"],
			"x_card_num"	   => $this->cc_number,
			"x_exp_date"	   => $this->cc_exp,
			"x_card_code"	   => $this->cc_scode,
			"x_zip"			     => $this->cc_zip,
			"x_country"		   => "USA");
		$fields = "";
		foreach($authnet_values as $key => $value ) $fields .= "$key=".urlencode( $value )."&";
		$ch = curl_init("https://secure.authorize.net/gateway/transact.dll");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& "));
		$resp = curl_exec($ch);
		curl_close ($ch);			
		$this->updateInvoice("result", $resp);
		$info = $this->explodeResult($resp);
		$this->updateInvoice("status", $info["result"]);
		$this->updateInvoice("trans_numb", $info["transaction_number"]);
		return($info);
		}
	
	function explodeResult($string){
		$array = explode("|", $string);
		$build["result"] = "2";
		if($array[0] == "1" && $array[1] == "1" && $array[2] == "1"){
			$build["result"] = "1";
			$build["transaction_number"] = $array[4];
			}
		$build["message"] = $build["result"]." ".$array[3]." Your transaction number is ".$build["transaction_number"].".  Please save or print this page for your records.  Do not use your back button as it may result in your card being charged twice.";
		return($build);		
		}
	
	
	}

?>
