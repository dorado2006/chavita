<script>
    $(function() {
        $("#buscar_producto").click(function() {
            criterio = $("#producto").val();
            filtro = $("#condicion").val();
            $.post('../web/index.php', 'controller=productos&action=buscar_producto&criterio=' + criterio + '&filtro=' + filtro, function(data) {
                console.log(data);
                $("#divproductos").empty().append(data);
            });
        });
        $.post('../web/index.php', 'controller=productos&action=buscar_producto', function(data) {
            console.log(data);
            $("#divproductos").empty().append(data);
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
                            <input type="text" id="producto" name="producto"  size="28">
                            <button class="btn btn-success  glyphicon glyphicon-search" id="buscar_producto"> Buscar</button>

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