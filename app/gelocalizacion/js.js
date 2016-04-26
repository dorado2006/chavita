// JavaScript Document
$(window).load(function() {
	
    });
$(document).ready(function(){
	
    $("#navmenu-v li").hover(
        function() {
            $(this).addClass("iehover");
        },
        function() {
            $(this).removeClass("iehover");
        }
        );
	  
    $("#buscar").click( function(){
        var keyword = $("#txtbuscar").val()
        buscar('juegos.php',keyword)
    });
	
    $("input.file_1").filestyle({
        image: "aplication/webroot/imgs/choose-file.jpg",
        imageheight : 23,
        imagewidth : 70,
        width : 140
    });
	  
    $('.mycarousel').jcarousel({
        vertical: true,
        scroll: 2,
        wrap: 'circular',
        auto:5
    });
	
    $('.new_empresas').jcarousel({
        vertical: true,
        scroll: 2,
        wrap: 'circular',
    });
	
    $(".checks:checked").parent().css("color","#D50000");
	
    $('.text_description').each(function(){
        var limit = $(this).attr('maxlength');
        $(this).next('.charsLeft').find('em').html(limit-$(this).val().length);
    });
    $('.text_description').keyup(function(){
        var limit = $(this).attr('maxlength');
        if($(this).val().length < limit) {
            $(this).next('.charsLeft').find('em').html(limit-$(this).val().length);
        }else{
            $(this).val($(this).val().substr(0,limit)) + $(this).next('.charsLeft').find('em').html('0');
        }
    });
	
    /*validate Num*/
    $(".input-pos-int").limitkeypress({
        rexp: /^[+]?\d*$/
    });
	
    $(".item_empresa:last").addClass("no_borde");
    ifexistcompany();
	
    function ifexistcompany(){
        if($("#quantity").val() == 0){
            $(".hider").hide();
        }else{
            $(".total_result").text($("#quantity").val());
        }
    }
	
    $(".check_empresas").click(function(){
        var total = $(".check_empresas:checked").length;
        $(".total_selecionados").text((total == 1) ? "Consultar 1 Seleccionado > " : "Consultar "+total+" Seleccionados > ");
    });
	
	$(".newgroup_fav").click(function(){
		$(this).hide();
		$(".create_group_fav").show();
	});
	$(".cancelgroup_fav").click(function(){
		$(".create_group_fav").hide();
		$(".modifica_group_fav").hide();
		$("#name_group_fav").val("");
		$("#name_group_edit").val("");
		$("#id_grupo_fav").val("");
		$(".newgroup_fav").show();
	});
	
	$("#add_group_fav").click(function(){
		if($("#name_group_fav").val() == ''){
			jAlert("Ingrese el nombre del rubro","Crear Rubro",function(){
				$("#name_group_fav").focus();
			});
			return false;
		}
		$(".vacio").remove();
		$.post("ajax.php?action=addgroup_fav",{idcliente:$("#id_cliente").val(),nombre:$("#name_group_fav").val()}, function(data){
			$(".grupos").append(data);
			$(".cancelgroup_fav").trigger("click");
		});
	});
	
	$("#update_group_fav").click(function(){
		if($("#name_group_edit_fav").val() == ''){
			jAlert("Ingrese el nombre del rubro","Crear Rubro",function(){
				$("#name_group_edit_fav").focus();
			});
			return false;
		}
		$.post("ajax.php?action=updategroup",{id:$("#id_grupo_fav").val(),nombre:$("#name_group_edit_fav").val()}, function(data){
			$(".grupos li#li"+$("#id_grupo_fav").val()).find("em").html(data);
			$(".cancelgroup_fav").trigger("click");
		});
	});
	
	$(".rubros_ofertas").click(function(){
		if($(".rubros_ofertas:checked").length > 3){
			return false;
		}
	});
	
	$(".rubros_demandas").click(function(){
		if($(".rubros_demandas:checked").length > 3){
			return false;
		}
	});
	
});

