<style>
    #contreporte{border: 2px #000 groove;
                 padding-left: 1%;
                 padding-right: 1%;
                 margin-left:  1%;
                 margin-right: 1%
    }
    #cabezareporte{padding: 2px}


    span.redm {
        background: red;
        border-radius: 35px;
        -moz-border-radius: 35px;
        -webkit-border-radius: 35px;
        color: #ffffff;
        display: inline-block;
        font-weight: bold;
        line-height: 70px;
        margin-right: 15px;
        text-align: center;
        font-size: 10px;
        width: 70px; 
        cursor: pointer
    }

    span.orangem {
        background: orange;
        border-radius: 35px;
        -moz-border-radius: 35px;
        -webkit-border-radius: 35px;
        color: #ffffff;
        display: inline-block;
        font-weight: bold;
        line-height: 70px;
        margin-right: 15px;
        text-align: center;
        font-size: 10px;
        width: 70px; 
        cursor: pointer
    }

    span.grenm {
        background: green;
        border-radius: 35px;
        -moz-border-radius: 35px;
        -webkit-border-radius: 35px;
        color: #ffffff;
        display: inline-block;
        font-weight: bold;
        line-height: 70px;
        margin-right: 15px;
        text-align: center;
        font-size: 10px;
        width: 70px;
        cursor: pointer
    }
</style>
<script>
    $(function() {
        $("#busquedareporte").change(function() {
            var combinacion = $('#combinar').is(':checked');
            if (combinacion == false) {
                var condi = $("#busquedareporte").val();
                var cond_wher = 1;

                $.post('../web/index.php', 'controller=cobranza&action=reportes&condi=' + condi + '&cond_wher=' + cond_wher, function(data) {
                    console.log(data);
                    $("#cuerporeporte").empty().append(data);
                });
            }
            else {
                var condi = $("#busquedareporte").val();
                var condi1 = $("#busquedasector").val();
                
                var cond_wher = 4;
                $.post('../web/index.php', 'controller=cobranza&action=reportes&condi=' + condi + '&cond_wher=' + cond_wher + '&condi1=' + condi1, function(data) {
                    console.log(data);
                    $("#cuerporeporte").empty().append(data);
                });

            }

        });

        $(".botonExcel").click(function(event) {
            $("#datos_a_enviar").val($("<div>").append($("#Exportar_a_Excel").eq(0).clone()).html());
            $("#FormularioExportacion").submit();
        });

        $("#busquedasector").change(function() {

            var combinacion = $('#combinar').is(':checked');
            if (combinacion == false) {

                var condi1 = $("#busquedasector").val();
                
                cond_wher = 2;
                $.post('../web/index.php', 'controller=cobranza&action=reportes&condi1=' + condi1 + '&cond_wher=' + cond_wher, function(data) {
                    console.log(data);
                    $("#cuerporeporte").empty().append(data);
                });
            }
            else {

                var condi1 = $("#busquedasector").val();
                var condi = $("#busquedareporte").val();
                var cond_wher = 3;
                $.post('../web/index.php', 'controller=cobranza&action=reportes&condi=' + condi + '&cond_wher=' + cond_wher + '&condi1=' + condi1, function(data) {
                    console.log(data);
                    $("#cuerporeporte").empty().append(data);
                });

            }




        });
        
       







        function animateprogress(id, val) {


            var getRequestAnimationFrame = function() {  /* <------- Declaro getRequestAnimationFrame intentando obtener la máxima compatibilidad con todos los navegadores */
                return window.requestAnimationFrame ||
                        window.webkitRequestAnimationFrame ||
                        window.mozRequestAnimationFrame ||
                        window.oRequestAnimationFrame ||
                        window.msRequestAnimationFrame ||
                        function(callback) {
                            window.setTimeout(enroute, 1 / 60 * 1000);
                        };

            };

            var fpAnimationFrame = getRequestAnimationFrame();
            var i = 0;
            var animacion = function() {

                if (i <= val)
                {
                    document.querySelector(id).setAttribute("value", i);      /* <----  Incremento el valor de la barra de progreso */
                    document.querySelector(id + "+ span").innerHTML = i + "%";     /* <---- Incremento el porcentaje y lo muestro en la etiqueta span */
                    i++;
                    fpAnimationFrame(animacion);          /* <------------------ Mientras que el contador no llega al porcentaje fijado la función vuelve a llamarse con fpAnimationFrame     */
                }

            }

            fpAnimationFrame(animacion);   /*  <---- Llamo la función animación por primera vez usando fpAnimationFrame para que se ejecute a 60fps  */

        }

 /*$("#imprimir").click(function() {
          $('.nodiv').remove();
           $('.cuerpotabla1').remove();
            $('#cabtabla').remove();
            $('#cabezareporte').remove();
             $('#menu').remove();
             $('#cabecera').remove();
            
      // print();
     });*/
  $("#imprimir").click(function() {

            bval = true;

            if (bval) {
                $("#frm").submit();
            }
            return false;
        });







    });
    
    
</script>
 <style media="print" type="text/css">
#imprimir {visibility:hidden}
//.cuerpotabla1{visibility:hidden}
//#cabtabla{visibility: hidden}
//#menu{visibility: hidden}
//#cabezareporte{visibility:hidden}
//#mmmcabecera{visibility: hidden}



</style>
<div id="contreporte">
    <div id="cabezareporte" class="cabezareporte" style="text-align: center">
        <table border="0">
            <tr>
                <td><b>Buscar Por Condición de Pago</b></td>
                <td>
                    <select name="busquedareporte" id="busquedareporte">
                        <option value="PLANILLA">Selecciana</option>        
                        <option value="PLANILLA">PLANILLA</option>
                        <option value="DIRECTO">DIRECTO</option>
                        <option value="ANULADO">ANULADO</option>
                        <option value="CANCELADO">CANCELADO</option>
                    </select>
                </td>
                <td width="15%" align="center">Combinar &nbsp; <input type="checkbox" name="combinar" id="combinar"></td>
                <td><b>Buscar Por Distritos</b></td>
                <td>
                    <select name="condi" id="busquedasector">
                        <option value="sele">Selecciana</option> 
                        <?php foreach ($rows as $key => $data): ?>
                            <option value="<?php echo $data['distrito'] ?>"><?php echo $data['distrito'] ?></option>

                        <?php endforeach; ?>
                    </select>
                </td>

                <td><form action="../app/vista/cobranza/exportar_excel.php" method="post" target="_blank" id="FormularioExportacion">
                        <p style=" cursor: pointer">Exportar<img src="../web/img/excel.gif " class="botonExcel" /></p>                
                        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                    </form>
                </td>
                <td width="5%"></td>
                <td>
                    <h5><span class="redm">[0% - 49% ]</span></h5>
                </td>
                <td>
                    <h5><span class="orangem">[50% - 79% ]</span></h5>
                </td>
                <td>
                    <h5><span class="grenm">[80% - 100% ]</span></h5>

                </td>
                <td> 
                <button  id="imprimir"> <img src="../web/img/printButton.png" alt="" /></button>
             </td>
            </tr>
        </table>

    </div>
    <div id="cuerporeporte" style="border: 1px #002a80 solid ; padding: 1%">



    </div>
</div>