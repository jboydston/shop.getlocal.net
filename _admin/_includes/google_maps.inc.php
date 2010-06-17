<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo GOOGLEMAPKEY; ?>" type="text/javascript"></script>

<script type="text/javascript">
//<![CDATA[	
function GetCoordinates(){
  document.getElementsByName("latitude")[0].value = "";
  document.getElementsByName("longitude")[0].value = "";
  var geocoder = new GClientGeocoder();
  geocoder.getLatLng( document.getElementsByName("fields[full_address]")[0].value + " " +
      document.getElementsByName("fields[city_name]")[0].value + " " +
      document.getElementsByName("fields[state_code]")[0].value + " " +
      document.getElementsByName("fields[zip]")[0].value ,
      OnCoordinatesRecieved );
	}

function OnCoordinatesRecieved(coords){
  if(coords != null){
    document.getElementsByName("latitude")[0].value = coords.lat();
    document.getElementsByName("longitude")[0].value = coords.lng();
  	}else{
    document.getElementsByName("latitude")[0].value = "";
    document.getElementsByName("longitude")[0].value = "";
  	}
	}

<?php
if(is_array($map_pointer)){
	$body_vars = " onload=\"load()\" onunload=\"GUnload()\"";
	foreach($map_pointer as $key => $value) $add_pointers .= "  var point = new GLatLng(".$value["latitude"].", ".$value["longitude"].");\r\n  map.addOverlay(new GMarker(point));\r\n";
	}
?>

function load(){
  if (GBrowserIsCompatible()){
		var map = new GMap2(document.getElementById("map"));
		map.setCenter(new GLatLng("<?php echo $value["latitude"];?>", "<?php echo $value["longitude"];?>"),8);
		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());
		<?php echo $add_pointers;?>
  	}
	}	
//]]>
</script>