function deleteGrupo(val){
	jConfirm("Esta seguro de eliminar este grupo?<br> - Tambien se eliminaran las empresas que estan dentro de ese grupo.","Eliminar Grupo", function(b){
		if(b == true){
			$.post("ajax.php?action=deletegroup",{id:val}, function(data){
				var url_grupo = ($("#id_g").val() == val) ? '' : "&grupo="+$("#id_g").val();
				location.href = 'cuenta.php?cuenta=favoritos'+url_grupo
			});	
		}	
	});
}
function editGrupo(val){
	$(".newgroup_fav").hide();
	$(".create_group_fav").hide();
	$(".modifica_group_fav").show();
	$("#name_group_edit_fav").val($(".grupos li#li"+val).find("em").html());
	$("#id_grupo_fav").val(val);
}
function deleteEmpresaFavorito(val, grupo, cliente){
	jConfirm("Esta seguro de quitar esta empresa de este grupo?","Quitar Empresa", function(b){
		if(b == true){
			$.post("ajax.php?action=deleteEmpresagroup",{empresa:val, id_cliente:cliente, id_grupo:grupo}, function(data){
				location.href = 'cuenta.php?cuenta=favoritos&grupo='+grupo;
			});	
		}	
	});
}	
function search_enter(e) { 
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==13){
        buscar('juegos.php',document.getElementById("txtbuscar").value);
    }
    return true;
}
function buscar(url,texto){
    location.replace(url+'?q='+ texto);
}

function busqueda(url,texto){
	
    document.fbuscar.action = url+'&q=' + texto.value;
    document.fbuscar.submit();
}

function checkTheKey(keyCode){
    if(event.keyCode==13){
        valida();
        return true ;
    }
    return false ;
}

var testresults
function checkemail(value){
    var str = value
    var filter=/^.+@.+\..{2,3}$/
    if (filter.test(str))
        testresults=true
    else{
        testresults=false
    }
    return (testresults)
}



function validateSend(){
    var f1 = eval("document.login");
    if(f1.email.value == ""){
        alert("Por favor ingrese su email.");
        f1.email.focus();
        return false;
    }else if(checkemail(f1.email.value) == false){
        f1.email.focus();
        return false;
    }
}

function validateLogin(frm){
    if(frm.email.value == ""){
        jAlert('Ingrese su Email', 'Acceso',function(){
            frm.email.focus();
        });
        return false;
    }else if(checkemail(frm.email.value) == false){
        jAlert('Por favor ingrese un email valido', 'Aviso Registro',function(){
            frm.email.focus();
        });
        return false;
    }else if(frm.password.value == ""){
        jAlert('Ingrese su Contraseña', 'Acceso',function(){
            frm.password.focus();
        });
        return false;
    }
	
    $.post("ajax.php?action=acceso",{
        email:frm.email.value,
        password:frm.password.value
        }, function(data){
        if(data == 1){
            location.href='cuenta.php';
        }else if(data == 2){
            $(".msg").html("<div class='error'>- Su cuenta aun no ha sido activada, Verifique su email.</div>");
            return false;
        }else{
            $(".msg").html("<div class='error'>- El email  o la clave son incorrectos.</div>");
            return false;
        }
    });
}

function validateYobusco(frm){
    if(frm.categorie.value == ""){
        jAlert('Por favor ingrese el nombre de la categoria', 'Lo que estoy Buscando',function(){
            frm.categorie.focus();
        });
        return false;
    }
    $.post("ajaxenvio.php?action=envio_yo_busco",{
        categoria:frm.categorie.value
        }, function(data){
        openPopup('confirmacion.php',449,190,false,'&type=1');
    });
}

