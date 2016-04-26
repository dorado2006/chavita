<style>
    .boton {
        //float:left;
        margin-right:10px;
        margin-top:20px;
        width:130px;
        height:40px;
        background:#222;
        color:#fff;
        padding:10px 6px 0 6px;
        cursor:pointer;
        text-align:center;
    }
</style>

<link href="../web/assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link rel="stylesheet" href="../web/assets/css/font-awesome.min.css" />

<!--ace styles-->
<link rel="stylesheet" href="../web/assets/css/ace.min.css" />
<link rel="stylesheet" href="../web/assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="../web/assets/css/ace-skins.min.css" />
<script src="../web/assets/js/jquery.dataTables.min.js"></script>
<script src="../web/assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="../web/assets/js/ace-elements.min.js"></script>
<script src="../web/assets/js/ace.min.js"></script>

<script src='../web/js/funciones.js'></script>

<script>
    $(function() {
        //var oTable1 = $('#sample-table-2').dataTable();
        $('#sample-table-2').dataTable({
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                        .column(4)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        });

                // Total over this page
                pageTotal = api
                        .column(4, {page: 'current'})
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                // Update footer
                $(api.column(4).footer()).html(
                        'S/.' + pageTotal + ' ( S/.' + total + ' total)'
                        );
            }
        });


    });

</script>



<div class="table-header">
    Reporte de ventas
</div>
<table id="sample-table-2" class="table table-striped  table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">
                <label>
                    <input type="checkbox" />
                    <span class="lbl"></span>
                </label>
            </th>
            <th>DNI</th>
            <th width="30%">CLIENTE</th>
            <th width="10%">FECHA</th>
            <th width="10%">CREDITO </th>
            <th width="10%">CUOTA</th>
            <th>MESES</th>
            <th>PRODUCTO</th>
            <th>CONDICION</th>
            <th>VENDEDOR</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th colspan="4" style="text-align:right">Total:</th>
            <th colspan="5"></th>
        </tr>
    </tfoot>
    <tbody style=" font-size: 10px">

        <?php
        $totalcre = 0;
        foreach ($rows as $valor):
            $totalcre = ($totalcre + $valor['credito']);
            ?>
            <tr>
                <td class="center">
                    <label>
                        <input type="checkbox" />
                        <span class="lbl"></span>
                    </label>
                </td>

                <td><?php echo $valor['dni']; ?></td>
                <td class="hidden-480"><?php echo utf8_encode($valor['nombre']); ?></td>
                <td class="hidden-480"><?php echo $valor['fecha_mov']; ?></td>
                <td class="hidden-phone"><?php echo $valor['credito']; ?></td>
                <td class="hidden-phone"><?php echo $valor['letra']; ?></td>
                <td class="hidden-phone"><?php echo $valor['num_cuotas']; ?></td>
                <td class="hidden-phone"><?php echo $valor['producto']; ?></td>
                 <td class="hidden-phone"><?php echo $valor['cond_pago']; ?></td>
                <td class="hidden-phone"><?php echo $valor['vendedor']; ?></td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>
