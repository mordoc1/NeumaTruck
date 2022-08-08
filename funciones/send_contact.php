<?php
$mysql_hostname = "localhost";
$mysql_user = "neum45356_neumatruck";
$mysql_password = "7340458Tao";
$mysql_database = "neum45356_neumatruck";

$base = new PDO('mysql:host='.$mysql_hostname.'; dbname='.$mysql_database, $mysql_user, $mysql_password);
$base->exec("SET CHARACTER SET utf8");


$name = strtolower($_POST['name']);
$email = strtolower($_POST['email']);
$asunto = strtolower($_POST['asunto']);
$text = strtolower($_POST['text']);

$state_foto = $_POST["name_foto"] == "" ? False: True;

$phone = $_POST['phone'];

// BUSCAR EMAIL correo
$correos = array();

$result = $base->query("SELECT contador, email FROM configuracion_email_contacto");

while($f = $result->fetch(PDO::FETCH_OBJ)){
    array_push($correos, array("contador" => $f->contador, "email" => $f->email));
}

$maximo = count($correos);

//SELECIONAR CONTADOR
$contador_correo = 1;

$result = $base->query("SELECT resultado FROM configuracion WHERE tipo = 'contador_email' ");
$row    = $result->fetch(PDO::FETCH_NUM);

$contador_correo    = intval($row[0]);



$email_select = $correos[($contador_correo - 1)]["email"];

$id_saving =        $contador_correo;

if($contador_correo == $maximo){
    $stmt = $base->prepare("UPDATE configuracion SET resultado = '1' WHERE tipo = 'contador_email' ");
    $stmt->execute();
}else{
    $contador_correo = $contador_correo + 1;
    $stmt = $base->prepare("UPDATE configuracion SET resultado = '$contador_correo' WHERE tipo = 'contador_email' ");
    $stmt->execute();
}

$sql2 = "INSERT INTO contacto_email (id_email, nombre, email, telefono, asunto, `text`) VALUE('$id_saving', '$name', '$email', '$phone', '$asunto', '$text')";
$stmt= $base->prepare($sql2);
$stmt->execute();
$stmt->closeCursor();


// ENVIAR MENSAJE
$cliente_asunto         = "neumatruck.cl contacto";

ob_start();
include_once("contacto/email.php"); 

$base = null;
$result->closeCursor();
$year = date("Y");
$name = $name;
$email = $email;
$asunto = $asunto;
$text = $text;
$phone = $phone;
$state_foto = $state_foto;
$extencion = $state_foto == ""? False : substr($state_foto, -3);

$correo_php             = ob_get_contents();
ob_end_clean();

$desde                 = 'MIME-Version: 1.0' . "\r\n";
$desde                 .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
$desde                 .= "From:"."	neumatruck.cl <no-reply@neumatruck.cl>";

// mail("luis.olave.carvajal@gmail.com",$cliente_asunto,$correo_php,$desde);
mail("mhernandez@neumachile.cl",$cliente_asunto,$correo_php,$desde);
mail($email_select,$cliente_asunto,$correo_php,$desde);
mail("aolave@neumachile.cl",$cliente_asunto,$correo_php,$desde);


echo "enviado";

?>