function validateRegistro(frm){
    if(frm.nombre.value == ""){
        jAlert('Por favor ingrese su nombre', 'Aviso Registro',function(){
            frm.nombre.focus();
        });
        return false;
    }else if(frm.apellidos.value == ""){
        jAlert('Por favor ingrese sus apellidos', 'Aviso Registro',function(){
            frm.apellidos.focus();
        });
        return false;
    }else if(frm.email.value == ""){
        jAlert('Por favor ingrese su email', 'Aviso Registro',function(){
            frm.email.focus();
        });
        return false;
    }else if(checkemail(frm.email.value) == false){
        jAlert('Por favor ingrese un email valido', 'Aviso Registro',function(){
            frm.email.focus();
        });
        return false;
    }else if(frm.password.value == ""){
        jAlert('Por favor ingrese un password', 'Aviso Registro',function(){
            frm.password.focus();
        });
        return false;
    }else if((frm.password.value).length < 6){
        jAlert('Su password debe contener minimo 6 caracteres', 'Aviso Registro',function(){
            frm.password.focus();
        });
        return false;
    }else if(frm.confirmar_password.value == ""){
        jAlert('Por favor confirme la contraseña', 'Aviso Registro',function(){
            frm.confirmar_password.focus();
        });
        return false;
    }else if(frm.password.value != frm.confirmar_password.value){
        jAlert('La confirmacion de la contraseña no es correcta', 'Aviso Registro',function(){
            frm.confirmar_password.focus();
        });
        return false;
    }else if($(".rubros_ofertas:checked").length==0 && frm.rnotificaciones.checked==true){
		
		jAlert("Elija los rubros  para recibir las últimas Ofertas de Empresas","Seleccionar",function(){
			$(".vrubros").trigger("click");	
		});
		return false;
	}else if($(".rubros_demandas:checked").length==0 && frm.rnotificaciones.checked==true){
		
		jAlert("Elija los rubros  para recibir las últimas Demandas de Empresas","Seleccionar",function(){
			$(".vrubros").trigger("click");	
		});
		
		return false;
		
	}else if(frm.terminos.checked==false){
        jAlert('Usted tiene que Aceptar los Términos y Condiciones de Oferta y Demanda', 'Aviso Registro',function(){
            frm.terminos.focus();
        });
        return false;
    }	
}
function validateEditar(frm){
    if(frm.nombre.value == ""){
        jAlert('Por favor su nombre', 'Aviso Registro',function(){
            frm.nombre.focus();
        });
        return false;
    }else if(frm.apellidos.value == ""){
        jAlert('Por favor sus apellidos', 'Aviso Registro',function(){
            frm.apellidos.focus();
        });
        return false;
    }else if(frm.password.value != "" && frm.password_anterior.value == ""){
        jAlert('Por favor ingrese su password actual', 'Aviso Registro',function(){
            frm.password_anterior.focus();
        });
        return false;
    }else if(frm.password.value != "" && frm.confirmar_password.value == ""){
        jAlert('Por favor confirme la nueva contraseña', 'Aviso Registro',function(){
            frm.confirmar_password.focus();
        });
        return false;
    }else if(frm.password.value != frm.confirmar_password.value){
        jAlert('La confirmacion de la nueva contraseña no es correcta', 'Aviso Registro',function(){
            frm.confirmar_password.focus();
        });
        return false;
    }
}

function validateEditarPassword(frm){
    if(frm.password.value == ""){
        jAlert('Por favor ingrese su nueva contraseña ', 'Editar Contraseña',function(){
            frm.password.focus();
        });
        return false;
    }else if(frm.confirmar_password.value == ""){
        jAlert('Por favor confirme la contraseña', 'Editar Contraseña',function(){
            frm.confirmar_password.focus();
        });
        return false;
    }else if(frm.password.value != frm.confirmar_password.value){
        jAlert('La confirmacion de la contraseña no es correcta', 'Editar Contraseña',function(){
            frm.confirmar_password.focus();
        });
        return false;
    }
}

function recuperarData(f1){
    if(f1.email.value == ""){
        jAlert('Por favor ingrese su E-mail.', 'Recuperar Contraseña',function(){
            f1.email.focus();
        });
        return false;
    }else if(checkemail(f1.email.value) == false){
        jAlert('Por favor ingrese un email valido', 'Recuperar Contraseña',function(){
            f1.email.focus();
        });
        return false;
    }
    $.post("ajax.php?action=rcontrasena",{
        email:f1.email.value
        }, function(data){
        if(data == 1){
            openPopup('confirmacion.php',449,190,false,'&type=2');
        }else{
            $(".msg").html("<div class='error'>- El email "+f1.email.value+" ingreado no existe en nuestro sistema.</div>");
            return false;
        }
    });
}

function openPopup(url, w, h, modo, param){
    $("#TB_window").remove();
    $("body").append("<div id='TB_window'></div>");
    tb_show("", url+"?width="+w+"&height="+h+"&modal="+modo+param, "");
}

