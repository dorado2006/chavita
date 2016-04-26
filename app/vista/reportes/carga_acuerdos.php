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
        var oTable1 = $('#sample-table-2').dataTable();

    });

</script>

<table id="sample-table-2" class="table table-striped  table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">
                <label>
                    <input type="checkbox" />
                    <span class="lbl"></span>
                </label>
            </th>

            <th>Cliente</th>
            <th width="9%">F-Visita</th>
            <th width="40%">Acuerdos</th>

            <th width="9%">
                F-Pago
            </th>
            <th width="7%">
                HORA
            </th>
            <th width="10%">
                <span class="glyphicon glyphicon-time" aria-hidden="true">PAGOS</span>
            </th>
            <th width="10%">
                PAGO EN:
            </th>
            <th width="10%">Personal</th>


            <th></th>
        </tr>
    </thead>

    <tbody>

        <?php
        foreach ($rows as $valor):
            ?>
            <tr>
                <td class="center">
                    <label>
                        <input type="checkbox" />
                        <span class="lbl"></span>
                    </label>
                </td>

                <td><?php echo $valor['nomcliente']; ?></td>
                <td class="hidden-480"><?php echo $valor['fecha_visita']; ?></td>
                <td class="hidden-480"><?php echo $valor['acuerdos']; ?></td>
                <td class="hidden-phone"><?php echo $valor['fecha_verificacion']; ?></td>
                <td class="hidden-phone"><?php echo $valor['hora']; ?></td>
                <td class="hidden-phone"><?php echo $valor['frecuencia_msj']; ?></td>
                <td class="hidden-phone"><?php echo $valor['pagoen']; ?></td>
                <td class="hidden-phone"><?php echo $valor['persona']; ?></td>
                <td class="td-actions">
                    <div class="hidden-phone visible-desktop action-buttons">
                        <label>
                            <input name="switch-field-1" class="ace-switch ace-switch-6" type="checkbox" <?php echo $valor['cali']; ?>>
                            <span class="lbl"></span>
                        </label>



                    </div>

                    <div class="hidden-desktop visible-phone">
                        <div class="inline position-relative">
                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-caret-down icon-only bigger-120"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                <li>
                                    <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                                        <span class="blue">
                                            <i class="icon-zoom-in bigger-120"></i>
                                        </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                        <span class="green">
                                            <i class="icon-edit bigger-120"></i>
                                        </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                        <span class="red">
                                            <i class="icon-trash bigger-120"></i>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <label>
                                        <input name="switch-field-1" class="ace-switch ace-switch-6" type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </li>

                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div id="nuevo_personal">
    <!-- En este div cargar el formulario ;para actualizar Cliente-->
</div>
