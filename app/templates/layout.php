
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>NC</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../web/css/estilo.css" />
        <link href="../web/css/bootstrap.min.css" rel="stylesheet">
        <link href="../web/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="../web/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="../web/css/vistatabla.css" rel="stylesheet">
        <link href="../web/css/jquery.ui.timepicker.css" rel="stylesheet">
       <link rel="stylesheet" href="../web/css/alerty/alertify.core.css" />
        <link rel="stylesheet" href="../web/css/alerty/alertify.default.css" />
         
<!--        <link href="../web/css/bootstrap-combobox.css" rel="stylesheet">-->
        
        <!--para el menu -->              
        <script src="../web/js/jquery-1.10.2.min.js"></script>
        <script src="../web/js/modernizr.js"></script>

        <script type="text/javascript" src="../web/js/jquery-migrate-1.2.1"></script>
        <script type="text/javascript" src="../web/js/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="../web/js/jquery.ui.timepicker.js"></script>


        <script type="text/javascript" src="../web/js/upload.js"></script>

        <script src="../web/js/bootstrap.js"></script>
        <!--fin el menu -->
        <script src="../web/js/funciones.js"></script>
        <script src="../web/js/jquery_validate.js"></script>
        <!--calendario-->    
        <link rel="stylesheet" type="text/css" href="../web/css/jquery-ui-1.10.4.custom.css" />
        <script src="../web/js/jquery-ui-1.10.4.custom.min.js"></script>
         <script src="../web/js/jquery.PrintArea.js"></script>
         <script src="../web/js/alertify.js"></script>
<!--          <script src="../web/js/bootstrap-combobox.js"></script>-->


        <!--fin calendario-->



    </head>
    <body  style="background-image: url(../web/img/cuerpo.jpg); ">
<!--        <div id="cabecera" class="row" style=" background-image: url(../web/img/panel.JPG);height: 70px; ">
            <div class="col-sm-2" align="center">
                <img   src="../web/img/logo.png" width="220" height="50" alt="logo"/> 
            </div>
            <div id="letra" class="col-sm-8" align="center" >
                <img  src="../web/img/nombre_empresa.png"  />
            </div>
            <div class="col-sm-2" style="height: 42px;margin-top: 12px; ">
                <a href="logout.php" class="btn btn-danger glyphicon glyphicon-hand-left" ><strong>&nbsp;SALIR</strong></a>
            </div>
        </div>-->

        <!--- comienso dde menu -->
        <div id="menu" style="background-image: url(../web/img/menu2.png) ; background-repeat: repeat-x;">
            <div id="menu_iz"></div> 
            <div id="menu_der">
                <div style="display: inline-block;font-weight: bold;">
                    <?php echo utf8_encode("Nombre: " . $_SESSION['nombre']); ?><br>
                    <font color="brown"> <?php echo "Perfil: " . $_SESSION['perfil']; ?></font>
                </div>
                <div style="display: inline-block;">
                    <script type="text/javascript">
                        function startTime() {
                            today = new Date();
                            h = today.getHours();
                            m = today.getMinutes();
                            s = today.getSeconds();
                            m = checkTime(m);
                            s = checkTime(s);
                            document.getElementById('reloj11').innerHTML = h + ":" + m + ":" + s;
                            t = setTimeout('startTime()', 500);
                        }
                        function checkTime(i)
                        {
                            if (i < 10) {
                                i = "0" + i;
                            }
                            return i;
                        }
                        window.onload = function () {
                            startTime();
                        }
                    </script>


<!--                    <div style="margin-left: 35px;">

                        <script type="text/javascript">
                            //<![CDATA[
                            var date = new Date();
                            var d = date.getDate();
                            var day = (d < 10) ? '0' + d : d;
                            var m = date.getMonth() + 1;
                            var month = (m < 10) ? '0' + m : m;
                            var yy = date.getYear();
                            var year = (yy < 1000) ? yy + 1900 : yy;
                            document.write(year + "-" + month + "-" + day);
                            var fecha = year + "-" + month + "-" + day;
                            //]]>
                        </script>
                        <div style="font-size:15px;" id="reloj"></div>
                    </div>-->

                </div>
            </div>
            <div id="reductor" style="display: inline-block;width: 1%;">
<!--                <a class="btn btn-info glyphicon glyphicon-sort" style="margin-top: 12px;"></a>-->
                <a href="logout.php" class="btn btn-danger glyphicon glyphicon-hand-left" ><strong></strong></a>
            </div>
        </div>

    </div><!-- fin del menu -->

    <div id="contenido"><br>

        <div id="contmedio">
            <?php echo $content; ?>
        </div>


    </div>

    <div id="pie" style="margin-top: 170px">
        <hr style="border-bottom: 1px solid #5DE86A;">
<!--        <div align="center">Copyrih-System-Hard</div>-->
    </div>
</body>
</html>