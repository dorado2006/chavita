<script>
    $(function() {
        $("#buscar").click(function() {
            criterio = $("#criterio").val();
            filtro = $("#filtro").val();
            $.post('../web/index.php', 'controller=cliente&action=buscar_cliente2&criterio=' + criterio + '&filtro=' + filtro, function(data) {
                console.log(data);
                $("#tab").empty().append(data);
            });
        });
        $.post('../web/index.php', 'controller=cliente&action=buscar_cliente2', function(data) {
            console.log(data);
            $("#tab").empty().append(data);
        });

    });
</script>
<div class="container-fluid">   
    <div class="row">  
        <div  class="col-sm-12 col-md-12 ">
            <div align="center">
                <table width="100%" border="1" cellpadding="3" cellspacing="1"  class="table table-bordered">
                    <tr>
                        <td colspan="3" align="center" class="success"><strong>Busqueda de Clientes En el Sistema</strong></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
 
                                <select id="filtro" class="form-control" style="width: 180px;" >
                                    <option value="dni">DNI</option>
                                    <option value="primer_nombre">PRIMER NOMBRE</option>
                                    <option value="apellido_p">AP. PATERNO</option>
                                </select>
                                <input type="text" class="form-control" style="width: 280px;" size="30" id="criterio">
                                <a class="btn btn-success glyphicon glyphicon-search" id="buscar"> Buscar</a><br>
                                <div id="tab"><br><strong>Cargando Clientes....</strong>
                                </div>
                            
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>