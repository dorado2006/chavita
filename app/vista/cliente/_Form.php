<script>
    $(function() {
        $('#frm').validate({
            rules: {
                'primer_nombre': {required: true},
                'apellido_p': {required: true},
                'apellido_m': {required: true},
                'dni': {required: true, digits: true},
                'idconvenio': {required: true},
                'correo': {email: true},
                'sexo': {required: true},
                'dir_actual': {required: true}

            },
            messages: {
                'primer_nombre': {required: 'Escriba el nombre'},
                'dni': {required: 'Ingrese el dni', digits: 'Solo números'}
            },
            //error          
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'error', // errorClass: 'help-block'
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }

        });
        $("#fecha_nacimiento").datepicker({'dateFormat': 'dd/mm/yy'});
        $("#adicional").css("display", "none");
        $("#idconvenio").change(function() {
            idconvenio = $(this).val();
            if (idconvenio == 3) {
                $("#adicional").css("display", "none");
            }
            else {
                $("#adicional").css("display", "");
                $.post('../web/index.php', 'controller=cliente&action=mostrar_grilla_convenios&idconvenio=' + idconvenio, function(data) {
                    console.log(data);
                    $("#grilla").empty().append(data);
                });
            }

        });
        $("#save").click(function() {
            primer_nombre = $("#primer_nombre").val();
            apellido_p = $("#apellido_p").val();
            apellido_m = $("#apellido_m").val();
            opener.document.getElementById('cliente').value = primer_nombre + ' ' + apellido_p + ' ' + apellido_m;
            $("#frm").submit();
            return false;
        });
        $("#cancelar").click(function() {
            window.close();
        });
    });
