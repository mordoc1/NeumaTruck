<?php
// AUDITADO
require('funciones/conexion.php');

require('funciones/funciones.php');

require('funciones/funciones_aux.php');


if(!isset($_SESSION)) {

  session_start();



  if(!isset($_SESSION["idunica"])){

	 $_SESSION["idunica"]  = GeneraId(15);}

}



//-INFO BASICA

$url				= "Carro de Cotización";

$pmenu				= "Checkout";

$pagina 			= title_web($url);



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

							<li><a href="javascript:void(0);"><?php echo $url; ?></a></li>

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
				<?php
					if(isset($_GET['error']) && $_GET['error'] == 'datos') {
						echo "<div class=\"col-md-12 alert alert-danger col-lg-12\">";
						echo "<p>Complete todos los campos solicitados.</p>";
						echo "</div>";
					}
					if(isset($_GET['error']) && $_GET['error'] == 'error') {
						echo "<div class=\"col-md-12 alert alert-danger col-lg-12\">";
						echo "<p>No podemos procesar su solicitud en este momento.</p>";
						echo "</div>";
					}

					//Alerta en caso de agregar producto al carro
					if(isset($_SESSION["resultado"]) && $_SESSION["resultado"] !=''){
						echo "<div class=\"\"><div class=\"col-md-12 alert alert-success \" id=\"hastaca\"><i class=\"fa fa-thumbs-o-up\"></i> ".$_SESSION["resultado"]." &nbsp;&nbsp;</div></div><br> ";
						unset($_SESSION["resultado"]);
					} ?>

					<!-- Order Details -->
					<div class="col-md-12 order-details">
						<div class="section-title text-center">
							<h3 class="title">Resumen</h3>
						</div>
						<div class="order-summary">
							<div class="order-products">
							<?php
							require('funciones/conexion.php');
							$contador = 1;
							//Borro productos con 0 stock
							$mysqli->query("DELETE FROM tmp_carro_truck WHERE tmp_cantidad='0' AND tmp_idunica='".$_SESSION["idunica"]."' ");

							// Recudpero carro actualizado
							$carro2			   = $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."'");
							$total			   = $carro2->num_rows;

								while($carrorow = $carro2->fetch_assoc()){
									$urlProducto    = _GetDomain.'producto/'.Url($carrorow['tmp_nombre']).'/'.$carrorow['tmp_idproducto'];
									$can_stock = obtener_stock($carrorow['tmp_idproducto']); 
									// echo $can_stock;

									$foto           = Imagen($carrorow['tmp_idproducto']);
									$marca          = MarcaProducto($carrorow['tmp_idproducto']);

									$fotoProducto   = _GetOriginal.'productos/'.$foto.".webp";
									?>

										<div class="col-md-7 row">
											<div class="col-md-3 col-xs-4">
												<figure class="snip1205">
													<img src="<?php echo $fotoProducto; ?>" alt="<?php echo $carrorow['tmp_nombre']; ?>" class="img-responsive img-thumbnail"/>
													<a href="<?php echo 'ficha.php?idProducto='.base64_encode($carrorow["tmp_idproducto"]); ?>"></a>
												</figure>
											</div>

											<div class="col-md-9 col-xs-8">
												<p class="tit-prod2"> <a href="<?php echo 'ficha.php?idProducto='.base64_encode($carrorow["tmp_idproducto"]); ?>"><?php echo $carrorow['tmp_nombre']; ?></a></p>
												<p><small>Marca: <?php echo $marca; ?><br>Código: <?php echo $carrorow['tmp_codigo']; ?></small></p>
												<!-- <a>Oferta</a><br> -->
												<small><a href="<?php echo _GetDomain.'carrito-accion.php?idpro='.$carrorow['tmp_idproducto'].'&accion=remove'; ?>" class="red">Eliminar</a></small>
												</div>
										</div>

										<div class="col-md-2 col-xs-4">
											<br class="visible-xs">
											<select name="cantidad" class="form-control seleccionado" id="<?php echo 'select'.$contador;?>" rel="<?php echo $carrorow['tmp_idproducto']; ?>">
									<?php

									for ($i=1; $i <= $can_stock; $i++) {
										if($i == $carrorow['tmp_cantidad']){
											$selected = 'selected';
										}else{
											$selected ='';
										}
										echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option> ';
										if($i == 30){
											break;
										}
									}

									$total_item = $carrorow['tmp_valor'] * $carrorow['tmp_cantidad'];
									?>
										</select>
										</div>

										<div class="col-md-3 col-xs-7 quita15r">
											<br class="visible-xs">
											<span class="precio pull-right"><strong><?php echo '$'.number_format($total_item,0,'','.'); ?></strong></span><br>
										</div>
										<div class="clearfix"></div><hr>
									<?php
									$contador++;
								}
							?>

							</div>
							<div class="order-col">
								<div style="padding: 0 15px;"><strong>SUBTOTAL NETO</strong></div>
								<div style="padding: 0 30px;"><strong>$ <?php echo carro_valor($_SESSION["idunica"]); ?></strong></div>
							</div>
							<div class="order-col">
								<div style="padding: 0 15px;"><strong>IVA (19%)</strong></div>
								<div style="padding: 0 30px;"><strong>$ <?php echo carro_iva2($_SESSION["idunica"]); ?></strong></div>
							</div>
							<div class="order-col">
								<div style="padding: 0 15px;"><strong>TOTAL</strong></div>
								<div id="total_carro" style="padding: 0 30px;"><strong class="order-total"> $ <?php echo carro_valoriva($_SESSION["idunica"]); ?></strong> c/iva</div>
							</div>
						</div>
	  					<?php if($total >0){ ?>
            <div class="row">

              <a href="checkout.php" class="primary-btn pull-right order-submit" style="margin: 0 30px;">Continuar</a>

            </div>

						<?php } ?>



<div class="col-md-12">

	<!-- <p><strong>IMPORTANTE:</strong></p> -->

	<p></p>

	<p></p>

</div>



						<div class="clearfix"></div>

					</div>

					<!-- /Order Details -->

				</div>

				<!-- /row -->

			</div>

			<!-- /container -->

		</div>

		<!-- /SECTION -->



		<!-- FOOTER -->

		<?php include('includes/footer.php'); ?>



		<script type="text/javascript">



		$('.seleccionado').change(function(){



			var referencia		= $(this).attr('rel'); //id del elemento

			var bla             = $(this).val(); //cantidad seleccionada



			window.location.href="<?php echo _GetDomain; ?>carrito-accion.php?idpro="+referencia+"&accion=sumform&cantidad=" + bla;



		});

		</script>

		<script>

			function verificar_total(){

				// var total = document.getElementById("total_carro").innerHTML;

				// var limpiar = total.replace('<strong class="order-total"> $ ',"").replace("</strong> c/iva","").replace(".","").replace(" ","");

				// var valor = Number.parseInt(limpiar);

				// console.log(valor);

				// if(valor < 200000){

				// 	Swal.fire('Error, para continuar la Compra Mínima $200.000.-','','error');

				// }else{

					window.location.href = "checkout.php";

				// }

				// return false;



			}

		</script>

	</body>

</html>

