<table class="table table-bordered">
    <thead class="2">
        <tr class="active"><TH colspan="7" align="center" >HISTORIAL POR BLOQUES</tH></tr>
        <tr class="active">
            <th width="3%">N°</th>
            <th width="12%">FECHA</th>
            <th width="60%">PRODUCTO</th>
            <th width="5%">CANT.</th>
            <th width="5%">VEND.</th>
            <th width="5%">DEV.</th>
            <th width="10%">RESP.</th>


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
                <td><?php echo $key['prod'] ?></td>
                <td><?php echo $key['salida'] ?></td>
                <td><?php echo $key['vend'] ?></td>
                <td><?php echo $key['dev'] ?></td>
                <td><?php echo $key['primer_nombre'] ?></td>
            </tr>
            <?php $con++;
        endforeach;
        ?>
    </tbody>
</table>