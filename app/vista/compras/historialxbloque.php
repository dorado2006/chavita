<script>

$(function () {
      $('.historibloq').click(function () {
                dta = $(this).attr("id");
                var separa = dta.split(",");
                    idbloque = separa[0];
                    idven = separa[1];
                $.post("../web/index.php", "controller=compras&action=historiaxvende&idvendedor=" + idven +"&idbloque=" +idbloque, function (data) {

                    console.log(data.msg);
                    $(".histxvende").empty().append(data);

                });

            });
    
});

</script>

<div class="alert alert-success">

</div>
<div class="row">
    <div class="col-lg-2" style="
         height: 400px; // Set this height to the appropriate size
         overflow-y: scroll" >


        <table class="table table-bordered" >
            <thead class="2" >
                <tr class="active" align="center"><th colspan="2" >BLOQUES</th></tr>
                <tr class="active">
                    <th>N</th>
                    <th>FECHA</th>


                </tr>
            </thead>
            <tbody style=" font-size: 10px">
                <?php
                $con = 1;
                foreach ($rows as $key):
                    ?>
                    <tr>
                        <td><?php echo $con ?></td>
                        <td class="historibloq" title="CLICK PARA VER EL HISTORIAL" <?php echo "id='" . $key['idbloques'] . "," . $key['idvendedor'] . "'" ?>><?php echo $key['fecha'] ?>
                        
                        </td>
                    </tr>

                    <?php
                    $con++;
                endforeach;
                ?>


            </tbody>

        </table>
    </div>
    <div class="col-lg-10 histxvende"  style="
         height: 400px; // Set this height to the appropriate size
         overflow-y: scroll">
      
    </div>
</div>