<?php



require('funciones/conexion.php');

require('funciones/funciones.php');



session_start();

if(!isset($_SESSION)) {



	if(!isset($_SESSION["idunica"])){

		$_SESSION["idunica"]  = GeneraId(15);}

	}



if(isset($_GET['idMarca']) && $_GET['idMarca'] !='' && is_numeric($_GET['idMarca']) ){



	$idMarca		= $mysqli->real_escape_string($_GET['idMarca']);

	$nombremarca	= Marcas($idMarca);



	//-INFO BASICA

	$url				= $nombremarca;

	$pmenu				= "Portada";

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

							<li><a href="<?php echo _GetDomain; ?>">Portada</a></li>

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



					<?php

					//Alerta en caso de agregar producto al carro

					if(isset($_SESSION["resultado"]) && $_SESSION["resultado"] !=''){

						echo "<div class=\"col-md-12\"><div class=\" alert alert-success \" id=\"hastaca\"><i class=\"fa fa-thumbs-o-up\"></i> ".$_SESSION["resultado"]." &nbsp;&nbsp;<a href=\"". _GetDomain ."carro.php\" class=\"pull-right\"><strong><i class=\"fa fa-shopping-bag\"></i> Ver carrito</strong></a></div></div> ";

						unset($_SESSION["resultado"]);

					} ?>



					<div class="col-md-12"><h2 class="titulo"><?php echo $url; ?></h2><hr class="amarillo"></div>





					<!-- STORE -->

					<div id="store" class="col-md-12">



						<!-- store products -->

						<div class="row">





						<?php

							// $consultacamiones	= $mysqli->query("

							// SELECT productos.id,productos.nombre,productos.precio,productos.oferta_truck,productos.media,productos.aplicacion, productos.prioridad_truck, productos.marca, marcas.nombre AS nombremarca

							// FROM productos

							// INNER JOIN marcas

							// ON productos.marca=marcas.id

							// WHERE productos.marca = '$idMarca'

							// AND productos.categoria IN (SELECT id FROM categorias WHERE dependencia=5 AND id !=8 AND id !=180 AND id !=10)

							// AND productos.stock= '1'

							// AND productos.activo='1'

							// AND productos.neumatruck='1'

							// ");



							$consultacamiones = $mysqli->query("SELECT * FROM productos WHERE marca = '$nombremarca' AND  stock = 1 AND estado = 1");



							while($consulta = $consultacamiones->fetch_assoc()){

								if($consulta['oferta']==1){



									$precio = '<h4 class="product-price">$'.MonedaTruckIVA($consulta['val_oferta']).' <del class="product-old-price">$'.MonedaTruckIVA($consulta['v_publicado']).'</del> c/iva</h4>';

								} else {

									$precio = '<h4 class="product-price">$'.MonedaTruckIVA($consulta['v_publicado']).' c/iva</h4>';

								}



								echo '

								<!-- product -->

								<div class="col-md-3 col-xs-6 resfiltro marca'.$consulta['marca'].'">

									<div class="product">

										<div class="product-img">

											<img src="'._GetOriginal.$consulta['media'].'">

											<div class="product-label">

												<span class="new">'.$consulta['marca'].'</span>

											</div>

										</div>

										<div class="product-body">

											<p class="product-category">'.$consulta['aplicacion'].' &nbsp;</p>

											<h3 class="product-name"><a href="'._GetDomain.'producto/'.Url($consulta['nombre']).'/'.$consulta['id'].'">'.$consulta['nombre'].'</a></h3>

											'.$precio.'

										</div>

										<div class="add-to-cart">

											<button class="add-to-cart-btn agregacarro" rel="'.$consulta['id'].'"><i class="fa fa-shopping-cart"></i>Cotizar</button>

										</div>

									</div>

								</div>

								<!-- /product -->

								';



							}



						?>





						</div>

						<!-- /store products -->





					</div>

					<!-- /STORE -->

				</div>

				<!-- /row -->

			</div>

			<!-- /container -->

		</div>

		<!-- /SECTION -->



		<!-- FOOTER -->

		<?php include('includes/footer.php'); ?>



</body>



</html>

<?php

} else { header('Location:'._GetDomain); exit();}

