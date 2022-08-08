<?php

$link = mysql_connect("localhost", "neum45356_neumatruck", "7340458Tao");
mysql_select_db("neum45356_neumatruck",$link) OR DIE ("Error: No es posible establecer la conexión");
mysql_set_charset('utf8');
//
$mas_vendidso = array();
$re = mysql_query("SELECT * FROM productos WHERE media = 'no' ") or die(mysql_error());
while($f = mysql_fetch_array($re)){
  $codigo = $f["codigo"];
  mysql_query("UPDATE productos SET media = '$codigo' WHERE codigo = '$codigo' ");
  //echo $f["id"]."><<<<"."<br>";
}
mysql_close();
echo "termino"."<br>";
//
// echo $_SERVER['SERVER_ADDR']."<br>";
// echo $_SERVER['HTTP_HOST']."<br>";
// echo "FECHA"."<br>";
// echo date("Y-n-j H:i:s");

 ?>
