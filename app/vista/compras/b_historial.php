<style>
    .ui-autocomplete .highlight {
        text-decoration: underline;
    }
  
</style>
<script>
    $(function () {

        function highlightText(text, $node) {
            var searchText = $.trim(text).toLowerCase(), currentNode = $node.get(0).firstChild, matchIndex, newTextNode, newSpanNode;
            while ((matchIndex = currentNode.data.toLowerCase().indexOf(searchText)) >= 0) {
                newTextNode = currentNode.splitText(matchIndex);
                currentNode = newTextNode.splitText(searchText.length);
                newSpanNode = document.createElement("span");
                newSpanNode.className = "highlight";
                currentNode.parentNode.insertBefore(newSpanNode, currentNode);
                newSpanNode.appendChild(newTextNode);
            }
        }
        var data = <?php echo json_encode($rows); ?>;

        $("#autocomplete1").autocomplete({
            source: data
        });
        $("#tags").autocomplete({
            source: data,
            focus: function (event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox
                $(this).val(ui.item.label);
            },
            select: function (event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox and hidden field
                $(this).val(ui.item.label);
                $("#tagsaa").val(ui.item.value);
                $.post("../web/index.php", "controller=compras&action=histor_bloque&idvendedor=" + ui.item.value, function (data) {

                    console.log(data.msg);
                    $("#mostrar_data").empty().append(data);

                });
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var $a = $("<a></a>").text(item.label);
            highlightText(this.term, $a);
            return $("<li></li>").append($a).appendTo(ul);
        };

        $(".limpiar").click(function () {
            $("#tags").val("");
            $("#tags").focus();
        });

        $(".reporte1").click(function () {
            $('.repor1').show();
        });

        $(".historial").click(function () {

        });

    });
</script>
<?php //echo"<pre>";print_r($rowst); ?>

<input type="hidden" id="idperfil" value="<?php echo $_SESSION['idperfil'] ?>">

<div class="row ">
    <div class="col-lg-1"></div>
    <div class="col-lg-11">
        <div class="panel panel-info">
<!--            <div class="panel-heading">ARQUEO DE PRODUCTOS POR VENDEDOR</div>-->
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="tags" class="col-lg-3 control-label ">BUSCAR VENDEDOR</label>

                        <div class="col-lg-5">                            
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="form-control-feedback glyphicon glyphicon-search"></i></span>
                                <input type="text" name="BUSCAR" class="form-control" id="tags" placeholder="INGRESE VENDEDOR" >
                                <span class="input-group-addon limpiar">
                                    <i class="form-control-feedback glyphicon glyphicon-remove"></i></span>


                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="ui-widget222">

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" id="mostrar_data">

                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
