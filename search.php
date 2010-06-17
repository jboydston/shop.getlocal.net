<?php

require "_admin/_globals.php";
require CLASS_MP_BUSINESS;
require CLASS_ADS;

$biz = new handleBusiness;
$ads = new handleAds;

$page = 1;
if($_GET["page"] != "") $page = $_GET["page"];

$list_biz = $biz->searchBusinesses($_GET["search"],$_GET["city"],$_GET["alpha"],$page);
	
$map_pointer = $list_biz["cords"];

$list_cats = $biz->listCats($_GET["search"], 1);

?>

<?php getHeader("public","yes"); ?>

<div class="content-full">
	<div id="link-column-container" class="white">
		<div id="link-column">
			<?php
			if($list_cats["counter"] != "0") echo $list_cats["display"];
			if($list_biz["cities"] != "") echo $list_biz["cities"];
			?>
			</div>
		</div>
	<div id="detail-column-1">
		<?php

		if($list_biz["biz_list"] != ""){
			echo "<p class=\"small blue\">View listings starting with:<br/><br/>".$list_biz["letter"];		
			echo "<p class=\"small blue\">";
			if($_GET["page"] > 1) echo "<a href=\"".$_SERVER["PHP_SELF"]."?search=".$_GET["search"]."&alpha=".$_GET["alpha"]."&city=".$_GET["city"]."&p=".$_GET["p"]."&c=".$_GET["c"]."&page=".($page -1)."\" class=\"blue\">Previous Page</a> &nbsp;&nbsp;&nbsp;";	
			else echo "<span class=\"ltblue\">Previous Page</span> &nbsp;&nbsp;&nbsp;";	
			echo "<a href=\"".$_SERVER["PHP_SELF"]."?search=".$_GET["search"]."&alpha=".$_GET["alpha"]."&city=".$_GET["city"]."&p=".$_GET["p"]."&c=".$_GET["c"]."&page=".($page +1)."\" class=\"blue\">Next Page</a>";	
			echo "</p>";		
			echo "<p>".$list_biz["biz_list"]."</p>";
			$city_display = true;
		  }else{
			echo "No search results.";
			if(isset($_GET["page"])) echo "<br/><br/><a href=\"".$_SERVER["PHP_SELF"]."?search=".$_GET["search"]."&alpha=".$_GET["alpha"]."&city=".$_GET["city"]."&p=".$_GET["p"]."&c=".$_GET["c"]."&page=".($page -1)."\" class=\"blue\">Return to Previous Page</a>";	
			if(isset($_GET["alpha"])) echo "<br/><br/><a href=\"".$_SERVER["PHP_SELF"]."?search=".$_GET["search"]."&alpha=&city=".$_GET["city"]."&p=".$_GET["p"]."&c=".$_GET["c"]."&page=".$_GET["page"]."\" class=\"blue\">View All</a>";	
			$city_display = false;
			}
		?>
		</div>
	
	<div id="detail-column-2" class="white">
		<?php echo $ads->buildAd(300); ?><br/><br/>
		<div id="map"></div>
		</div>
	</div>

<?php getFooter("public"); ?>