
<script>
    $(function () {


        var data = <?php echo json_encode($rows); ?>;
        
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
                $("#tagsaa").val(ui.item.value);
                $.post("../web/index.php", "controller=compras&action=form_actproduc&idprod=" + ui.item.value, function (data) {

                    console.log(data.msg);
                    $("#mostrar_data").empty().append(data);

                });
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var $a = $("<a></a>").text(item.label);
            highlightText(this.term, $a);
            return $("<li></li>").append($a).appendTo(ul);
        };

        $(".limpiar").click(function () {
            $("#tags").val("");
            $("#tags").focus();
        });


    });
</script>

<div class="container-fluid">  
    <div class="row">  
        <div  class="col-sm-12 col-md-12 ">
            <div align="center">
                <table width="100%" border="1" cellpadding="3" cellspacing="1"  class="table table-bordered">
                    <tr>
                        <td colspan="3" align="center" class="success"> <strong>Busqueda de Productos En el Sistema</strong></td>
                    </tr>
                    <tr>
                        <td  align="center" colspan="3">   
                            <select name="condicion" id="condicion">
                                <option value="categoria">Categoria</option>
                                <option value="nombre">Nombre</option>
                                <option value="precio_venta">Precio</option>
                                <option value="todas_coincidencias">Toda Coincidencia</option>
                            </select>
                            <input type="text" id="producto" name="producto"  size="28" >
                            <button class="btn btn-success  glyphicon glyphicon-search" id="buscar_producto"> Buscar</button>
                            <button class="btn btn-success  glyphicon glyphicon-search" id="pro"> Buscar</button>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="form-control-feedback glyphicon glyphicon-search"></i></span>
                                <input type="text" name="BUSCAR" class="form-control" id="tags" placeholder="INGRESE EL PRODUCTO">
                                <span class="input-group-addon limpiar">
                                    <i class="form-control-feedback glyphicon glyphicon-remove"></i></span>

                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center"><div id="divproductos" style="width: 100%">Cargando...</div></td> 

                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>