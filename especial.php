<?php

session_start();

include 'funciones/conexion.php';

include 'funciones/funciones.php';

include 'funciones/funciones_aux.php';



// estas ofertas deben ser del codigo 2



$estado_oferta = diferentOferts();



if($estado_oferta != 1){



	header("Location: https://www.neumatruck.cl");

	exit;

}



	if(!isset($_SESSION["idunica"])){

		$_SESSION["idunica"]  = GeneraId(15);

	}



	$url					= $_GET['tipo-item'];

	$pmenu				= "Portada";



	$title				= getTitle();



	include 'includes/conx.php';



	$productos 		= productos_oferta();



?>

<!DOCTYPE html>

<?php



?>

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

							<li><a href="<?php echo _GetDomain; ?>"><i class="fa fa-home" aria-hidden="true"></i> Portada</a></li>

							<li><a href="javascript:void(0);"><?php echo 'OFERTAS '.$title; ?></a></li>

							<li><a href="javascript: history.go(-1)"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Regresar</a></li>

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

					<div class="col-md-12"><h2 class="titulo"><?php echo 'OFERTAS '.$title; ?></h2><hr class="amarillo"></div>

					<?php

						for ($i=0; $i < count($productos) ; $i++) {

									if($productos[$i]['of'] == 1){

										$precio = '<h4 class="product-price">$'.MonedaTruckIVA($productos[$i]['v_oferta']).' <del class="product-old-price">$'.MonedaTruckIVA($productos[$i]['v_publicado']).'</del> c/iva</h4>';

										$lblOferta = '<span class="new">'."OFERTA".'</span>';

									} else {

										$precio = '<h4 class="product-price">$'.MonedaTruckIVA($productos[$i]['v_publicado']).' c/iva</h4>';

										$lblOferta = '';

									}



							?>

							<div class="col-md-4 col-xs-6 resfiltro <?php echo 'marca'.sacarEspacions($productos[$i]["marca"]).' '.'medida'.Quitar5($productos[$i]["medidas"]);  ?>">

								<div class="product">

									<a href="<?php echo 'ficha.php?idProducto='.base64_encode($productos[$i]["id"]); ?>"><div class="product-img">

									<img src="<?php echo _GetOriginal.'productos/'.$productos[$i]['media'].'.webp'; ?>">

										<div class="product-label-oferta">

										<?php echo $lblOferta; ?>

										</div>



													<div class="product-label">

														<span class="new"><?php echo $productos[$i]['marca']; ?></span>

													</div>



									</div></a>

									<div class="product-body">

										<?php echo $productos[$i]["aplicacion"] != "" ?  '<span class="new">'.$productos[$i]["aplicacion"].'</span>':  '<br>' ?>

										<div class="product-label">

											<?php if($productos[$i]["stock"] == 0 OR $productos[$i]["estado"] == 0){ ?>

													<span class="new" style="color:green;">Consultar Stock</span>

											<?php }else{ ?>

													<br>

											<?php } ?>

										</div>

										<h3 class="product-name"><a href="<?php echo 'ficha.php?idProducto='.base64_encode($productos[$i]["id"]); ?>"><?php echo substr($productos[$i]['nombre'],0,25); ?></a></h3>



										<?php echo $precio; ?>

										<span><?php echo "COD ".$productos[$i]["codigo"]; ?></span>

									</div>

									<div class="add-to-cart">

										<?php

											if($productos[$i]["stock"] == 0 OR $productos[$i]["estado"] == 0){

												?>

													<button onclick="href_envio('<?php echo $productos[$i]['id']; ?>')" class="add-to-cart-btn2" rel="<?php echo $productos[$i]['id']; ?>">Ver</button>

													<!-- onclick="agregar_product('id','stock','estado')"  -->

												<?php

											}else{

												?>

													<button class="add-to-cart-btn agregacarro" rel="<?php echo $productos[$i]['id']; ?>"><i class="fa fa-shopping-cart"></i>Agregar Al Carro</button>

												<?php

											}

										?>

									</div>

								</div>

							</div>

								<?php

							}

						?>

							</div>

						</div>

						<!-- /aside Widget -->

					</div>



		<!-- FOOTER -->

		<?php include('includes/footer.php'); ?>

</body>

</html>

<?php

	// } else { header('Location:'._GetDomain); exit();}

?>

