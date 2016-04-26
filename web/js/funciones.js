function popup(url, width, height) {
    cuteLittleWindow = window.open(url, "littleWindow", "location=no,width=" + width + ",height=" + height + ",top=80,left=300,scrollbars=yes");
}

$(function() {
    $("#reductor").click(function() {
        $("#cabecera").slideToggle("slow");
    });
    $.post('../web/index.php', 'controller=index&action=crear_menu', function(data) {
        console.log(data);
        $("#menu_iz").empty().append(data);
    });
     jQuery.fn.informar = function(msj) {
        $("#dialog-1").empty().append(msj);
        $("#dialog-1").dialog("open");
    };
    $("#dialog-1").dialog({
        autoOpen: false, width: 300,
        buttons: [
            {
                text: "Ok",
                click: function() {
                    $(this).dialog("close");
                }
            }
        ],
        height: 200
    });
});