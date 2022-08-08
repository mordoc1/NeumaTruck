<?php

include '../includes/conx.php';

$producto = array();
		$re = mysql_query("SELECT * FROM productos") or die(mysql_error());
        while($f = mysql_fetch_array($re)){
            echo $f["id"]."<br>";
          array_push($producto,array("id" => $f["id"]));
		}

for ($i=0; $i < count($producto) ; $i++) { 
    echo $producto[$i]["id"];
}

?>