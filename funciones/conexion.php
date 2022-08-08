<?php


date_default_timezone_set('America/Santiago');


//CONEXIÓN
if($_SERVER['HTTP_HOST'] == "localhost:8056"){
    $mysqli = new mysqli("localhost", "root","", "neumatruck","3306");
}else{
    $mysqli = new mysqli("localhost", "neum45356_neumatruck","7340458Tao", "neum45356_neumatruck","3306");
 }


$mysqli ->query("SET time_zone = '-3:00'"); //GTM-3 para America/Santiago --


if ($mysqli->connect_errno) {
    die('('.$_SERVER['SERVER_ADDR'].') Error de Conexión (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

?>
