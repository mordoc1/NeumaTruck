<?php
// AUDITADO
$idProdudcots = base64_decode($_GET['idProducto']);

require('funciones/conexion.php');

require('funciones/funciones.php');

require('funciones/funciones_aux.php');

session_start();

if(!isset($_SESSION)) {

  if(!isset($_SESSION["idunica"])){

	 $_SESSION["idunica"]  = GeneraId(15);}

}

if(isset($idProdudcots) && $idProdudcots !=''){

	if(is_numeric($idProdudcots)){

	$id					= $mysqli->real_escape_string(trim($idProdudcots));

	$datos				= $mysqli->query("SELECT p.id, p.codigo ,p.estado, p.nombre, p.categoria,p.stock , m.marca, p.medidas, a.id_nex, p.media, p.oferta, p.val_oferta, p.v_lista, p.v_publicado

												FROM productos AS p

												INNER JOIN marcas AS m

												ON p.marca = m.id_marcas

												INNER JOIN aplicaciones AS a

												ON p.aplicacion = a.id_nex

												WHERE p.id='$id' LIMIT 1");

	$datosTotal			= $datos->num_rows;

	if($datosTotal >0){

		$datosRow			= $datos->fetch_assoc();

		$nombre_cat			= $datosRow['categoria'];

		$id_cat				= $datosRow['categoria'];

		$pagina				= $datosRow['nombre'];

		$DESCRIPCION		= trim(Resumen($datosRow['meta_description'],180));

		if($DESCRIPCION =='' || $DESCRIPCION =='...'){

			$DESCRIPCION = 	trim(Resumen($datosRow['corta'],180));

		}

		//-INFO BASICA

		$url				= $pagina;

		$pmenu				= 'Detalle del producto';

		$pagina 			= title_web($url);

		$limite_stock = limite_busqueda();



		$st_of2 = 0;
		$st_of1 = 0;
	
		$re = mysql_query("SELECT resultado FROM configuracion WHERE tipo = 'ofertas'") or die(mysql_error());
		while($f = mysql_fetch_array($re)){
		  $st_of1 = $f['resultado'];
		}
	
	
		$re = mysql_query("SELECT resultado FROM configuracion WHERE tipo = 'of'") or die(mysql_error());
		  while($f = mysql_fetch_array($re)){
			$st_of2 = $f['resultado'];
		}
	

?>

		<!DOCTYPE html>
		<html lang="es">
		<head>
    		<?php include_once("includes/head.inc.php"); ?>
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

							<?php echo '<li><a href="'._GetDomain.'categoria/'.Url($nombre_cat).'/'.$id_cat.'">'.$nombre_cat.'</a></li>'; ?>

							<li><a href="javascript:void(0);"><?php echo $url; ?></a></li>

							<li><a href="javascript: history.go(-1)"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Regresar</a></li>

						</ul>

					</div>

				</div>

				<!-- /row -->

			</div>

			<!-- /container -->

		</div>
		<h1>demo test ivana</h1>
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

				<!-- Product main img -->

				<div class="col-md-5">

					<div id="product-main-img">

						<div class="product-preview" style="background: url('../../img/img2.png') no-repeat; background-size: cover; min-height:300px">

							<img src="<?php echo _GetOriginal.'productos/'.$datosRow['media'].'.webp'; ?>" alt="<?php echo $datosRow['nombre']; ?>">

						</div>

					</div>

					<small>* las imágenes pueden ser referenciales.</small>

				</div>

				<!-- /Product main img -->

				<!-- Product details -->

				<div class="col-md-7">

					<div class="product-details">

						<h2 class="product-name"><?php echo $datosRow['nombre']; ?></h2>



						<div>

							<?php
                                if ( $st_of1 == 1 AND $datosRow["oferta"] == 1 OR $st_of2 == 1 AND $datosRow["oferta"] == 2 ) {
									?>

										<h3 class="product-price"> $ <?php echo MonedaTruckIVA($datosRow['val_oferta']); ?><del class="product-old-price"> $ <?php echo MonedaTruckIVA($datosRow['v_lista']) ?></del> c/iva</h3>

										<h5 class=" lbl-ferta">OFERTA</h5>

									<?php
								}else{

									?>

										<h3 class="product-price"> $ <?php echo MonedaTruckIVA($datosRow['v_publicado']); ?> c/iva</h3>

										<h5>Neto: $ <?php echo MonedaTruck($datosRow['v_publicado']); ?></h5>

									<?php

								}



								?>

								<ul class="product-links" style="margin-top: 20px;">

									<li>Stock:</li>

									<li><?php echo $datosRow["stock"]; ?></li>

								</ul>

								<ul class="product-links" style="margin-top: 20px;">

									<li>Categoria:</li>

									<li><?php echo $nombre_cat; ?></li>

								</ul>

								<ul class="product-links" style="margin-top: 0px;">

									<li>Marca:</li>

									<li><?php echo $datosRow['marca']; ?></li>

								</ul>

								<ul class="product-links" style="margin-top: 0px;">

									<li>Código:</li>

									<li><?php echo $datosRow['codigo']; ?></li>

								</ul>

								<!-- APLIACION DEMO -->

								<?php if($datosRow['id_nex'] > 0){ ?>

									<ul class="product-links" style="margin-top: 0px;">

									<li>Aplicacion:</li>

									<li><th class="fuentenormal"> <img src="<?php echo 'img/aplicacion/'.$datosRow['id_nex'].".svg"; ?>" alt="" style="width:100px"></th></li>

								</ul>

								<?php } ?>

						<ul>

						<li>

							<br>

							<?php

								if($datosRow["estado"] == 0 OR $datosRow["stock"] <= $limite_stock ) {

										?>

										<div class="add-to-cart">

											<button class="add-to-cart-btn2">Consulta Stock</button>

										</div>

										<?php

								}else{

									?>

										<div class="add-to-cart">

                      <button class="add-to-cart-btn agregacarro" rel="<?php echo $datosRow['id']; ?>"><i class="fa fa-shopping-cart"></i>Agregar Al Carro2</button>
 
										</div>

									<?php

								}

							?>

						</li>

						</ul>

						<br><br>

						</div>

						<?php echo $datosRow['corta']; ?>

						<?php

                                $sqlcarro		= "SELECT * FROM tmp_carro_truck WHERE  tmp_idproducto='".$datosRow['id']."' AND tmp_idunica='".$_SESSION['idunica']."' ";

								$carro_chico	= $mysqli->query($sqlcarro);

								$total_chico	= $carro_chico->num_rows;

								//echo $mysqli->error;

								//echo $sqlcarro;

								if($total_chico >0){

									$row_chico 		= $carro_chico->fetch_assoc();

									$cantidad_form	= $row_chico['tmp_cantidad'];

									$texto			= "Actualizar Cotización";

								} else {

									$cantidad_form 	= 1;

									$texto			= "Cotizar";

								}//-if chico

						?>



						<hr>

						<ul class="product-links">

							<li>Compartir:</li>

							<li><a href="#"><i class="fa fa-facebook"></i></a></li>

							<li><a href="#"><i class="fa fa-twitter"></i></a></li>

							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>

						</ul>

					</div>

				</div>

				<!-- /Product details -->

				<!-- Product tab -->

				<div class="col-md-12">

					<div id="product-tab">

						<!-- product tab nav -->

						<ul class="tab-nav">

							<li class="active"><a data-toggle="tab" href="#tab1">Información</a></li>

							<?php if(strlen(trim($datosRow['descripcion_neumatico'])) > 15) { echo '<li><a data-toggle="tab" href="#tab2">Descripción</a></li>';} ?>

							<?php if(strlen(trim($datosRow['video'])) > 15) { echo '<li><a data-toggle="tab" href="#tab3">Video</a></li>';} ?>

							<?php if($datosRow['ficha_pdf'] !='') { echo '<li><a data-toggle="tab" href="#tab4">Ficha PDF</a></li>';} ?>

						</ul>

						<!-- /product tab nav -->

						<!-- product tab content -->

						<div class="tab-content">

							<!-- tab1  -->

							<div id="tab1" class="tab-pane fade in active">

								<div class="row">

									<div class="col-md-12">

									<table class="table">

										<tbody>

											<tr>

												<th>Aro</th>

												<th class="fuentenormal"><?php echo $datosRow['aro']; ?></th>

											</tr>

											<tr>

												<th>Medida</th>

												<th class="fuentenormal"><?php echo $datosRow['medidas']; ?></th>

											</tr>

											<tr>

												<!-- <th>Aplicación</th> -->

												<!-- <th class="fuentenormal"> <img src="" alt="" style="width:100px"></th> -->

											</tr>

											</tbody>

										</table>

									</div>

								</div>

							</div>

							<!-- /tab1  -->

						<?php if(trim($datosRow['descripcion_neumatico']) !='') { ?>

							<div id="tab2" class="tab-pane fade "><div class="row"><div class="col-md-12"><?php echo $datosRow['descripcion_neumatico']; ?></div></div></div>

						<?php } ?>

						<?php if(trim($datosRow['video']) !='') { ?>

							<div id="tab3" class="tab-pane fade "><div class="row"><div class="col-md-12"><?php echo $datosRow['video']; ?></div></div></div>

						<?php } ?>

						<?php if(trim($datosRow['ficha_pdf']) !='') { ?>

							<div id="tab4" class="tab-pane fade "><div class="row"><div class="col-md-12"><object data="<?php echo _GetOriginal.$datosRow['ficha_pdf']; ?>" width="100%" height="780"></object></div></div></div>

                        <?php } ?>

						</div>

						<!-- /product tab content  -->

					</div>

				</div>

				<!-- /product tab -->

			</div>

			<!-- /row -->

		</div>

		<!-- /container -->

	</div>

	<!-- /SECTION -->

	<!-- Section -->

	<div class="section">

		<!-- container -->

		<div class="container">

			<!-- row -->

			<div class="row">

			<hr>

				<div class="col-md-12">

					<div class="section-title text-center">

						<h3 class="title">PRODUCTOS RELACIONADOS</h3>

					</div>

				</div>

				<?php

require('funciones/conexion.php');

				$consultacamiones	= $mysqli->query("SELECT p.id, p.codigo ,p.estado, p.nombre, p.categoria,p.stock , m.marca, p.medidas, a.aplicacion, p.media, p.oferta, p.val_oferta, p.v_lista, p.v_publicado

														FROM productos AS p

														INNER JOIN aplicaciones AS a

														ON p.aplicacion = a.id_nex

														INNER JOIN marcas AS m

														ON p.marca = m.id_marcas

														WHERE p.v_publicado != 0 AND estado = 1 AND categoria = '$id_cat' ORDER BY RAND() LIMIT 4 ");

				while($consulta = $consultacamiones->fetch_assoc()){

					if($consulta['prioridad_truck']==2){

						$precio = '<h4 class="product-price">$'.MonedaTruckIVA($consulta['val_oferta']).' <del class="product-old-price">$'.MonedaTruckIVA($consulta['v_lista']).'</del> c/iva</h4>';

					} else {

						$precio = '<h4 class="product-price">$'.MonedaTruckIVA($consulta['v_publicado']).' c/iva</h4>';

					}

					?>

					<!-- product -->

					<div class="col-md-3 col-xs-6">

						<div class="product">

							<a href="<?php echo 'ficha.php?idProducto='.base64_encode($consulta["id"]); ?>">

							<div class="product-img">

								<img src="<?php echo _GetOriginal.'productos/'.$consulta['media'].'.webp'; ?>">

								<div class="product-label">

									<span class="new"><?php echo $consulta['marca']; ?></span>

								</div>

							</div>

							</a>

							<div class="product-body">

								<p class="product-category"><?php echo $consulta['aplicacion'] ?></p>

								<h3 class="product-name"><a href="<?php echo 'ficha.php?idProducto='.base64_encode($consulta["id"]); ?>"><?php echo $consulta['nombre']; ?></a></h3>

								<?php echo $precio; ?>

                <span><?php echo "COD ".$consulta["codigo"]; ?></span>

							</div>

							<div class="add-to-cart">

								<button class="add-to-cart-btn agregacarro" rel="<?php echo $consulta['id']; ?>"><i class="fa fa-shopping-cart"></i>Agregar al Carro</button>

							</div>

						</div>

					</div>

					<!-- /product -->

					<?php

					}

				?>

			</div>

			<!-- /row -->

		</div>

		<!-- /container -->

	</div>

	<!-- /Section -->

		<!-- FOOTER -->

		<?php include('includes/footer.php'); ?>

		<script>

    // $(document).ready(function() {

    //     $('#btn_agregar').click(function(e) {

    //          e.preventDefault();

		// 	$('#btn_agregar').prop('disabled', true);

		// 	var bla = $('#product-quantity').val();

		// 	window.location.href="<?php //echo GetDomain()."carrito-accion.php?idpro=".$datosRow['id']."&accion=sumform&cantidad="; ?>" + bla;

    //      });

    // });

    function maxLengthCheck(object) {

    if (object.value.length > object.maxLength)

      object.value = object.value.slice(0, object.maxLength)

  }

  function isNumeric (evt) {

    var theEvent = evt || window.event;

    var key = theEvent.keyCode || theEvent.which;

    key = String.fromCharCode (key);

    var regex = /[0-9]|\./;

    if ( !regex.test(key) ) {

      theEvent.returnValue = false;

      if(theEvent.preventDefault) theEvent.preventDefault();

    }

  }

    </script>

</body>

</html>

<?php

		} else {  header('location:'.GetDomain());}

	} else {  header('location:'.GetDomain());}

} else {  header('location:'.GetDomain());}

?>

