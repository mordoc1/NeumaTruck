<?php
///////////////////////////////////////////////////////////////////////////////////////////////////
///    DESARROLLADO POR WWW.RBWEB.CL / FRANCISCO RIVAS R.                                       ///
///////////////////////////////////////////////////////////////////////////////////////////////////
require('funciones/conexion.php');
require('funciones/funciones.php');

session_start();
if(!isset($_SESSION)) {

  if(!isset($_SESSION["idunica"])){
	 $_SESSION["idunica"]  = GeneraId(15);}
}

//-INFO BASICA
$url				= "Contacto";
$pmenu				= "Contacto";
$pagina 			= title_web($url);

?>
<!DOCTYPE html>
<html lang="es">

<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php echo $pagina; ?></title>

		<?php include('includes/css.php'); ?>

</head>

<body>
		<?php include 'includes/body.inc.php'; ?>
		<!-- HEADER -->
		<?php include('includes/header.php'); ?>
		<!-- /HEADER -->

		<?php include('includes/social.php'); ?>

		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree">
							<li><a href="<?echo _GetDomain; ?>">Portada</a></li>
							<li><a href="javascript:void(0);"><?php echo $url; ?></a></li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->

	<!-- SECTION -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">

				<div class="col-md-7">
				<?php

					if(isset($_POST['enviado']) && $_POST['enviado'] !=''){

						require 'includes/phpmailer/PHPMailerAutoload.php';

						// Details

						$system_name 	= 'Neumatruck';
						$system_email 	= "contacto@neumatruck.cl"; //email que envia mensajes desde el servidor

						// Send Email to Client
						$message = file_get_contents('includes/template-formulario-contacto.php');
						$message = str_replace('[texto_nombre]', $_POST['name'], $message);
						$message = str_replace('[texto_email]', $_POST['email'], $message);
						$message = str_replace('[texto_asunto]',$_POST['subject'], $message);
						$message = str_replace('[texto_mensaje]', $_POST['message'], $message);

						$mail = new PHPMailer;
						$mail->CharSet = "UTF-8";
						$mail->setFrom($system_email, $system_name); //quien envia
						$mail->addAddress($_POST['email'], $_POST['name']); //donde envia
						$mail->Subject = 'Copia de mensaje [NO RESPONDER] '.$system_name; //asunto
						$mail->MsgHTML($message);
						$mail->IsHTML(true);

						$mail->send();

						// Send Email to system
						$message = file_get_contents('includes/template-formulario-contacto.php');
						$message = str_replace('[texto_nombre]', $_POST['name'], $message);
						$message = str_replace('[texto_email]', $_POST['email'], $message);
						$message = str_replace('[texto_asunto]',$_POST['subject'], $message);
						$message = str_replace('[texto_mensaje]', $_POST['message'], $message);

						$mail = new PHPMailer;
						$mail->CharSet = "UTF-8";
						$mail->setFrom($system_email, $system_name);
						$mail->addAddress($system_email, $system_name);//a quien va email


						// $mail->addAddress('jmedina@neumachile.cl', 'jmedina');//a quien va email
						// $mail->addAddress('aveliz@neumachile.cl', 'aveliz');//a quien va email
						//$mail->addAddress('jortiz@neumachile.cl', 'jortiz');//a quien va email
						// $mail->addAddress('cnunez@neumachile.cl', 'cnunez');
						//$mail->addAddress('vmiranda@neumachile.cl', 'vmiranda');//a quien va email
						// $mail->addAddress('aveliz@neumatruck.cl', 'aveliz');
            // $mail->addAddress('jortiz@neumachile.cl', 'jortiz');
            $mail->addAddress('mhernandez@neumachile.cl', 'mhernandez');
            $mail->addAddress('avillegas@neumachile.cl', 'avillegas');

						$mail->AddReplyTo($_POST['email'], $_POST['name']);
						$mail->Subject = 'Consulta desde Neumatruck - '.$_POST['subject'];
						$mail->MsgHTML($message);
						$mail->IsHTML(true);

						if (!$mail->send()) {
							echo '<h3>Error al enviar</h3>';
							echo '<p>Complete todos los campos del formulario. Su mensaje no se pudo enviar.<br><br><br></p>';
							echo '<a href="javascript:history.back(1)" class="primary-btn order-submit"> Volver a intentar </a>';
						}
						else {
							echo '<h3>Consulta Enviada</h3>';
							echo '<p>Su mensaje fue enviado, le responderemos a la brevedad posible.<br><br><br></p>';
							echo '<a href="'._GetDomain.'" class="primary-btn order-submit"> Volver a la portada </a>';
						}

					} else {
						echo '<h3>Error al enviar</h3>';
						echo '<p>Complete todos los campos del formulario. Su mensaje no se pudo enviar.<br><br><br></p>';
						echo '<a href="javascript:history.back(1)" class="primary-btn order-submit"> Volver a intentar </a>';
					}


					?>
				</div>

				<!-- Order Details -->
				<div class="col-md-5">
					<div class="section-title text-center">
						<img src="img/img_contacto.jpg" class="img-responsive">
					</div>
				</div>
				<!-- /Order Details -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /SECTION -->

	<?php include('includes/footer.php'); ?>

</body>

</html>
