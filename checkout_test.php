<?php
require('funciones/conexion.php');
require('funciones/funciones.php');
require('funciones/funciones_aux.php');

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
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php echo $pagina; ?></title>

		<?php include('includes/css.php'); ?>

    </head>
	<body>

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
							<div class="form-grup">
								<input onclick="camnioRadio()" type="radio" id="radio-retro" name="gender" value="Retiro" checked>
									<label for="male">Retiro</label><br>
								<input onclick="camnioRadio()" type="radio" id="radio-despacho" name="gender" value="Despacho">
									<label for="female">Despacho</label><br>
							</div>
							<div class="form-group">
							<?php
								$regiones = select_regiones();
							?>
								<select onchange="buscar_ciudad()" class="form-control" id="controlSelect-region" disabled>
									<option selected>Región</option>
									<?php for ($i=0; $i < count($regiones); $i++) { ?>
										<option value="<?php echo $regiones[$i]["id_reg"]; ?>"><?php echo $regiones[$i]["region"]; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<select class="form-control" id="controlSelect-ciudad" disabled>
									<option selected>Ciudad</option>
								</select>
							</div>
							<div id="direccion-despacho" style="display:none" class="form-group">
								<input class="input" type="text" name="direccion" placeholder="Dirección de despacho">
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

						<button class="primary-btn btn-block ">Realizar Pago</button><br>
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
			return true;
		}
		</script>

		<script>
			function buscar_ciudad(){
				console.log("ejecnuando cambio de ciudad");
				var e = document.getElementById("controlSelect-region");
				var region = e.value;

				var ciudades = document.getElementById("controlSelect-ciudad");
				ciudades.disabled = false;
				// var length = ciudades.options.length;
				// 				for (i = length-1; i >= 0; i--) {
				// 					ciudades.options[i] = null;
				// 		}
				var parametros = { "id_region": region };
				$.ajax({
						data: parametros,
						type: "GET",
						dataType : 'json',
						url:  "funciones/cargar_ciudades.php",
						beforeSend:function(){
							console.log("buscando");
						},
						success:function(response){
							console.log("ejencuanodo demo");
							$('#controlSelect-ciudad').find('option').remove().end().append('<option value="Seleccionar">Seleccionar</option>').val('Seleccionar');
							$('#controlSelect-ciudad').find('option').end().append('<option value="Todos">Todos</option>').val('Todo');
							// apernadura.style.backgroundImage = "";
							for (var i = 0; i < response.length; i++){
								var opt = document.createElement('option');
								// opt.value = response[i].id;
								opt.value = response[i].id;
								opt.innerHTML = response[i].ciudad;
								ciudades.appendChild(opt);
							}
						}
					});
			}

			function camnioRadio(){
				if (document.getElementById('controlSelect-region').disabled == true) {
					document.getElementById("controlSelect-region").disabled = false;
					document.getElementById("direccion-despacho").style.display = "block";
				}else{
					document.getElementById('controlSelect-region').selectedIndex = 0;
					document.getElementById('controlSelect-ciudad').selectedIndex = 0;
					document.getElementById("controlSelect-region").disabled = true;
					document.getElementById("controlSelect-ciudad").disabled = true;
					document.getElementById("direccion-despacho").style.display = "none";
				}
			}

		</script>
	</body>
</html>
	<?php } else {
header('Location:index.php');
exit();
} ?>
