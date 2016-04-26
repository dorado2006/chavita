<link href="../web/assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link rel="stylesheet" href="../web/assets/css/font-awesome.min.css" />

<!--ace styles-->
<link rel="stylesheet" href="../web/assets/css/ace.min.css" />
<script src="../web/assets/js/jquery.dataTables.min.js"></script>
<script src="../web/assets/js/jquery.dataTables.bootstrap.js"></script>

<script>
    $(function() {
        var oTable1 = $('#sample-table-2').dataTable();

    });

</script>
<!--<table class="table table-bordered">-->
<table id="sample-table-2" class="table table-striped  table-bordered table-hover">
    <thead class="">
        
        <tr class="active">
            <th width="3%">N°</th>
            <th width="15%">CATEGORIA</th>
            <th width="15%">PRODUCTO</th>
            <th width="10%">MARCA</th>
            <th width="10%">MODELO</th>
            <th width="15%">DESCRIPCION</th>
            <th width="5%">COLOR</th>
            <th width="5%">STOCK ALM</th>
            <th width="5%">STOCK OF</th>
            <th width="15%">PRE.VENTA</th>


        </tr>
    </thead>
    <tbody style=" font-size: 10px">
        <?php
        $con = 1;
        foreach ($rows as $key):
            ?>
            <tr>
                <td><?php echo $con ?></td>
                <td><?php echo $key['categoria'] ?></td>
                <td><?php echo $key['nombre_pr'] ?></td>
                <td><?php echo $key['marca'] ?></td>
                <td><?php echo $key['modelo'] ?></td>
                <td><?php echo $key['descripcion'] ?></td>
                <td><?php echo $key['color'] ?></td>
                <td><?php echo $key['stock'] ?></td>
                <td><?php echo $key['stock_of'] ?></td>
                <td><?php echo $key['precio_venta'] ?></td>
            </tr>
            <?php
            $con++;
        endforeach;
        ?>
    </tbody>
</table>