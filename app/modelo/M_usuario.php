
<?php

/*
  CLASE PARA LA GESTION DE LOS UNIVERSITARIOS
 */
require_once '../app/ConBD.php';

class M_usuario extends database {
    /* REALIZA UNA CONSULTA A LA BASE DE DATOS EN BUSCA DE  REGISTROS UNIVERSITARIOS DADOS COMO
      PARAMETROS LA "CARRERA" Y LA "CANTIDAD" DE REGISTROS A MOSTRAR
      INPUT:
      $carrera | nombre de la carrera a buscar
      $limit | cantidad de registros a mostrar
      OUTPUT:
      $data | Array con los registros obtenidos, si no existen datos, su valor es una cadena vacia
     */

    function insertar_usuario($_P) {
        $this->conectar();
        $query = $this->consulta("INSERT INTO `personal` (`primer_nombre`, `idperfil`, `idoficina`, `segundo_nombre`, `apellido_p`, `apellido_m`, `pasword`, `usuario`, `dnipersonal`) VALUES ('".$_P['pnombre']."', '1', '1', 'ad', 'dsg', 'dg', '123', 'asd', '4566')"); //inser into venta 
        $this->disconnect();
    }

    function selectpersonal() {
        //conexion a la base de datos

        $t = new database();


        $sql = "select * from personal";

        $result = $t->consulta($sql);

        $alimentos = array();
        while ($row = mysql_fetch_assoc($result)) {
            $alimentos[] = $row;
        }

        return $alimentos;
    }

    function get_personal() {

        $this->conectar();
        $query = $this->consulta("
  SELECT
personal.idpersonal,
personal.primer_nombre,
personal.segundo_nombre,
personal.apellido_p,
personal.apellido_m,
personal.idperfil,
personal.idoficina,
personal.usuario,
personal.pasword,
personal.estado,
perfil.descripcion,
personal.dnipersonal,
oficina.descripcion as ofici,
CONCAT_WS('-',personal.telf1,personal.telf2) as telefon
FROM
personal
INNER JOIN perfil ON perfil.idperfil = personal.idperfil
INNER JOIN oficina ON oficina.idoficina = personal.idoficina
ORDER BY primer_nombre ASC
        ");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return '';
        }
    }
    function get_personalcondi() {

        $this->conectar();
        $query = $this->consulta("
  SELECT *
FROM
personal
INNER JOIN perfil ON perfil.idperfil = personal.idperfil
INNER JOIN oficina ON oficina.idoficina = personal.idoficina
where personal.idpersonal='".$_REQUEST['idp'] ."'
ORDER BY primer_nombre ASC
        ");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return '';
        }
    }
     function get_perfil() {

        $this->conectar();
        $query = $this->consulta("
SELECT
perfil.idperfil,
perfil.descripcion,
perfil.estado
FROM
perfil
        ");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return '';
        }
    }
    
      function nuevousuario() {

        $this->conectar();
       
             $query = $this->consulta("  INSERT INTO `personal` (`idperfil`, `idoficina`, `segundo_nombre`, `primer_nombre`,
                 `apellido_p`, `apellido_m`, `telf2`, `telf1`, `correo`, `dir_actual` , `pasword`, `usuario`, `estado`, `dnipersonal`) 
                 VALUES ('".$_REQUEST['idperfil']."', '".$_REQUEST['idoficina']."', '".$_REQUEST['snombre']."', '".$_REQUEST['pnombre']."', 
                    '".$_REQUEST['papellido']."', '".$_REQUEST['sapellido']."','".$_REQUEST['tlf1']."','".$_REQUEST['tlf2']."',
                     '".$_REQUEST['correo']."','".$_REQUEST['direccion']."', '".$_REQUEST['passwor']."', '".$_REQUEST['usuario']."', '1', '".$_REQUEST['dni']."')
        ");
        $this->disconnect();
    
    }

      function cambiar_uc() {

        $this->conectar();
       
             $query = $this->consulta(" UPDATE `personal` SET `usuario`='".$_REQUEST['usuario']."', `pasword`='".$_REQUEST['pasword']."' WHERE `idpersonal`='".$_REQUEST['idpers']."' ");
        $this->disconnect();
    
    }
    
        function update_usus() {
        $this->conectar();

        $query = $this->consulta("UPDATE `personal` SET `idperfil`='".$_REQUEST['idperfil']."', `primer_nombre`='".$_REQUEST['pnombre']."', "
                . "`segundo_nombre`='".$_REQUEST['snombre']."', `apellido_p`='".$_REQUEST['papellido']."', `apellido_m`='".$_REQUEST['sapellido']."',"
                . " `usuario`='".$_REQUEST['usuario']."', `pasword`='".$_REQUEST['passwor']."',"
                . " `telf1`='".$_REQUEST['tlf1']."', `telf2`='".$_REQUEST['tlf2']."', `correo`='".$_REQUEST['correo']."', "
                . "`dir_actual`='".$_REQUEST['direccion']."' WHERE `idpersonal`='".$_REQUEST['idcliente']."' ");
        $this->disconnect();
    }
}

?>