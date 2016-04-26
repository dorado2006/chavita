<?php

require_once 'configBD.php';

class database {

    private $conexion;

    /* METODO PARA CONECTAR CON LA BASE DE DATOS */

    public function conectar() {
        if (!isset($this->conexion)) {

            $this->conexion = (mysql_connect(Config::$bd_hostname, Config::$bd_usuario, Config::$bd_clave)) or die(mysql_error());
            mysql_select_db(Config::$bd_nombre, $this->conexion) or die(mysql_error());
        }
        return $this->conexion;
    }

    public function retornadato($sql) {
        $r = mysql_query($sql, $this->conectar()) 
        or die("Error en consulta de retorno: " . mysql_error() . "<br> $sql <br>");
        if ($f = mysql_fetch_array($r)) {
            return $f[mysql_field_name($r, 0)];
        } else {
            return "NULO";
        }
    }

    public function consulta($sql) {
        $resultado = mysql_query($sql, $this->conectar());
        if (!$resultado) {
            echo 'MySQL Error: ' . mysql_error();
            echo "<br>" . $sql;
            $resultado=0;           
            exit;
        }
        return $resultado;
    }

    /* METODO PARA CONTAR EL NUMERO DE RESULTADOS
      INPUT: $result
      OUTPUT:  cantidad de registros encontrados
     */

    function numero_de_filas($result) {
        if (!is_resource($result))
            return false;
        return mysql_num_rows($result);
    }

    /* METODO PARA CREAR ARRAY DESDE UNA CONSULTA
      INPUT: $result
      OUTPUT: array con los resultados de una consulta
     */

    function fetch_assoc($result) {
        if (!is_resource($result))
            return false;
//			return mysql_fetch_assoc($result);
        return mysql_fetch_array($result);
    }

    /* METODO PARA CERRAR LA CONEXION A LA BASE DE DATOS */

    public function disconnect() {
        mysql_close();
    }

}

?>