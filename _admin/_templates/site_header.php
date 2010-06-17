<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if($page_title == "") echo PAGETITLE; else echo $page_title; ?></title>

<meta http-equiv="Content-Type" 	     content="text/html; charset=western" />
<meta http-equiv="Content-Language"    content="en-us" />
<meta http-equiv="Content-Style-Type"  content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="imagetoolbar" 	     content="no" />

<meta name="copyright" content="Copyright (c) 2009-<?=date('Y')?> Daniel Brown, INC." />
<meta name="author" 	 content="Daniel Brown" />
<meta name="rating" 	 content="general" />
<?php if(GOOGLEVERIFYKEY != "") echo "<meta name=\"verify-v1\" content=\"".GOOGLEVERIFYKEY."\" />"; ?>

<meta name="keywords"    content="<?php if($page_keywords == "") echo PAGE_KEYWORDS; else echo $page_keywords; ?>" />
<meta name="description" content="<?php if($page_description == "") echo PAGE_DESCRIPTION; /* else echo $page_description; */ ?>" />

<link rel="stylesheet" type="text/css" href="<?php echo STYLEDIR; ?>/header.css" />
<link rel="stylesheet" type="text/css" href="<?php echo STYLEDIR; ?>/side_links.css" />
<link rel="stylesheet" type="text/css" href="<?php echo STYLEDIR; ?>/content.css" />

<script type="text/javascript" src="java/fixed.js"></script>

<?php if($include_google_maps  == "yes") include GOOGLEMAPS;  ?>

</head>
<body <?php echo $body_vars; ?>>
<a name="top"></a>
<div id="cheat-page">
<div id="page">
	<div id="header">
		<div id="logo"><a href="index.php"><img src="<?php echo IMAGEDIR; ?>/logo.jpg" border="0"></a></div>
		<div id="featured-box"><!--  <a href="giftcards.php"><img src="<?php echo IMAGEDIR; ?>/giftcardad.jpg" border="0"></a> --></div>
		<div id="search-box" style="background-image: url('<?php echo IMAGEDIR; ?>/search_background.jpg');">
			<div id="search-box-text">
			<form action="search.php" method="get" style="margin: 0;">
				<span class="small">Everything Marketplace, It's Here.</span><br>
				<span class="small dark">
				<input type="text" name="search" id="search-input" value="business or keyword" onFocus="this.value=''">
				<input type="submit" value="Search" name="submit" id="search-submit"></span>
				</form>
				</div>
			</div>
	</div>
	<div id="header-link-bar">
		<?php
		$i=1;
		foreach($home_page_cats as $main => $values){
			$fix_margin_left = "";
			if($i == 1) $fix_margin_left = " margin-left: 0px;";
			$css_filler = "";
			if($_GET["p"] == $main) $css_filler = " background-color: #dbf9d8; color: #000;";
			$build_menu .= "<a href=\"index.php?p=".$main."\" style=\"".$fix_margin_left.$css_filler."\">".$values["name"]."</a>\r";
			$i++;
			}
		echo $build_menu;
		if($_SERVER["PHP_SELF"] == "/service_directory.php") $css_filler_sd = "background-color: #dbf9d8; color: #000;";
		?>
		<a href="service_directory.php" style="<?=$css_filler_sd?> margin-right: 0px;">Service Directory</a>
		</div>

