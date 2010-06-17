<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo PAGETITLEADMIN; ?></title>

<meta http-equiv="Content-Type" 	   content="text/html; charset=western">
<meta http-equiv="imagetoolbar" 	   content="no">
<meta http-equiv="content-language"    content="en-us">
<meta http-equiv="Content-Style-Type"  content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">

<meta name="copyright" content="Copyright (c) 2007-<?=date('Y')?> PHPography">
<meta name="author"    content="Daniel Brown">
<meta name="rating" 	 content="general">


<meta http-equiv="Content-Type" content="text/html; charset=western">
<meta name="verify-v1"          content="mR6q6SWpbGdubKdvPObz5ZRyEii8ORCKvs+UD/oVOV0=" />


<script src="http://www.apple.com/library/quicktime/scripts/ac_quicktime.js" language="JavaScript" type="text/javascript"></script>
<script src="http://www.apple.com/library/quicktime/scripts/qtp_library.js" language="JavaScript" type="text/javascript"></script>
<script src="<?php echo JAVASCRIPTDIR; ?>/overlib.js" language="JavaScript" type="text/javascript"></script>
<script src="<?php echo JAVASCRIPTDIR; ?>/filterlist.js" language="JavaScript" type="text/javascript"></script>

<?php if($include_google_maps == "yes") include GOOGLEMAPS; ?>

<link rel="stylesheet" type="text/css" href="<?php echo STYLEDIR; ?>/admin.main.css">
<link rel="stylesheet" type="text/css" href="<?php echo STYLEDIR; ?>/admin.forms.css">
	
</head>
<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1;"></div>
<div id="header">
		<div id="logo"><a href="home.php"><img src="<?php echo IMAGEDIR; ?>/logo.jpg" border="0"></a></div>
		<div id="toolbox" class="ltgreen">Global Tool Box:
			<a href="<?php echo $_SERVER["PHP_SELF"]."?printme=t"; foreach($_GET as $key => $value) echo "&".$key."=".$value; ?>" target="_blank" class="green">Print This Page</a>
			<br/>
			<br/>
			<?php echo returnToSearch(); ?>
			</div>
	</div>
<div id="page">
	<div id="menu-column">
		<a href="home.php">Home</a><br/>
		<a href="update_account.php">Update Account</a><br/>
		<a href="acknowledgements.php">Acknowledgements</a><br/>
		<a href="<?=$PHP_SELF?>?logout=true">Log Out</a><br/>

		<h3 class="white"><b>Search Tools</b></h3>
		<a href="search.php">Search</a><br/>
		<a href="search_street.php">Search Street</a><br/>

		<h3 class="white"><b>Lunch Special</b></h3>
		<a href="lunch_special_manage.php">New Lunch Special</a><br/>
		<a href="lunch_special_viewall.php">View Lunch Specials</a><br/>

		<h3 class="white"><b>Admin Tools</b></h3>
		<a href="user_view_all.php">Manage Users</a><br/>
		<a href="company_add.php">Add Business</a><br/>
		<a href="icon_manage.php">Manage Icons</a><br/>
		<a href="general_categories.php">Manage General Categories</a><br/>
		<a href="templates_edit.php">Edit Report & Mail Templates</a><br/>
		<a href="rebuild_ads.php">Rebuild Ad Database</a><br/>

		<h3 class="white"><b>Saved Searches</b></h3>
		<a href="search.php?search=Field Search:sponsor&submit=Submit">Sponsors</a><br/>
		<a href="search.php?search=Field Search:web&submit=Submit">No Web Sites</a><br/>
		<a href="search.php?search=Field Search:agent&submit=Submit">Agent Submitted</a><br/>
		<a href="search.php?search=Field Search:bold&submit=Submit">Bold</a><br/>
		<a href="search.php?search=Field Search:highlight&submit=Submit">Highlight</a><br/>
		<a href="search.php?search=Field Search:icons&submit=Submit">Icons</a><br/>

		<h3 class="white"><b>Reports</b></h3>



		</div>
	
	<div id="content">







		