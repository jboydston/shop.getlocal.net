<?php

require "_admin/_globals.php";


$output = template_company_business_gallery($_GET[id], $_GET[path]);

include SITEHEADERFILE;

?>

<div class="content-detail">
	<?=$output?>    
	</div>

<?php include SITEFOOTERFILE;?>