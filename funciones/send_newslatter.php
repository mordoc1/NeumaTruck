<?php

$mysql_hostname = "localhost";
$mysql_user = "neum45356_neumatruck";
$mysql_password = "7340458Tao";
$mysql_database = "neum45356_neumatruck";

$base = new PDO('mysql:host='.$mysql_hostname.'; dbname='.$mysql_database, $mysql_user, $mysql_password);
$base->exec("SET CHARACTER SET utf8");


$email = $_POST["email"];


$return = "encontrado";


$data = "";

$result = $base->query("SELECT email FROM newsletter WHERE email = '$email' LIMIT 1 ");

while($f = $result->fetch(PDO::FETCH_OBJ)){
    $data = $f->email;
}


$fecha = date("d/m/Y");

if($data == ""){
    // agregar
    $cliente_asunto         = "neumatruck.cl newsletter";

    $sql = "INSERT INTO newsletter (email, fecha) VALUES('$email', '$fecha')";
    $stmt= $base->prepare($sql);
    $stmt->execute();
 

    ob_start();
    include_once("newslatter/email.php");
    $email  = $email;

    $correo_php             = ob_get_contents();
    ob_end_clean();

    $desde                 = 'MIME-Version: 1.0' . "\r\n";
    $desde                 .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $desde                 .= "From:"."	neumatruck.cl <no-reply@neumatruck.cl>";




    // mail("mhernandez@neumachile.cl",$cliente_asunto,$correo_php,$desde);
    // mail("imorales@neumachile.cl",$cliente_asunto,$correo_php,$desde);
    mail("imorales@neumachile.cl",$cliente_asunto,$correo_php,$desde);


    $return = "ingresado";
}

$base = null;
$result->closeCursor();

echo $return;

?>