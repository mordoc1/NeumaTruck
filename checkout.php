<?php
// AUDITORIA
require('funciones/conexion.php');
require('funciones/funciones.php');

if(!isset($_SESSION)) {
  session_start();
  if(!isset($_SESSION["idunica"])){

	 $_SESSION["idunica"]  = GeneraId(15);}

}



//-INFO BASICA

$url				= "Checkout";

$pmenu				= "Checkout";

$pagina 			= title_web($url);



$carro	= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' ");

$total	= $carro->num_rows;



if($total >0) {

	$db_total = intval(str_replace(".","",strval(carro_valoriva($_SESSION["idunica"]))));

	// if($db_total < 200000){

	// 	header("Location: carro.php");

	// }

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

							<li><a href="<?echo _GetDomain; ?>carro.php">Carro</a></li>

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

				<form class="checkout" action="procesa-carro.php" onsubmit="return checkSubmit();" method="post" enctype="application/x-www-form-urlencoded" name="pedido">



				<?php

                        if(isset($_GET['error']) && $_GET['error'] == 'datos') {

                            echo "<div class=\"alert alert-danger col-lg-12\">";

                            echo "<p>Complete todos los campos solicitados.</p>";

                            echo "</div>";

                        }

                        if(isset($_GET['error']) && $_GET['error'] == 'error') {

                            echo "<div class=\"alert alert-danger col-lg-12\">";

                            echo "<p>No podemos procesar su solicitud en este momento.</p>";

                            echo "</div>";

                        }

                        ?>



					<div class="col-md-7">

						<!-- Billing Details -->

						<div class="billing-details">

							<div class="section-title">+

                <img src="" alt="">

								<h3 class="title">Datos de Contacto</h3>

							</div>



							<div class="form-group">

								<input class="input" type="text" name="rut_empresa" placeholder="Rut" maxlength="12" pattern="\d{3,8}-[\d|kK]{1}" required>

							</div>

							<div class="form-group">

								<input class="input" type="text" name="razon_social" placeholder="Nombre" required>

							</div>

							<div class="form-group">

								<input class="input" type="email" name="email" placeholder="Email" required>

							</div>

							<div class="form-group">

								<input class="input" type="text" name="fono" placeholder="Fono" required>

							</div>

							<div class="form-group">

								<input class="input" type="text" name="contacto" placeholder="Nombre Contacto" required>

							</div>

							<div class="form-group">

								<input class="input" type="text" name="direccion" placeholder="Dirección de despacho" required>

							</div>





						</div>

						<!-- /Billing Details -->



						<!-- Order notes -->

						<div class="order-notes">

							<textarea class="input" name="mensaje" placeholder="Mensaje"></textarea>

						</div>

						<!-- /Order notes -->



					</div>



					<!-- Order Details -->

					<div class="col-md-5 order-details">

						<div class="section-title text-center">

							<h3 class="title">Resumen</h3>

						</div>

						<div class="order-summary">

							<div class="order-col">

								<div><strong>PRODUCTOS</strong></div>

								<div><strong>TOTAL</strong></div>

							</div>

							<div class="order-products">



							<?php
								require('funciones/conexion.php');
                            	$carro	= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' ");

								$total	= $carro->num_rows;



								while($row = $carro->fetch_assoc()){

									echo '<div class="order-col">';

									echo "<div> ".$row['tmp_cantidad']." x ".$row['tmp_codigo']." ".$row['tmp_nombre']." </div>";

									$total_x = $row['tmp_cantidad'] * $row['tmp_valor'];

									echo "<div>$ ".Moneda($total_x)."</div>";

									echo "</div>";

								}



            				?>

							</div>

							<hr>

							<div class="order-col">

								<div style="padding: 0 0;"><strong>SUBTOTAL</strong></div>

								<div style="padding: 0 0;"><strong>$ <?php echo carro_valor($_SESSION["idunica"]); ?></strong></div>

							</div>

							<div class="order-col">

								<div style="padding: 0 0;"><strong>IVA (19%)</strong></div>

								<div style="padding: 0 0;"><strong>$ <?php echo carro_iva2($_SESSION["idunica"]); ?></strong></div>

							</div>

							<div class="order-col">

								<div style="padding: 0 0;"><strong>TOTAL</strong></div>

								<div style="padding: 0 0;"><strong class="order-total"> $ <?php echo carro_valoriva($_SESSION["idunica"]); ?></strong></div>

							</div>



						</div>



						<button class="primary-btn btn-block order-submit btsubmit">Realizar Pago</button><br>

						<div class="text-center">

								<p style="color:#ffb03d;"><i class="fa fa-truck"></i></p>

								<p>* Despacho gratis en toda RM.</p>

								<hr>

								<p>* Despacho a otras regiones consultar con verdedor Para más información revisar <a href="despacho.php" style="color:#ffb03d;font-weight: bold;">Política de Despacho</a>.</p>

						</div>

						

					</div>



<div class="col-md-12">

	<!-- <p><br><strong>IMPORTANTE:</strong></p>

	<p></p>

	<p></p> -->

</div>





					<!-- /Order Details -->

					</form>

				</div>

				<!-- /row -->

			</div>

			<!-- /container -->

		</div>

		<!-- /SECTION -->



		<!-- FOOTER -->

		<?php include('includes/footer.php'); ?>



		<!-- previene el doble submit -->

		<script type="text/javascript">

		function checkSubmit() {

			document.getElementById("btsubmit").value = "Enviando...";

			document.getElementById("btsubmit").disabled = true;

			fbq('track', 'InitiateCheckout');

			return true;

		}

		</script>



	</body>

</html>

	<?php } else {

header('Location:index.php');

exit();

} ?>

