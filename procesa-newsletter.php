<?php
require('funciones/conexion.php');
require('funciones/funciones.php');
session_start();
if(!isset($_SESSION["idunica"])){
    header('Location:'._GetDomain);
    exit();
}
else {
    if(isset($_POST['email_newsletter']) && $_POST['email_newsletter'] !=''){
        $email_newsletter = RemoveXSS(trim($_POST['email_newsletter']));
        if($email_newsletter !=''){
            $email_news     = $mysqli->real_escape_string($email_newsletter);
            $consultanews   = $mysqli->query("SELECT * FROM newsletter WHERE email= '$email_news' LIMIT 1 ");
            $consultanewst  = $consultanews->num_rows;
            if($consultanewst >0){
                //ya existe
                $texto = "El correo ingresado ya existe en nuestros registros.";
                echo '<script>alert("'.$texto.'");</script>';
                echo '<script>history.back(1)</script>';
                exit();
            }
            else {
                //no existe
                $fecha  = date('d/m/Y');
                $mysqli->query("INSERT INTO newsletter(email,fecha) VALUES('$email_news','$fecha')");
                $mail_admin = "imorales@neumachile.cl";
                ob_start();
                $correo = $email_news;
                include 'includes/template-formulario-newsletter.php';
                $msgCliente = ob_get_contents();
                ob_end_clean();
                // enviar correo
                $cliente_asunto = "comprobante de newsletter Neumatruck.cl";
                $desde  = 'MIME-Version: 1.0' . "\r\n";
                $desde .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
                $desde .= "From:"."	Newsletter no-reply@neumatruck.cl";
                // envio correo al ADMIN
                mail($mail_admin,$cliente_asunto,$msgCliente,$desde);
                // envio correo al CLIENTE
                //mail($correo,$cliente_asunto,$msgCliente,$desde);
                $texto = "El correo ingresado se registro en nuestros sistemas exitosamente.";
                echo '<script>alert("'.$texto.'");</script>';
                echo '<script>history.back(1)</script>';
                exit();
              }
        }
    else{
      header('Location:'._GetDomain);
      exit();
    }
}
}
?>
