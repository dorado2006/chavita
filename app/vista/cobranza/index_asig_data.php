<link href="../web/assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link rel="stylesheet" href="../web/assets/css/font-awesome.min.css" />

<!--ace styles-->

<!--<link rel="stylesheet" href="../web/assets/css/ace.min.css" />-->
<link rel="stylesheet" href="../web/assets/css/jquery.dataTables.min.css" />

<!--<script src="../web/assets/js/jquery.dataTables.min.js"></script>-->
<script src="../web/assets/js/jquery.dataTables.min.js"></script>

<script src="../web/assets/js/jquery.dataTables.bootstrap.js"></script>       
<script >

    $(function () {





        //$(".asigfecha").addClass("fecha_pago");
        $('.asigfecha').datepicker({'dateFormat': 'yy-mm-dd'});


        $('.trigger').click(function () {
            var id = $(this).attr("name");


            $.post('../web/index.php', 'controller=cobranza&action=cargar_datos_formulario&idcliente=' + id, function (data) {
                console.log(data);
                $("#content_menu_datos").empty().append(data);
            });
            $.post('../web/index.php', 'controller=cobranza&action=cargar_datos_formulario_detalle&idcliente=' + id, function (data) {
                console.log(data);
                $("#detalle").empty().append(data);
                $("#dialogofoto_c").dialog("open");
            });
        });


        $('.bt_guardar11').click(function () {
alert();exit;
            id = $(this).attr("id");
            dni = $(this).attr("dni");
            fech = $("#fecha_f").val();

            var dataString = $('#frm' + id).serialize();
            alert(dataString);
            exit;
            $.post('../web/index.php', 'controller=cobranza&action=index_asig_upd&' + dataString + '&dni=' + dni, function (data) {
                console.log(data);
                // $("#content_menu_datos").empty().append(data);
            });

//            $.post('../web/index.php', 'controller=cobranza&action=index_asig&fech=' + fech, function (data) {
//                console.log(data);
//                $(".contenedor").empty().append(data);
//            });

        });
        $("#latabla select[name=id_pagoen]").change(function () {

            valor = $(this).find('option:selected').text();
            $(this).closest('td').find('span[class=span_pago_en]').text(valor);
            $(this).closest('td').css('color', 'red');
        });
        $("#latabla select[name=id_frec]").change(function () {

            valor = $(this).find('option:selected').text();
            $(this).closest('td').find('span[class=span_frecu]').text(valor);
            $(this).closest('td').css('color', 'red');
        });
        $('#latabla tr button').click(function () {
            var cursor = $(this);
            dni = $(this).attr("dni");
            asigfecha = $(this).closest('tr').find('input[name=fecha_next]').val();

            var d = new Date();
            var month = d.getMonth() + 1;
            var day = d.getDate();
            var output = d.getFullYear() + '-' +
                    (('' + month).length < 2 ? '0' : '') + month + '-' +
                    (('' + day).length < 2 ? '0' : '') + day;

            if (asigfecha <= output) {
                alert("LA FECHA TIENE QUE SER MAYOR A LO ACTUAL");
                exit;
            }

            dataString = $(this).closest('tr').find('input,textarea,select').serialize();

            $.post('../web/index.php', 'controller=cobranza&action=index_asig_upd&' + dataString + '&dni=' + dni, function (data) {
                console.log(data);
                // $("#content_menu_datos").empty().append(data);

                if (data.resp == 1) {
                    alertify.success(data.msg + ". SE GUARDO CON EXITO");
                    cursor.closest('tr').css("background-color", "rgb(116, 187, 99)");
                }else if(data.resp == 3){
                    alertify.error(data.msg);
                } 
                else {
                    
                      alertify.error(data.msg);
                }

            }, 'json');


        });




        //var oTable1 = $('').dataTable(); var oTable1 = $('#sample-table-2').dataTable();
          $('#latabla').DataTable( {
        "lengthMenu": [[100, 25, 50, -1], [100, 25, 50, "All"]]
    } );


    });


