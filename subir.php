<?php
include("connect.php");
$row = 1; 
$handle = fopen("productos1.csv", "r"); 
$micolumna = array(); 
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { 
$num = count($data); 
echo "<p> $num fields in line $row: <br /></p>\n"; 
$db="UPDATE productos SET precio='".$data[$c]."' WHERE producto_id='".$row."'";
mysql_query($db) or die(mysql_error());
$row++; 
for ($c=0; $c < $num; $c++) { 
echo $data[$c] . "<br />"; 
} 
$micolumna[] = $data[1]; 
} 
fclose($handle); 
var_dump ($micolumna); 
unset ($data);
?>