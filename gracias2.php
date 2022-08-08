<?php



require('funciones/conexion.php');

require('funciones/funciones.php');



session_start();

if(!isset($_SESSION)) {



  if(!isset($_SESSION["idunica"])){

	 $_SESSION["idunica"]  = GeneraId(15);}

}

 // lo midique

//$mysqli->query("DELETE FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' ");

//unset($_SESSION["idunica"]);



$_SESSION["idunica"]  	= GeneraId(15);



//-INFO BASICA

$url				= "Gracias";

$pmenu				= "Gracias";

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



				<h3>Gracias por su cotización</h3>

				<p>Uno de nuestros ejecutivos se contactara con usted para continuar el proceso.</p>

				<p>Gracias por su preferencia.<br><br><br></p>

				<a href="<?php echo _GetDomain; ?>" class="primary-btn order-submit"> Volver a la portada </a>

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