</script>

<table id="latabla" class="table table-striped  table-bordered table-hover">
    <thead class="" style=" text-justify: ">
      <tr class="active">              
          <th width="2%">N°</th>
            <th width="25%">CLIENTE</th>
            <th width="3%">CREDITO</th>
            <th width="3%">AMORTIZA</th>
            <th width="2%" class="editable"  data-campo='nombre'><span>SALDO</span></th>
            <th width="10%" style="text-align: center">ACUERDO</th>
            <th width="6%">FRECUENCIA</th>
            <th width="4%">PAGO EN</th>
            <th width="7%" style="text-align: center">FECHA</th>                
            <th width="6%" style="text-align: center">ASIGNAR</th>
            <th width="2%" style="text-align: center">ACCION</th>
        </tr>

    </thead>
    <tbody>
        <?php foreach ($rows as $key => $data): ?>

        <form id="<?php echo "frm" . $key ?>" >
 <tr bgcolor="#EDECE7" oculto="btn-<?php echo $data['colo']; ?>" onmouseover="this.bgColor = '#FFFDAE';" onmouseout="this.bgColor = '#EDECE7';" style="font-size: 0.775em">
<!--<a  class="trigger" name= <?php echo $data['dni'] ?>>-->

     <td ><input type="checkbox" name="chechc" value="<?php echo $data['dni'] ?>" <?php echo $data['estadoo'] ?>>
            </td>
            <td   style="padding: 5px 20px 5px 1px; "><?php echo utf8_encode($data['nomcliente']); ?></td>
            <td    style="padding: 5px 20px 5px 1px; "><?php echo $data['tcredito']; ?></td>
            <td  style="padding: 5px 20px 5px 1px; "><?php echo $data['tabono']; ?></td>
            <td   style="padding: 5px 20px 5px 1px; "><?php echo $data['tcredito'] - $data['tabono']; ?></td>
            <td   style="padding: 5px 20px 5px 1px; text-align: center">
                <textarea name="acuerdo" form="<?php echo "frm" . $key ?>" ><?php echo utf8_encode($data['acuerdo']); ?> </textarea>
            </td>
            <td  style="padding: 5px 20px 5px 1px; ">
                <span class="span_frecu" style=" width: 50%;float: left;text-align:right ">
                    <?php echo $data['frecuencia_msg']; ?>
                </span>
                <span style=" width: 20%;float: right;">  
                    <?php echo $frecuencia; ?></span>

                <input type="hidden" name="fr1" form="<?php echo "frm" . $key ?>" value="<?php echo $data['frecuencia_msg']; ?>">
            </td>

            <td   style="padding: 5px 20px 5px 1px; ">
                <span class="span_pago_en" style=" width: 50%;float: left;text-align:right"><?php echo $data['pagoen']; ?></span>
                <span style=" width: 20%;float: right">  
                    <?php echo $pago_en; ?>
                </span>

                <input type="hidden" name="pr2" form="<?php echo "frm" . $key ?>" value="<?php echo $data['pagoen']; ?>">
            </td>
            <td   style="padding: 5px 20px 5px 1px;text-align: center ">
                <input type="text" size="10" class="asigfecha"  name="fecha_next" form="<?php echo "frm" . $key ?>" value="<?php echo $data['fecha_verif']; ?>"  >
            </td>
            <td  style="padding: 5px 20px 5px 1px; ">
                <?php echo $asig; ?>
                <input type="hidden" name="idperbusca"  value="<?php echo $data['idpersonal']; ?>">
            </td>
            <td><button class="btn btn-<?php echo $data['colo']; ?> btn-sm bt_guardar" dni="<?php echo $data['dni'] ?>" id="<?php echo $key ?>" title="Editar Cliente" data-toggle="modal" data-target="#MyModal_acuerdo"><span class="glyphicon glyphicon-pencil  "></span>ACTUALIZA</button></td>

        </tr>
</form>


    <?php endforeach; ?>
</tbody>
</table>