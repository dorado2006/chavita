<script>
    $(function() {
        $("#buscar").click(function() {
            criterio = $("#criterio").val();
            filtro = $("#filtro").val();
            $.post('../web/index.php', 'controller=cliente&action=mostrar_miembros_ugel&criterio=' + criterio + '&filtro=' + filtro, function(data) {
                console.log(data);
                $("#tab").empty().append(data);
            });
        });

    });
</script>
<table width="100%" border="1" cellpadding="3" cellspacing="1"  class="table table-bordered">
    <tr>
        <td colspan="3" align="center" class="success"><strong>Busqueda del cliente en el sistema por UGEL</strong></td>
    </tr>
    <tr>
        <td colspan="3">
            <select id="filtro">
                <option value="dni">DNI</option>
                <option value="nombres">NOMBRES</option>
                <option value="apellido_p">AP. PATERNO</option>
            </select>
            <input type="text" size="30" id="criterio">
            <a class="btn btn-success glyphicon glyphicon-search" id="buscar"> Buscar</a><br>
            <div id="tab"></div>
        </td>
    </tr>
</table>