</script>
<div class="container-fluid">   
    <div class="row">  
        <div  class="col-sm-12 col-md-12 ">
            <div align="center">
                <form action="../web/index.php" method="post" id="frm" >
                    <input type="hidden" name="controller" value="cliente">
                    <input type="hidden" name="action" value="save">   

                    <table width="100%" border="1" cellpadding="3" cellspacing="1"  class="table table-bordered">
                        <tr>
                            <td colspan="2" align="center" class="success"><strong>CONVENIOS</strong></td>
                        </tr>
                        <tr>
                            <td width="30%">Tipo Convenio</td> 
                            <td align="center"><?php echo $tipoconvenio; ?></td>

                        </tr>
                        <tr id="adicional">
                            <td colspan="2">
                                <div id="grilla"></div>
                            </td>
                        </tr>
                    </table>
                    <div id="formul_down">
                        <table width="100%" border="0" cellpadding="3" cellspacing="1"  class="table table-bordered">
                            <tr>
                                <td colspan="4" align="center" class="success"><strong>Registro de Cliente</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Nombres</strong><br>
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group"> 
                                            <span class="input-group-addon">1er</span>
                                            <input type="text" class="form-control" placeholder="1er Nombre" name="primer_nombre" id="primer_nombre" value="<?php echo $obj['primer_nombre']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">2do</span>

                                            <input type="text" class="form-control" placeholder="2do Nombre" name="segundo_nombre" id="segundo_nombre" value="<?php echo $obj['segundo_nombre']; ?>">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr> 
                                <td colspan="4"><strong>Apellidos</strong><br>
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Paterno</span>

                                            <input type="text" class="form-control" placeholder="1er Apellido" name="apellido_p" id="apellido_p" value="<?php echo $obj['apellido_p']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Materno</span>
                                            <input type="text" name="apellido_m" class="form-control" placeholder="2do Apellido" id="apellido_m" value="<?php echo $obj['apellido_m']; ?>">
                                        </div>
                                    </div>

                                </td>                      

                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Dni</span>
                                            <input type="text" class="form-control" name="dni" id="dni" value="<?php echo $obj['dni']; ?>">             
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">     

                                            <span class="input-group-addon">Sexo</span>
                                            <select name="sexo" id="sexo"  class="form-control">
                                                <option  <?php
                                                if (empty($obj['sexo'])) {
                                                    echo "selected";
                                                }
                                                ?> >.....</option>
                                                <option value="0" <?php
                                                if ($obj['sexo'] == '0') {
                                                    echo "selected";
                                                }
                                                ?> >Masculino</option>
                                                <option value="1" <?php
                                                if ($obj['sexo'] == '1') {
                                                    echo "selected";
                                                }
                                                ?>>Femenino</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Correo</span>
                                            <input type="text" class="form-control" name="correo" id="correo" value="<?php echo $obj['correo']; ?>">         
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Fecha Nac.</span>
                                            <input type="text" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo $obj['fecha_nacimiento']; ?>">        
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Estado Civil</span>
                                            <select name="estado_civil" id="estado_civil" class="form-control" >
                                                <option>.....</option>
                                                <option value="0" <?php
                                                if ($obj['estado_civil'] == 0) {
                                                    echo "selected";
                                                }
                                                ?>>Soltero</option>
                                                <option value="1" <?php
                                                if ($obj['estado_civil'] == 1) {
                                                    echo "selected";
                                                }
                                                ?>>Casado</option>
                                                <option value="2" <?php
                                                if ($obj['estado_civil'] == 2) {
                                                    echo "selected";
                                                }
                                                ?>>Divorciado</option>
                                            </select>       
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Cant.Hijos</span>
                                            <input type="text" class="form-control" name="cant_hijos" id="cant_hijos" value="<?php echo $obj['cant_hijos']; ?>" >       
                                        </div>
                                    </div> 
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Cel 1.</span>
                                            <input type="text" class="form-control" name="telf1" id="telf1" value="<?php echo $obj['telf1']; ?>">                                           
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Cel 2.</span>
                                            <input type="text" class="form-control" name="telf2" id="telf2" value="<?php echo $obj['telf2']; ?>">                                                                                   
                                        </div>
                                    </div>     
                                </td>
                            </tr>
                            <tr>                               
                                <td colspan="4">
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Telf.Casa</span>
                                            <input type="text" class="form-control"  name="telfcasa" id="telfcasa" value="<?php echo $obj['telfcasa']; ?>">                          
                                        </div>
                                    </div>                                    
                                </td>
                            </tr>                        
                            <tr>
                                <td colspan="4">
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Direccion</span>
                                            <input type="text" class="form-control"  name="dir_actual" id="dir_actual" value="<?php echo utf8_encode($obj['dir_actual']); ?>">

                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Barrio</span>
                                            <input type="text" class="form-control" name="barrio" id="barrio" value="<?php echo $obj['barrio']; ?>">                                                                                  
                                        </div>
                                    </div>                
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div class="row">
                                    <div class="form-group col-sm-4"> 
                                        <div class="departamento" id="divDep">
                                            <label for='txtProv'><strong>Departamento</strong></label>
                                            <select name='selDep' id='selDep' class='textbox'>
                                                <option>seleccione departamento</option>
                                                <?php /*
                                                  $result = mysql_query("SELECT * FROM ubigeo_geografico WHERE codprov=0 AND coddist=0 ", $conexion);
                                                  if (!$result) {	echo mysql_error();	exit; }

                                                  $num = mysql_num_rows($result);
                                                  echo "<option value= '0'>Selecciona Departamento</option>";
                                                  //Construimos las opciones
                                                  for ($i=1; $i <= $num; $i++){
                                                  $row = mysql_fetch_array($result);
                                                  echo "<option value=".$row["coddpto"].">".$row["nombre"]."</option>";
                                                  }

                                                 */ ?></select>
                                        </div>
                                    </div> 
                                    <div class=" form-group col-sm-4"> 
                                        <div class="provincia" id="divSelProv">
                                            <label for="txtProv">Provincia</label>
                                            <select name="selProv" id="divSelProv" class="textbox">
                                                <option value="0">Selecciona Provincia</option>
                                            </select>
                                        </div> 
                                    </div>  
                                    <div class=" form-group col-sm-4"> 
                                        <div class="distrito" id="divSelDist">        
                                            <label for="txtDist">Distrito</label>
                                            <select name='selDist' class='textbox'>
                                                <option value='0'>Selecciona Distrito</option>
                                            </select>
                                        </div>
                                    </div>   
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Departamento</span>
                                            <input type="text" class="form-control" name="departamento" id="departamento" value="<?php echo $obj['departamento']; ?>">
                                        </div>
                                    </div>  
                                    <div class="form-group col-sm-6"> 
                                        <div class="input-group">
                                            <span class="input-group-addon">Codigo Cliente</span>
                                            <input type="text" class="form-control" name="idcliente" id="idcliente" value="<?php echo $obj['idcliente']; ?>" readonly disabled="">
                                        </div>
                                    </div>  



                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">                   
                                    <fieldset class="ui-corner-all" >
                                        <div align="center">
                                            <a id="save" name="save" class='btn btn-primary glyphicon glyphicon-floppy-saved'>&nbsp;<strong>Guardar</strong></a>
                                            <a id='cancelar' class='btn btn-mini btn-warning glyphicon glyphicon-remove' style="margin-left: 30px;" >&nbsp;<strong>Cancelar</strong></a>
                                        </div>
                                    </fieldset>

                                </td>
                            </tr>
                        </table>  
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>