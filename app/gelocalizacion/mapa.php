
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mapa</title>
<style type="text/css">
	.data{ 
		font:normal 12px Arial, Helvetica, sans-serif;
		color:#555; 
		width:160px
	}
	
	.data p{ 
		margin-top:4px; 
		margin-bottom:0px
	}
	
	.vista_mapa{
		border:1px  solid #979797;
		padding:8px 8px 8px 8px; 
		float:left; 
		margin:2px 0 0 8px
	}	
</style>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAnnV32Xc4MtQYyTUhtfwkchSmgqw7Xz_HQReRzOtxMk5xOFYUChS5CMTBS-bBdKE6nZEFZ6c6sEw9nQ" type="text/javascript"></script>

<script type="text/javascript">
	
    function initialize() {
		var html = '<div class="data"><p><?php echo $_GET['zom'] ?></p></div>';
	
      if(GBrowserIsCompatible())
	  {
        var map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(<?php echo $_GET['coor'] ?>), <?php echo $_GET['zom'] ?>);
        map.setUIToDefault();
        
        var blueIcon = new GIcon(G_DEFAULT_ICON);
        blueIcon.image = "http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png";
		markerOptions = { icon:blueIcon };

          var latlng = new GLatLng(<?php echo  $_GET['coor'] ?>);
		   
		   function createMarker(point,nombre,continente,pais) {
		
			var marker = new GMarker(latlng, markerOptions);
			marker.openInfoWindowHtml(html);
			return marker;
		} 
		
		var marker = createMarker ("","","","");
		 map.addOverlay(marker);
      }
    }

    </script>
</head>
<body onload="initialize()" onunload="GUnload()" style="margin:0; padding:0">
    <div class="vista_mapa"><div id="map_canvas" style="width:400px; height:300px;"></div></div>
  </body>
</html>