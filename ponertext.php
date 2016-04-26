<html>
<head>
</head>
<body>
<script language = "Javascript">

function ivatotal() {
var subtotal = event.srcElement.value
var iva = Math.round(subtotal*.15*100)/100
var total = Math.round(subtotal*1.15*100)/100
document.form2.fac_iva.value=iva
document.form2.fac_total.value=total
}
</script>
<script>
function add_row(campo)
{
cadena="";
total=campo.options[campo.selectedIndex].value;
for(i=1;i<=total;i++)
cadena=cadena+'<input type="text" name="campo_'+i+'" /> <input type="text" name="campo1_'+i+'" /> <input type="text" name="campo2_'+i+'" /> <input type="text" name="campo3_'+i+'" /> <input type="text" name="campo4" id="campo4" value="9"  onChange="javascript:sumarImporte();"/><br>';
document.getElementById('campos').innerHTML = cadena;
}
function suma()
{
suma = suma + sumadecajas
document.getElementById('campo4').value= sumadecajas
}
function sumarImporte() {
 var total_importe = 0;
 if (document.form2.campo4) {
  if (document.form2.campo4.length) {
   for (var i=0; i < document.form2.campo4.length; i++) {
    total_importe += parseInt(document.form2.campo4[i].value,10); //Validar si es un numero primero
   }
  } else {
   total_importe += parseInt(document.form2.campo4.value,10);
  }
 }
 document.getElementById('fac_subtotal').value = total_importe;
}
</script>
<p>
<div>
</p>
<table width="100%" height="128" border="0" bordercolor="#FFFFFF">
<tr>
<td colspan="3" scope="col"><form id="form1" name="form1" method="post" action="">
<label></label>
<table width="100%" border="0">
<tr>
<td width="12%" scope="col"><div align="left"><strong>N</strong><strong>o. cliente:</strong></div></td>
<td width="29%" scope="col">cli</td>
<td width="17%" scope="col"><div align="left"><strong>Nombre del cliente:</strong></div></td>
<td width="42%" scope="col">dom</td>
</tr>
<tr>
<td><strong>Domicilio:</strong></td>
<td>dom</td>
<td><strong>Ciudad:</strong></td>
<td>ciu</td>
</tr>
<tr>
<td><label><strong>Telefono:</strong></label></td>
<td><label>tel/label></td>
<td><strong>R.F.C :</strong>
<label></label></td>
<td>rfc</td>
</tr>
</table>
</form></td>
</tr>
<tr>
<td colspan="3"><form action="" method="post" name="form2">
<table width="100%" border="0">
<tr>
<th width="493" scope="col"><div align="left">
<select name="opciones" onchange="add_row(this)">
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
</select>
<em> * indica cantidad de ojetos</em></div></th>
</tr>
<tr>
<td><table width="790" border="1" bordercolor="#7F9DB9">
<tr>
<th width="146" height="23" scope="col">cantidad</th>
<th width="151" scope="col">unidad</th>
<th width="155" scope="col">descripcion</th>
<th width="155" scope="col">p unitario</th>
<th width="143" scope="col">importe</th>
</tr>
</table>
<div id="campos"></div></td>
</tr>
<tr>
<td height="140">
    <table width="793" border="0">
<tr>
<th width="26" rowspan="3" scope="col">&nbsp;</th>
<th width="429" scope="col">importe con letra:
<label></label></th>
<th width="324" scope="col"><div align="right">
<label></label>
subtotal:
<input type="text" name="fac_subtotal" id="fac_subtotal" readonly="true" />
</div></th>
</tr>
<tr>
<th width="429" scope="col"><input name="textfield4" type="text" id="textfield4" size="60" /></th>
<th scope="col"><label> </label>
<div align="right">iva:
<input type="text" name="fac_iva" id="textfield2" />
</div>
<div align="right"></div></th>
</tr>
<tr>
<th width="429" scope="col">&nbsp;</th>
<th scope="col"><label> </label>
<div align="right">total:
<input type="text" name="fac_total" id="textfield3" />
</div></th>
</tr>
<tr>
<th width="26" scope="col">&nbsp;</th>
<th width="429" scope="col">&nbsp;</th>
<th scope="col"><div align="right">
<input name="enviar" type="button" value="Enviar" onClick="javascript:sumarImporte();" />
</div></th>
</tr>
</table>
<div align="right"></div></td>
</tr>
</table>
<label> </label>
<p align="right">
<label></label>
<label></label>
</p>
</form></td>
</tr>
<tr>
<td width="36%"><a href="busqueda_cliente.php"><img src="objetos/flecha_re.gif" width="22" height="22" border="0" /></a></td>
<td width="21%" bordercolor="#000000"><a href="index.php">MENU PRINCIPAL</a></td>
<td width="43%">&nbsp;</td>
</tr>
</table>

</body>
</html>