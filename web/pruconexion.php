<HTML>
    <HEAD></HEAD>
    <BODY>
        <?php
#Test de prueba MYSQL de @CCESOPERU
# http://accesoperu.com
        require_once '../app/config.php';
#Los datos de acceso:

        $hostname = "localhost";
        $usuario = "root";
        $password = "";
        $basededatos = "negocio_cultural";
        $tabla = "personal";


#Conectando con MySQL
        $idconnect = mysql_connect(Config::$bd_hostname, Config::$bd_usuario, "$password");

        if ($idconnect == 0)
            echo "Lo sentimos, no se ha podido conectar con la MySQL";
        else {
            echo "Se logró conectar con MySQL";
            echo "<br>";


#Conectando con la base de datos
            $dbconnect = mysql_select_db("$basededatos", $idconnect);
            if ($dbconnect == 0)
                echo "Lo sentimos, no se ha podido conectar con la base datos: $basededatos<br>";
            else {
                echo "Se logró conectar con la base de datos: $basededatos<br>";
                echo "<br>";

#Probando una tabla
                $idresult = mysql_query("SELECT count(*) from $tabla;", $idconnect);
                if ($idresult == 0)
                    echo "Sentencia incorrecta llamado a tabla: $tabla.";
                else {
                    $nregistrostotal = mysql_result($idresult, 0, 0);
                    echo "Hay $nregistrostotal registros en la tabla: $tabla.";
                    mysql_free_result($idresult);
                }
            }
        }
        mysql_close($idconnect);
        ?>
    </BODY>
</HTML>