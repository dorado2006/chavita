
<style>
    .msk{
        background-color: #BC1010;
        padding: 6px 12px;
        border-radius: 4px;
        color: white;
        font-weight: bold;
        margin-left: -80px;
        margin-top: 15px;
        position: absolute;
    }
</style>
<script>

    $(function () {
        $(".devoluc").hover(
                function () {
                    $(this).focus().after("<span class='msk'>MOD.DEVOLUCION</span>");
                }, function () {
            $('.msk').remove();
        }
        );
        $(".vendi").hover(
                function () {
                    $(this).focus().after("<span class='msk'>MOD.VENDIDOS</span>");
                }, function () {
            $('.msk').remove();
        }
        );
        $(".historial").hover(
                function () {
                    $(this).focus().after("<span class='msk'>HISTORIAL</span>");
                }, function () {
            $('.msk').remove();
        }
        );
        $(".devoluc").click(function () {
            var idperfil = $('#idperfil').val();
            if (idperfil == 1 || idperfil == 4) {

                var dat = $(this).attr('id');
                var separador = dat.split(",");
                idsalida = separador[0];
                poder = separador[1];
                idvendedor = separador[2];
                idproduc = separador[3];
                alertify.prompt("CANTIDAD DE DEVOLUCION", function (e, str) {
                    if (e) {

                        if (eval(str) <= eval(poder) && eval(str) > 0) {

                            alertify.success("Has pulsado '" + alertify.labels.ok + "'' e introducido: " + str);
                            $.post('../web/index.php', 'controller=compras&action=devolucion&idsalida=' + idsalida + '&devol=' + str + '&idproduc=' + idproduc + '&idvendedor=' + idvendedor, function (data) {
                                console.log(data);
                                //$("#dialogo3").empty().append(data);
                            });
                            $.post("../web/index.php", "controller=compras&action=salidaxvende&idvendedor=" + idvendedor, function (data) {

                                console.log(data.msg);
                                $("#mostrar_data").empty().append(data);
                            });
                        }
                        else {
                            alertify.error("LA CANTIDAD NO ESTA EN EL RANGO");
                        }
                    } else {
                        alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
                    }
                });
                //$("#dialogo3").dialog("open");
            }
            else {
                alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");
            }
        });
        $(".vendi").click(function () {
            var idperfil = $('#idperfil').val();
            if (idperfil == 1 || idperfil == 4) {

                var dat = $(this).attr('id');
                var separador = dat.split(",");
                idsalida = separador[0];
                poder = separador[1];
                idvendedor = separador[2];
                alertify.prompt("CANTIDAD DE DEVOLUCION", function (e, str) {
                    if (e) {

                        if (eval(str) <= eval(poder) && eval(str) > 0) {

                            alertify.success("Has pulsado '" + alertify.labels.ok + "'' e introducido: " + str);
                            $.post('../web/index.php', 'controller=compras&action=devolucion&idsalida=' + idsalida + '&devol=' + str + '&cond=vendi&idvendedor=' + idvendedor, function (data) {
                                console.log(data);
                                //$("#dialogo3").empty().append(data);
                            });
                            $.post("../web/index.php", "controller=compras&action=salidaxvende&idvendedor=" + idvendedor, function (data) {

                                console.log(data.msg);
                                $("#mostrar_data").empty().append(data);
                            });
                        }
                        else {
                            alertify.error("LA CANTIDAD NO ESTA EN EL RANGO");
                        }
                    } else {
                        alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
                    }
                });
                //$("#dialogo3").dialog("open");
            }
            else {
                alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");
            }
        });
        $("#resetear").click(function () {

            alertify.confirm("<p><b>ESTAS SEGURO DE RESETEAR.!!!!</b></p>", function (e) {
                if (e) {
                    //alertify.success("Has pulsado '" + alertify.labels.ok + "'");
                    idven = $("#resetear").attr('idve');
                    $.post('../web/index.php', 'controller=compras&action=reset_prodxvend&idven=' + idven, function (data) {
                        console.log(data);
                        alertify.success(data.msj);
                    }, 'json');


                    $.post("../web/index.php", "controller=compras&action=salidaxvende&idvendedor=" + idven, function (data) {
                        console.log(data.msg);
                        $("#mostrar_data").empty().append(data);
                    });

                } else {
                    alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
                }
            });



        });
        $("#hisst").click(function () {
            idven = $(this).attr('idve');
            $.post("../web/index.php", "controller=compras&action=historiaxvende&estado=1&idvendedor=" + idven, function (data) {
                console.log(data);
                $("#dialogo2").empty().append(data);
            });
            $("#dialogo2").dialog("open");
        });
//  $("#dialogo2").dialog("open");
//   $("#dialogo2").dialog("close");
        $("#dialogo2").dialog({
            autoOpen: false,
            width: 1000,
            height: 480,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"


        });
    });
    function alerta() {
        //un alert
        alertify.alert("<b>Blog Reaccion Estudio</b> probando Alertify", function () {
            //aqui introducimos lo que haremos tras cerrar la alerta.
            //por ejemplo -->  location.href = 'http://www.google.es/';  <-- Redireccionamos a GOOGLE.
        });
    }
    function datos() {
        //un prompt
        alertify.prompt("CANTIDAD DE DEVOLUCION", function (e, str) {
            if (e) {
                alertify.success("Has pulsado '" + alertify.labels.ok + "'' e introducido: " + str);
            } else {
                alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
            }
        });
        //return false;
    }
</script>

<div id="dialogo2" class="ventana"  title="HISTORIAL"></div>
<div class="alert alert-danger">
    <label>SI USTED YA ARREGLO CON EL VENDEDOR SOBRE LOS PRODUCTOS..PONER PRODUCTOS EN CERO</label>     
    <button type="submit" id="resetear" <?php echo "idve=" . $rows[0]['idvendedor']; ?> data-toggle="modal" title="RESETEAR"> <img   width="20" height="20" src="../web/assets/avatars/reset.png" alt=""/></a> </button>
    <button type="submit" id="hisst" <?php echo "idve=" . $rows[0]['idvendedor']; ?> data-toggle="modal" title="HISTORIAL"> <img width="20" height="20" src="../web/assets/avatars/historia.png" alt=""/></a> </button>
</div>
<table class="table table-bordered">
    <thead class="2">
        <tr class="active">
            <th width="5%">N°</th>
            <th width="60%">DESCRIPCION</th>
            <th width="10%">CANT.</th>
            <th width="5%">VEND.</th>
            <th width="5%">DEV.</th>
            <th width="5%">PODER</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $con = 1;
        foreach ($rows as $key):
            $poder = ($key['cantidad'] - ($key['vendidos'] + $key['devolucion']));
            ?>
            <tr>
                <td><?php echo $con ?></td>
                <td><?php echo $key['descri'] ?></td>
                <td><a href="#"><span class="badge"><?php echo $key['cantidad'] ?></span></a></td>
                <td><a href="#" class="vendi" <?php echo "id='" . $key['insalida'] . "," . $poder . "," . $key['idvendedor'] . "' " ?>
                       ><span class="badge"><?php echo $key['vendidos'] ?></span></a></td>
                <td><a href="#" class="devoluc" <?php echo "id='" . $key['insalida'] . "," . $poder . "," . $key['idvendedor'] . "," . $key['idproductos'] . "' " ?>
                       ><span class="badge"><?php echo $key['devolucion'] ?></span></a></td>
                <td><a href="#"><span class="badge"><?php echo $poder ?></span></a></td>

               
            </tr>

            <?php
            $con++;
        endforeach;
        ?>


    </tbody>

</table>
