<?php

date_default_timezone_set('America/Santiago');

//CONEXIÓN

if($_SERVER['HTTP_HOST'] == "localhost"){
    $mysqli = new mysqli("localhost", "root","", "neumatruck","3306");
}else{
    $mysqli = new mysqli("localhost", "neum45356_neumatruck","7340458Tao", "neum45356_neumatruck","3306");
 }

$mysqli ->query("SET time_zone = '-3:00'"); //GTM-3 para America/Santiago --

if ($mysqli->connect_errno) {
    die('('.$_SERVER['SERVER_ADDR'].') Error de Conexión (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

if($_SERVER['HTTP_HOST'] == "localhost"){
    $mysql_hostname = "localhost";
    $mysql_user = "root";
    $mysql_password = "";
    $mysql_database = "neumaequipos";
    // $link = mysqli_connect("localhost", "root", "");
    // mysql_select_db("rotem",$link) OR DIE ("Error: No es posible establecer la conexión");
    // mysql_set_charset('utf8');
    $mysqli = new mysqli($mysql_hostname, $mysql_user, $mysql_password,$mysql_database) or die("Error: No es posible establecer la conexión");
    $mysqli->set_charset("utf8");
}else{
    $mysql_database = "neum68927_neumaequipos";
    $mysql_hostname = "localhost";
    $mysql_user = "neum68927_taoista";
    $mysql_password = "7340458Tao";
    $mysqli = new mysqli($mysql_hostname, $mysql_user, $mysql_password,$mysql_database) or die("Error: No es posible establecer la conexión");
    $mysqli->set_charset("utf8");
}

?>