function closePopup(){
    tb_remove(true);
}

function validateCambioEmail(frm){
    if(frm.email.value == ""){
        jAlert('Ingrese su nuevo Email', 'Cambiar Email',function(){
            frm.email.focus();
        });
        return false;
    }else if(checkemail(frm.email.value) == false){
        jAlert('Por favor ingrese un email valido', 'Cambiar Email',function(){
            frm.email.focus();
        });
        return false;
    }
    if(frm.email_confir.value == ""){
        jAlert('Repita el Email', 'Cambiar Email',function(){
            frm.email_confir.focus();
        });
        return false;
    }else if(frm.email.value != frm.email_confir.value){
        jAlert('La confirmacion del email no es valida.', 'Cambiar Email',function(){
            frm.email.focus();
        });
        return false;
    }else if(frm.password.value == ""){
        jAlert('Ingrese su Contraseña', 'Cambiar Email',function(){
            frm.password.focus();
        });
        return false;
    }
	
    $.post("ajax.php?action=cambiar_email",{
        email:frm.email.value,
        password:frm.password.value
        }, function(data){
        if(data == 1){
            location.href='cuenta.php?cuenta=perfil';
        }else{
            $(".msg").html("<div class='error'> La contraseña es incorrecta.</div>");
            return false;
        }
    });
}
function validateCambioEmailNotificacion(frm){
    if(frm.email.value == ""){
        jAlert('Ingrese su nuevo Email', 'Cambiar Email',function(){
            frm.email.focus();
        });
        return false;
    }else if(checkemail(frm.email.value) == false){
        jAlert('Por favor ingrese un email valido', 'Cambiar Email',function(){
            frm.email.focus();
        });
        return false;
    }
    if(frm.email_confir.value == ""){
        jAlert('Repita el Email', 'Cambiar Email',function(){
            frm.email_confir.focus();
        });
        return false;
    }else if(frm.email.value != frm.email_confir.value){
        jAlert('La confirmacion del email no es valida.', 'Cambiar Email',function(){
            frm.email.focus();
        });
        return false;
    }else if(frm.password.value == ""){
        jAlert('Ingrese su Contraseña', 'Cambiar Email',function(){
            frm.password.focus();
        });
        return false;
    }
	
    $.post("ajax.php?action=cambiar_email",{
        email:frm.email.value,
        password:frm.password.value
        }, function(data){
        if(data == 1){
            location.href='cuenta.php?cuenta=notificaciones';
        }else{
            $(".msg").html("<div class='error'> La contraseña es incorrecta.</div>");
            return false;
        }
    });
}

function viewLogo(response){
    $.get("ajax.php?action=img",{
        image:response,
        w:150,
        h:76
    },function(data){
        $(".logo_mi_empresa").removeClass("loading");
        $(".load_img").html(data);
    });
    $.get("ajax.php?action=img",{
        image:response,
        w:120,
        h:61
    },function(data){
        $(".photo_empresa").removeClass("loading");
        $(".load_img_left").html(data);
    });
}
function quitarLogo(){
    jConfirm('Esta seguro de quitar la imagen?', 'Aviso',function(b){
        if(b == true){
            $('.logo_mi_empresa, .photo_empresa').addClass('loading');
            $.get("ajax.php?action=quitarLogo",{},function(data){
                viewLogo('no_logo.jpg');
            });
        }
    });
}

function validateEmpresa(frm){
    var rubros = frm.elements['rubros[]'];
    var numeroChekeados = 0;
    var v = false;
	
    for(i=0;i<rubros.length;i++){
        if(rubros[i].checked==true){
            v = true;
            numeroChekeados++;
        }
    }
    if(frm.nombre.value == ""){
        jAlert('Nombre de la empresa obligatorio', 'Mi Empresa',function(){
            frm.nombre.focus();
        });
        return false;
    }else if(v == false){
        jAlert('Seleccionar por lo menos 1 Rubro.', 'Mi Empresa',function(){});
        return false;
    }else if(numeroChekeados > 3){
        jAlert('Solo se permite seleccionar maximo 3 rubros.', 'Mi Empresa',function(){});
        return false;
    }
}

