<script>

    $(function() {
        var id;
        var saldo;
        var letra;
        var cond_pago;
        $(".idcliente").click(function() {
            $(".idcliente").removeClass("ui-selected");
            $(this).addClass("ui-selected");
            var id_saldo = $(this).attr("name");

            var separador = id_saldo.split(",");
            id = separador[0];
            saldo = separador[1];
            letra = separador[2];
            cond_pago = separador[3];

            $('#saldoC').html(saldo);
            $('#saldoL').html(letra);
            $('#dni_cliente').val(id);
            $('#imprimir').prop('href', 'index.php?controller=cobranza&action=imprimir_cronograma&idprodni=' + id);

            $.post('../web/index.php', 'controller=cobranza&action=cargar_datos_formulario&idcliente=' + id, function(data) {

                console.log(data);
                $("#content_menu_datos").empty().append(data);
                $('#cond_pago').html(cond_pago);
            });
            $.post('../web/index.php', 'controller=cobranza&action=cargar_datos_formulario_detalle&idcliente=' + id, function(data) {
                console.log(data);
                $("#detalle").empty().append(data);
            });
            $.post('../web/index.php', 'controller=cobranza&action=formulario_editar_cliente&idcliente=' + id, function(data) {
                console.log(data);
                $("#editar_cliente").empty().append(data);
            });

            $.post('../web/index.php', 'controller=cobranza&action=formulario_nueva_venta&idcliente=' + id, function(data) {
                console.log(data);
                $("#Nueva_Venta").empty().append(data);
            });
            $.post('../web/index.php', 'controller=cobranza&action=formulario_acuerdo&idcliente=' + id, function(data) {
                console.log(data);
                $("#acuerdos").empty().append(data);
            });
        });
    });
</script>
<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, "ncprueba",3308);
$result;
if (isset($_POST['parametro'])) {
    $parametro = trim(utf8_decode($_POST['parametro']));

    $cadena = explode(" ", $parametro);
    $tamaño = count($cadena);
    $espacios = $tamaño - 1;

    if ($parametro != "") {
//        if ($espacios > 0) {
//
//            if (strlen($cadena[0]) <= 3 ) {
//                $nom = $cadena[0] . " " . $cadena[1];
//
//                if ($espacios < 2) {
//                    $result = $mysqli->query("                             
//select cliente.idcliente ,
//CONCAT_WS(' ',cliente.apellido_p,cliente.apellido_m ,cliente.primer_nombre ,cliente.segundo_nombre) as nombres,
//cliente.dni 
//from cliente 
//WHERE cliente.apellido_p like '" . $nom . "%'  ");
//                } else {
//
//                    $result = $mysqli->query("                             
//select cliente.idcliente ,
//CONCAT_WS(' ',cliente.apellido_p,cliente.apellido_m ,cliente.primer_nombre ,cliente.segundo_nombre) as nombres,
//cliente.dni 
//from cliente 
//WHERE cliente.apellido_p = '" . $nom . "' and cliente.apellido_m like '" . $cadena[2] . "%' ");
//                }
//            } 
//            else {
//                $result = $mysqli->query("                             
//select cliente.idcliente ,
//CONCAT_WS(' ',cliente.apellido_p,cliente.apellido_m ,cliente.primer_nombre ,cliente.segundo_nombre) as nombres,
//cliente.dni 
//from cliente 
//WHERE cliente.apellido_p = '" . $cadena[0] . "' and cliente.apellido_m like '" . $cadena[1] . "%' ");
//            }
//        } else {
            //$result = $mysqli->query("SELECT * FROM post WHERE titulo LIKE '%$parametro%' or contenido LIKE '%$parametro%';");
            $result = $mysqli->query("                             
select cliente.idcliente ,
CONCAT_WS(' ',cliente.apellidos,cliente.nombres) as nombres,
cliente.dni 
from cliente 
WHERE cliente.nombres LIKE '%" . $parametro . "%' or apellidos like '" . $parametro . "%' or cliente.dni like '%" . $parametro . "%'

");
        
        $resultados = array();
        while ($row_errs = $result->fetch_array()) {
            $resultados[] = $row_errs;
        }
        ?>
        <ol  id="selectable">
        <?php
        foreach ($resultados as $data):
            ?>
                <li class="idcliente sugerencias  ui-widget-content" <?php echo "name='" . $data['dni'] . "'"; ?> >

                    <span   id="sugerencias1">
                <?php echo strtoupper(utf8_encode($data['nombres'])); ?></span>

                    <span id="sugerencias2" class="<?php echo $data['dni']; ?>" ><?php echo ""; ?></span>      

                </li>
            <?php
        endforeach;
        ?>
        </ol>
            <?php
        } else {
            echo "NUEVA BUSQUEDA";
        }
    }
    ?>