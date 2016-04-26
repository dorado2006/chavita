<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>::UBICACION GEOGRAFICA DEL CLIENTE::</title>

        <link rel="stylesheet" type="text/css" href="thickbox.css"/>

        <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAnnV32Xc4MtQYyTUhtfwkchSmgqw7Xz_HQReRzOtxMk5xOFYUChS5CMTBS-bBdKE6nZEFZ6c6sEw9nQ" type="text/javascript"></script>
        <script language="javascript" type="text/javascript" src="jquery.js"></script>
        <script language="javascript" type="text/javascript" src="thickbox.js"></script>

        <script type="text/javascript">
            // Iniciamos jQuery

            $(document).ready(function() {


                $("#direccion").keyup(function() {
                    $("#form_mapa").submit();
                });

                //mostramos las direcciones por defecto
                $("#load").load("procesa.php?action=listUbicaciones&idcliente=<?php echo $_REQUEST['idcliente'] ?>");

                $(".guardar_ubicacion").click(function() {
                 var confi=confirm("DESEA GUARDAR LA NUEVA UBICACION");
                 if(confi==true){
                           var condi = $(this).attr('id');
                    $.post("procesa.php?action=addUbicacion&condi=" + condi,
                            {
                                idcliente: $("#dnip").val(),
                                coor: $("#coordenadas").val(),
                                zoom: $("#zoom").val()

                            }, function(data) {
                        alert("La Ubicacion se creo con exito ");
                        $("#direccion").val('');
                        $("#load").load("procesa.php?action=listUbicaciones&idcliente=<?php echo $_REQUEST['idcliente'] ?>");
                    }
                    );
                 }
                 else{exit;}
  
                });

            });


            var map = null;
            var geocoder = null;

            function load() {
                if (GBrowserIsCompatible()) {
                    map = new GMap2(document.getElementById("map"));

                    map.setCenter(new GLatLng(-6.485419, -76.363821), 13);
                    map.addControl(new GSmallMapControl());
                    map.addControl(new GMapTypeControl());

                    geocoder = new GClientGeocoder();
                    // point = map.getCenter();
                    GEvent.addListener(map, "click", function(marker, point) {
                        if (marker) {
                            null;
                        } else {
                            map.clearOverlays();
                            var marcador = new GMarker(point);
                            map.addOverlay(marcador);
                            document.form_mapa.coordenadas.value = point.lat() + "," + point.lng();

                            document.form_mapa.zoom.value = map.getZoom();
                        }
                    }
                    );

                }
            }

            function showAddress(address, zoom) {
                if (geocoder) {
                    geocoder.getLatLng(address,
                            function(point) {
                                if (!point) {
                                    //alert(address + " not found");
                                } else {
                                    map.setCenter(point, zoom);
                                    var marker = new GMarker(point);
                                    map.addOverlay(marker);
                                    document.form_mapa.zoom.value = map.getZoom();
                                    document.form_mapa.coordenadas.value = point.y + "," + point.x;
                                }
                            }
                    );
                }
            }


            function ver_mapa(coor, zom) {
                // mostramos el mapa en el thickbox
                tb_show("", "mapa.php?width=404&height=320&coor=" + coor + "&zom=" + zom + "&TB_iframe=true", "");
            }

        </script>
        <style type="text/css">
            body{
                font:normal 12px Arial, Helvetica, sans-serif;
                color:#666
            }
            h2{
                margin:10px 0;
                text-align:center
            }
            #new_direccion{
                width:700px;
                margin:20px auto;
                border:2px dashed #999;
                padding:10px 30px 30px 30px;
                overflow:hidden;
                background:#FCFCFC
            }
            #new_direccion .bg_mapa{
                border:1px solid #CCC;
                padding:2px;
                float:left
            }
            #new_direccion .new{
                overflow:hidden;
                padding:15px 0
            }
            #new_direccion .item_dir{
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                border-radius: 3px;
                background:#EFEFEF;
                margin-top:6px;
                padding:3px;
            }
            #new_direccion .item_dir a{
                color:#39F;
                margin-left:10px
            }
        </style>
    </head>


    <body onLoad="load();"  onunload="GUnload();">
        <div id="new_direccion">
            <form name="form_mapa" id="form_mapa" action="#" method="post" onsubmit="showAddress('Peru ' + this.direccion.value, this.zoom.value = parseFloat(this.zoom.value));
                    return false">
                <div class="row">
                    <label>Digitar Ubicacion:</label>
                    <input type="text" name="direccion" id="direccion" class="text" value="" size="30" />
                    <input type="button" name="enviar" class="guardar_ubicacion" id="1" value="DOMICILIO" style=" background-color: #7FCB7D"  />
                    <input type="button" name="enviar"  class="guardar_ubicacion" id="2" value="TRABAJO" style=" background-color: #ED6B6B" />
                   

                </div>
                <input type="hidden" name="zoom" size="1"id="zoom" value="15" />
                <input type="hidden" name="coordenadas" id="coordenadas" value="" />
                <input type="hidden" name="dnip" id="dnip" value="<?php echo $_REQUEST['idcliente'] ?>" />



            </form>
            <br clear="all" />
            <div class="bg_mapa">
                <div id="map" style="width: 700px; height: 400px"></div>
            </div>
            <h2>Mis Ubicaciones</h2>
            <div id="load">
                <!-- cargar ubicaciones -->
            </div>
        </div>

    </body>
</html>