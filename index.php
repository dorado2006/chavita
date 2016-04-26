<html>
    <head>
        <title>NC</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="web/css/estilo111.css" />
        <link href="web/css/bootstrap.css" rel="stylesheet">
        <script type="text/javascript" src="web/js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="jquery-1.8.3.min.js"></script>
        <script>
            $(function() {

                $("#inicio_sesion").click(function() {

                    $("#formulario").css("display", ""); //hace aparacer el formulario y con disply _:none desaparece

                });

            });

        </script>

    </head>
    <body>
        <div id="cabecera" style=" background-image: url(web/img/panel.JPG) " >

            <div id="logonc" align="center" style="width: 20%;display: inline-block;">

                <img   src="web/img/logo.png" width="220" height="80" alt="logo"/> 
            </div>
            <div id="letra"align="center" style="width: 60%;display: inline-block;">
                <img   src="web/img/nombre_empresa.png" style="height: 70px;"  />
            </div>
            <div style="width: 10%;display: inline-block;">

                <a  id="inicio_sesion" class="btn btn-success"  name="1" onClick="Alternar(formulario)">INICIAR SESIÓN</a>

            </div>
        </div>

        <div id="menu" style="background-image: url(web/img/menu2.png) ;" >

            Fecha:[....]
        </div><br>

        <div id="contenido" align="center">
            
            <div id="formulario" style="display:none" > 
                <form name="inic" action="lib/validate_librarian.php" method="post">


                    <table border="0"  style="border:1px solid black;border-radius: 10px;border-collapse: initial;border-spacing:3px;">
                        <thead style="background-color: #037345;">
                            <tr>
                                <th colspan="2" style="color: #ffffff;">Bienvenidos al Sistema </th>                        

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>Usuario</b></td>
                                <td><input type="text" name="usuario" value="" title="Ingrese su Usuario" required /></td>

                            </tr>
                            <tr>
                                <td><b>Clave</b></td>
                                <td><input type="password" name="clave" value="" title="Ingrese su Clave" required /></td>

                            </tr>
                            <tr>
                                <td colspan="2" align="center">

                                    <input type="submit" class="btn btn-primary " value=" Iniciar&nbsp;" name="logeo" />
                                    <input type="reset"  class="btn btn-primary" value="Cancelar" name="cancelar" />


                            </tr>
                            <tr>
                                <td colspan="2"></td>


                            </tr>

                        </tbody>
                    </table>
                </form> 
            </div>

        </div>

        <div id="pie">
            <hr/>
            <div align="center">WWW.NegocioCultural.com.pe  Al Servicio del PERÚ</div>
        </div>
    </body>
</html>
