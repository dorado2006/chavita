<link href="../web/assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link rel="stylesheet" href="../web/assets/css/font-awesome.min.css" />

<!--ace styles-->
<link rel="stylesheet" href="../web/assets/css/ace.min.css" />
<script src="../web/assets/js/jquery.dataTables.min.js"></script>
<script src="../web/assets/js/jquery.dataTables.bootstrap.js"></script>

<script>

    $(function () {
        

        var oTable1 = $('#sample-table-2').dataTable();

    });

</script>
<table id="sample-table-2" class="table table-striped  table-bordered table-hover">
            <thead class="">

                <tr class="active">
                    <th width="3%">N°</th>
                    <th width="5%">FECHA</th>
                    <th width="15%">DETALLE</th>
                    <th width="10%">ENTRADA</th>
                    <th width="10%">SALIDA</th>

                    <th width="20%">RESPONSABLE</th>



                </tr>
            </thead>
            <tbody style=" font-size: 10px">
                <?php
                $con = 1;
                foreach ($rows as $key):
                    ?>
                    <tr>
                        <td><?php echo $con ?></td>
                        <td><?php echo $key['fecha'] ?></td>
                        <td><?php echo $key['detall'] ?></td>
                        <td><?php echo $key['entrada'] ?></td>
                        <td><?php echo $key['salida'] ?></td>

                        <td><?php echo $key['primer_nombre'] ?></td>

                    </tr>
                    <?php
                    $con++;
                endforeach;
                ?>
            </tbody>
        </table>