function consultarSeleccionados(){
    var total = $(".check_empresas:checked").length;
    if(total == 0){
        jAlert("Seleccione algunas empresas para consultar","Consultar Empresas",function(){});
        return false;
    }
    tb_show("", "consultar_seleccionados.php?width=548&height=340", "");
	
}
function deleteDireccion(val){
    jConfirm('Esta seguro de eliminar la Dirección?', 'Eliminar',function(b){
        if(b == true){
            $.post("ajax.php?action=deleteDireccion",{
                id:val
            },function(data){
                location.href='cuenta.php?cuenta=direcciones';
            });
        }
    });
}
function consultarEmpresa(val){
    tb_show("", "consultar_una_empresa.php?width=548&height=260&param="+val+"", "");
}
function consultarOferta(val, id){
    tb_show("", "consultar_oferta.php?width=548&height=260&param="+val+"&id="+id, "");
}
function consultarDemanda(val, id){
    tb_show("", "consultar_demanda.php?width=548&height=300&param="+val+"&id="+id, "");
}
function deleteProducto(val){
    jConfirm('Esta seguro de eliminar el producto o servicio?', 'Eliminar',function(b){
        if(b == true){
            $.post("ajax.php?action=deleteProductosServicios",{
                id:val
            },function(data){
                location.href='cuenta.php?cuenta=productos_servicios';
            });
        }
    });
}
function deleteOferta(val, s){
    jConfirm('Esta seguro de eliminar la Oferta?', 'Eliminar',function(b){
        if(b == true){
            $.post("ajax.php?action=deleteOfertas",{
                id:val
            },function(data){
				var status = (s == 'no') ? '&status=no' :'';
                location.href='cuenta.php?cuenta=ofertas'+status;
            });
        }
    });
}
function statusOferta(s, val){
	if(s == 1){
		  jConfirm('Esta seguro de desactivar la Oferta?', 'Desactivar',function(b){
				if(b == true){
					$.post("ajax.php?action=statusOfertas&s=0",{
						id:val
					},function(data){
						location.href='cuenta.php?cuenta=ofertas';
					});
				}
			});
	}else{
		  jConfirm('Esta seguro de Activar la Oferta?', 'Activar',function(b){
				if(b == true){
					$.post("ajax.php?action=statusOfertas&s=1",{
						id:val
					},function(data){
						location.href='cuenta.php?cuenta=ofertas&status=no';
					});
				}
			});		
	}
}

function deleteDemanda(val, s){
    jConfirm('Esta seguro de eliminar la Demanda?', 'Eliminar',function(b){
        if(b == true){
            $.post("ajax.php?action=deleteDemandas",{
                id:val
            },function(data){
				var status = (s == 'no') ? '&status=no' :'';
                location.href='cuenta.php?cuenta=demandas'+status;
            });
        }
    });
}
function statusDemanda(s, val){
	if(s == 1){
		  jConfirm('Esta seguro de desactivar la Demanda?', 'Desactivar',function(b){
				if(b == true){
					$.post("ajax.php?action=statusDemandas&s=0",{
						id:val
					},function(data){
						location.href='cuenta.php?cuenta=demandas';
					});
				}
			});
	}else{
		  jConfirm('Esta seguro de Activar la Demanda?', 'Activar',function(b){
				if(b == true){
					$.post("ajax.php?action=statusDemandas&s=1",{
						id:val
					},function(data){
						location.href='cuenta.php?cuenta=demandas&status=no';
					});
				}
			});		
	}
}

function addTextRubros(){
	closePopup();
}
function validateNotificacion(frm){
	if($(".rubros_ofertas:checked").length==0 && frm.oferta_demanda.checked==true){
		
		jAlert("Elija los rubros  para recibir las últimas Ofertas de Empresas","Seleccionar",function(){
			$(".vrubros").trigger("click");	
		});
		return false;
	}else if($(".rubros_demandas:checked").length==0 && frm.oferta_demanda.checked==true){
		
		jAlert("Elija los rubros  para recibir las últimas Demandas de Empresas","Seleccionar",function(){
			$(".vrubros").trigger("click");	
		});
		
		return false;
	}
	
}