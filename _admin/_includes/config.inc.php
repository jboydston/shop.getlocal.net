<?php


$home_page_cats = array(
	100 => array("name" => "Automotive",
							 "subs" => array(
												"7532" => "Auto Body",
												"7536" => "Auto Glass",
												"7539" => "Repair",
												"7514" => "Rental",
												"5511" => "Sales",
												"5013" => "Supplies",
												"7537" => "Transmission",
												"8009" => "Tires & Wheels",
												),
											),
	120 => array("name" => "Beauty & Fitness",
							 "subs" => array(
												"7991" => "Athletic Clubs", 
												"7231" => "Barber Shops, Hair Salons", 
												"8021" => "Dental", 
												"8093" => "Facilities",
												"8011" => "Medical Providers", 
												"5047" => "Medical Supplies",
												"8042" => "Optometry" 
												),
											),
	130 => array("name" => "Entertainment",
							 "subs" => array(
												"7999" => "Activities, Amusement Parks",
												"7929" => "Entertainers",
												"7011" => "Hotels & Motels",
												"7832" => "Theater/Film"
												),
											),
	140 => array("name" => "Food & Drink",
							 "subs" => array(
												"5813" => "Drinks", 
												"5411" => "Grocery", 
												"5812" => "Restaurants"
												),
											),
	150 => array("name" => "Health Care",
							 "subs" => array(
												"8041" => "Chiropractors", 
												"8011" => "Clinics", 
												"8021" => "Dentists", 
												"8049" => "Doctors", 
												"8042" => "Eye Doctors", 
												"5912" => "Pharmacy", 
												),
											),
	160 => array("name" => "Home & Garden",
							 "subs" => array(
												"5064" => "Appliances", 
												"7217" => "Carpet Cleaning", 
												"1731" => "Electrical", 
												"5191" => "Farm Supply", 
												"5712" => "Furniture", 
												"5039" => "Hauling", 
												"5075" => "Heat & Air", 
												"5211" => "Home Improvement", 
												"1799" => "Pool & Spa", 
												),
											),
	170 => array("name" => "Real Estate",
							 "subs" => array(
												"6531" => "Agents, Appraisals, Property Management",
												"6162" => "Mortgage & Refinance",
												"6541" => "Title Companies",
												),
											),
	180 => array("name" => "Retail",
							 "subs" => array(
												"5949" => "Art & Framing", 
												"5942" => "Bookstores", 
												"5621" => "Clothing", 
												"4899" => "Communications", 
												"5944" => "Jewelry Stores", 
												"5044" => "Office Supplies", 
												"0752" => "Pet Grooming", 
												"5661" => "Shoes/Accessories", 
												"5941" => "Sporting Goods" 
												),
											),
										);
	
	
$alpha_keys = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

$account_status = array(
	1 => "Active",
	9 => "Disabled"
	);
	
$giftcard_status = array(
	1 => "Available",
	2 => "Sold",
	3 => "Missing",
	9 => "Deleted"
	);
	
$show_number_of_businesses = 10;


$email_subjects = array(
	"gc_admin"    => "MP Gift Card Purchase",
	"gc_customer" => "MP Gift Card Confirmation",
	);



?>