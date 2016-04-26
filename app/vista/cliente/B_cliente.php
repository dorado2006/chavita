<script >

    $(function() {
        $("#buscar").click(function() {
            var pos_condicion = $("#pos_condicion").val();
            var condicion = $("#condicion").val();
            $.post('../web/index.php', 'controller=cliente&action=buscar_cliente&pos_condicion='+pos_condicion+'&condicion='+condicion, function(data) {
                console.log(data);
                $("#tabla").empty().append(data);
            });
        });
    });
</script>
<div class="t"><?php echo $titulo; ?></div>

<!--<form action="../web/index.php" method="post">
    <input type="hidden" name="controller" value="cliente">
    <input type="hidden" name="action" value="buscar_cliente">-->
    <table border="0" cellspacing="4" cellpadding="0" class="tabla">
        <tr>
            <!-- ?controller=cliente&action=buscar_cliente--->
            <td>Buscar por: </td>
            <td><label>
                    <select name="pos_condicion" id="pos_condicion">
                        <option value="primer_nombre">Nombres</option>
                        <option value="dni">DNI</option>
                        <option value="apellido_p">APELLIDO PT</option>

                    </select>
                </label></td>
            <td>Cantidad de registros: </td>
            <td><label>
                    <select name="cantidad">
                        <option value="10">10</option>
                        <option value="12">12</option>
                        <option value="16">16</option>
                        <option value="24">24</option>
                        <option value="36">36</option>
                        <option value="72">72</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                    </select>
                </label></td>
            <td>
                <input type="search"  name="condicion" id="condicion"></td>
            <td><label>
                    <button type="button"  name="buscar" id="buscar" class="btn btn-primary glyphicon glyphicon-search" >&nbsp;Buscar</button>
          
          
                
                </label></td>
        </tr>
    </table>
<!--</form>-->
<div id ="tabla"><?php echo $tabla; ?></div>