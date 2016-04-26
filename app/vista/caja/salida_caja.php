
<style>
    .ui-autocomplete .highlight {
        text-decoration: underline;
    }

</style>
<script>
    $(function () {

        function highlightText(text, $node) {
            var searchText = $.trim(text).toLowerCase(), currentNode = $node.get(0).firstChild, matchIndex, newTextNode, newSpanNode;
            while ((matchIndex = currentNode.data.toLowerCase().indexOf(searchText)) >= 0) {
                newTextNode = currentNode.splitText(matchIndex);
                currentNode = newTextNode.splitText(searchText.length);
                newSpanNode = document.createElement("span");
                newSpanNode.className = "highlight";
                currentNode.parentNode.insertBefore(newSpanNode, currentNode);
                newSpanNode.appendChild(newTextNode);
            }
        }
        var data = <?php echo json_encode($rows); ?>;

        $("#autocomplete1").autocomplete({
            source: data
        });
        $("#tags").autocomplete({
            source: data,
            focus: function (event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox
                $(this).val(ui.item.label);
            },
            select: function (event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox and hidden field
                $(this).val(ui.item.label);
                $("#id_personal").val(ui.item.value);
//                $.post("../web/index.php", "controller=compras&action=salidaxvende&idvendedor=" + ui.item.value, function (data) {
//
//                    console.log(data.msg);
//                    $("#mostrar_data").empty().append(data);
//
//                });
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var $a = $("<a></a>").text(item.label);
            highlightText(this.term, $a);
            return $("<li></li>").append($a).appendTo(ul);
        };
        /////////////////////7------------------autocomplete descripcion--------

        var data1 = <?php echo json_encode($rows1); ?>;

        $("#tags_desc").autocomplete({
            source: data1,
            focus: function (event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox
                $(this).val(ui.item.label);
            },
            select: function (event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox and hidden field
                $(this).val(ui.item.label);
                $("#id_descrip").val(ui.item.value);
//                $.post("../web/index.php", "controller=compras&action=salidaxvende&idvendedor=" + ui.item.value, function (data) {
//
//                    console.log(data.msg);
//                    $("#mostrar_data").empty().append(data);
//
//                });
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var $a = $("<a></a>").text(item.label);
            highlightText(this.term, $a);
            return $("<li></li>").append($a).appendTo(ul);
        };
        /////////7-------------------------fin------------------

        $(".limpiar").click(function () {
            $("#tags").val("");
            $("#tags").focus();
        });
        $(".limpiar2").click(function () {
            $("#tags_desc").val("");
            $("#tags_desc").focus();
        });
        $("#guardar").click(function () {

            var dataString = $('#frm').serialize();
           
            $.post('../web/index.php', dataString, function (data) {
                alertify.success(data.msj);
               
            }, 'json');
            $("#tags_desc").val("");
            $("#tags").val("");
            $("#mont").val("");
            
            return false;
        });


    });
</script>
<?php //echo"<pre>";print_r($rowst); ?>

<input type="hidden" id="idperfil" value="<?php echo $_SESSION['idperfil'] ?>">



<div class="row " style=" padding-top: 10px">
    <div class="col-lg-1"></div>
    <div class="col-lg-5">
        <div class="panel panel-info">
            <!--            <div class="panel-heading">ARQUEO DE PRODUCTOS POR VENDEDOR</div>-->
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="frm">
                    <input type="hidden" name="controller" value="caja">
                    <input type="hidden" name="action" value="save_salida_flujo"> 
                    <input type="hidden" name="id_personal" id="id_personal"> 
                    <input type="hidden" name="id_descrip" id="id_descrip"> 
                    <div class="form-group">
                        <label for="tags" class="col-lg-3 control-label ">ASIGNAR</label>
                        <div class="col-lg-9">                            
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="form-control-feedback glyphicon glyphicon-search"></i></span>
                                <input type="text" name="asignar" class="form-control" id="tags" placeholder="INGRESE RESPONSABLE" >
                                <span class="input-group-addon limpiar">
                                    <i class="form-control-feedback glyphicon glyphicon-remove"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tags_desc" class="col-lg-3 control-label ">DESCRIPCION</label>
                        <div class="col-lg-9">                            
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="form-control-feedback glyphicon glyphicon-search"></i></span>
                                <input type="text" name="concepto" class="form-control" id="tags_desc" placeholder="INGRESE DESCRIPCION" >
                                <span class="input-group-addon limpiar2">
                                    <i class="form-control-feedback glyphicon glyphicon-remove"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mont" class="col-lg-3 control-label ">MONTO</label>

                        <div class="col-lg-9">                            
                            <div class="input-group">

                                <input type="text" name="monto" class="form-control" id="mont" placeholder="INGRESE EL MONTO" >
                                <span class="input-group-addon ">
                                    <i class="form-control-feedback glyphicon">S/</i></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="MONTr" class="col-lg-3 control-label "></label>

                        <div class="col-lg-5">                            

                            <button type="button" class="btn btn-info " id="guardar">GUARDAR</button>
                        </div>

                    </div>


                </form>
            </div>
        </div>

    </div>
    <div class="col-lg-5">
        <div class="panel panel-info">
            <div class="panel-heading">DETALLE DE SALIDA</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <?php foreach ($rows1 as $key => $data): ?>
                        <div class="form-group">
                            <label class=" col-lg-1"><?php echo $key + 1; ?></label>
                            <div class="col-lg-10" style=" text-align: left"> 
                                <label for="concep" ><?php echo $data['label'] ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>   


                </form>
            </div>
        </div>

    </div>
</div>
