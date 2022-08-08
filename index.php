<?php
	// AUDITADO
	session_start();
	require('funciones/conexion.php');
	require('funciones/funciones.php');
	include 'includes/card.php';
	if(!isset($_SESSION["idunica"])){
		$_SESSION["idunica"]  = GeneraId(15);
	}
	$url						= "Portada";
	$pmenu						= "Portada";
	$pagina 					= title_web($url);

	$showHot					= showHotOferta();
	$showPopUpResponsive 		= estadoEspecial();
	$urlPopUp					= getImgNamePopUp();

	$getBanners					= getBanners();

	function lectura_marcas(){
		$marcas = array();
		array_push($marcas,
		array("marca" => "PIRELLI", "id_marcas" => 9),
		array("marca" => "MICHELIN", "id_marcas" => 13),
		array("marca" => "DUNNLOP", "id_marcas" => 20),
		array("marca" => "GOODRIDE", "id_marcas" => 3),
		array("marca" => "GALAXY", "id_marcas" =>4),
		array("marca" => "LING-LONG", "id_marcas" =>5),
		array("marca" => "WINDFORCE", "id_marcas" =>8),
		// array("marca" => "HONOUR", "id_marcas" =>10),
		// array("marca" => "BRIDGESTONE", "id_marcas" =>14),
		array("marca" => "FESITE", "id_marcas" =>16),
		array("marca" => "ONYX", "id_marcas" =>22),
		// array("marca" => "TRACMAX", "id_marcas" =>25),
		array("marca" => "SAMSON", "id_marcas" => 1)
		
		);

		return $marcas;

	}

 
	$prod1 = productos_index('Camion y Bus',8);
	$prod2 = productos_index('OTR',8);
	$prod3 = productos_index('Agricola',8);

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<?php include_once("includes/head.inc.php"); ?>
</head>
<body>
	
<?php include 'includes/body.inc.php'; ?>

<?php
	include 'includes/conx.php';
	$pop_up = 0;
	$re = mysql_query("SELECT * FROM configuracion WHERE tipo = 'pop-up' ") or die(mysql_error());
	while($f = mysql_fetch_array($re)){
		$pop_up = $f["resultado"];
	}
	mysql_close();
	if($pop_up == 1){
		?>
			<div class='container pop_up_responsive'>
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div onclick="cerrar_popup()"><i class="i-close"> <img style="width: 20px; height: auto;" src="img/close.svg"> <strong style="font-size: 17px;vertical-align: middle;"> <a href="#">Cerrar</a>   </strong> </i></div>
							<a href="ofertas.php"><img src="<?php echo 'img/'.$urlPopUp.'.jpg'; ?>" alt="" style="width:100%;"></a>
						</div>
					</div>
				</div>
			</div>
		<?php
	}
	?>
	<!-- Terminalk modal -->
	<!-- HEADER -->
	<?php include('includes/header.php'); ?>
	<!-- HEADER -->
	<?php include('includes/social.php'); ?>
	<!-- BANNER -->
	<script src="https://www.w3schools.com/lib/w3.js"></script>
	<!-- <img class="nature" src="img/2.0/banner/banner_1.jpg" width="100%"> -->
	<!-- OFERTA -->

	<!-- <a href="ofertas.php"><img class="nature" src="img/2.0/banner/ciber.webp" width="100%"></a> -->

	<?php for ($i=0; $i < count($getBanners) ; $i++) { ?>
		<?php if ($getBanners[$i]['url'] != 'no') { ?>
			<a href="ofertas.php"><img class="nature" src="<?php echo 'img/2.0/banner/'.$getBanners[$i]['img'].'.webp'; ?>" width="100%"></a>
		<?php }else{ ?>
			<img class="nature" src="<?php echo 'img/2.0/banner/'.$getBanners[$i]['img'].'.webp'; ?>" width="100%">
		<?php } ?>
	<?php } ?>

	<script>
		w3.slideshow(".nature", 4000);
	</script>
	<!-- BANNER -->
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
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h3 class="title">Nuestras Marcas</h3><hr class="amarillo">
					</div>
				</div>
				<!-- /section title -->
				<div class="col-md-12">
						<section class="customer-logos slider">
							<?php
								$marcas_demo = lectura_marcas();
								for ($i=0; $i < count($marcas_demo) ; $i++) {
									?>
									<div class="slide" style="width: 120px; margin:0 7px;"><a href="marcas.php?marca=<?php echo $marcas_demo[$i]["marca"].'&idm='.$marcas_demo[$i]["id_marcas"]; ?>" class=""> <img style="width:100%;height:auto;" src="img/<?php echo $marcas_demo[$i]["id_marcas"]; ?>.svg" alt=""> </a></div>
									<?php
								}
								?>
						</section>
						<br>
						<hr class="amarillo">
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /SECTION -->
	<!-- SECTION -->
	<div class="section index-section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h3 class="title">Camión y Bus</h3><hr class="amarillo">
					</div>
				</div>
				<!-- /section title -->
				<!-- Products tab & slick -->
				<div class="col-md-12">
					<div class="row">
						<div class="products-tabs">
							<!-- tab -->
							<div id="cam1" class="tab-pane active">
								<div class="products-slick" data-nav="#slick-nav-1">
									<?php for ($i=0; $i < count($prod1) ; $i++) { ?>
										<?php echo card_index($prod1[$i]['of'], $prod1[$i]["marca"],$prod1[$i]["media"], $prod1[$i]["aplicacion"], $prod1[$i]["stock"], $prod1[$i]["id"], $prod1[$i]["estado"], $prod1[$i]["nombre"], $prod1[$i]["codigo"], $prod1[$i]['v_oferta'],$prod1[$i]['v_publicado'], $prod1[$i]['v_lista']); ?>
									<?php } ?>
									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->
		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">OTR / INDUSTRIAL</h3>
							<hr class="amarillo">
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-2">
									<?php for ($i=0; $i < count($prod2) ; $i++) { ?>
										<?php echo card_index($prod2[$i]['of'], $prod2[$i]["marca"],$prod2[$i]["media"], $prod2[$i]["aplicacion"], $prod2[$i]["stock"], $prod2[$i]["id"], $prod2[$i]["estado"], $prod2[$i]["nombre"], $prod2[$i]["codigo"], $prod2[$i]['v_oferta'],$prod2[$i]['v_publicado'], $prod2[$i]['v_lista']); ?>
									<?php } ?>
									</div>
									<div id="slick-nav-2" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">AGRÍCOLA </h3>
							<hr class="amarillo">
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-3">	
									<?php for ($i=0; $i < count($prod3) ; $i++) { ?>
										<?php echo card_index($prod3[$i]['of'], $prod3[$i]["marca"],$prod3[$i]["media"], $prod3[$i]["aplicacion"], $prod3[$i]["stock"], $prod3[$i]["id"], $prod3[$i]["estado"], $prod3[$i]["nombre"], $prod3[$i]["codigo"], $prod3[$i]['v_oferta'],$prod3[$i]['v_publicado'], $prod3[$i]['v_lista']); ?>
									<?php } ?>
									</div>
									<div id="slick-nav-3" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->
		<?php include('includes/footer.php'); ?>
		<script>
		$(document).ready(function(){
			$('.customer-logos').slick({
				slidesToShow: 8,
				slidesToScroll: 1,
				autoplay: true,
				autoplaySpeed: 2500,
				arrows: false,
				variableWidth: true,
				dots: false,
				pauseOnHover: false,
				responsive: [{
					breakpoint: 768,
					settings: {
						slidesToShow: 4
					}
				}, {
					breakpoint: 520,
					settings: {
						slidesToShow: 3
					}
				}]
			});
		});

		<?php
		if ($pop_up == 1) {
			// que se muestre
			if ($showPopUpResponsive == 0) { ?>
				function inicioResponsive(){
				 if($(window).width() < 992){
					 }else{
						 $( document ).ready(function() {
							 $('#exampleModal').modal('toggle');
						 });
					 }
			 }
			 inicioResponsive();
			<?php }else { ?>
				$( document ).ready(function() {
					$('#exampleModal').modal('toggle');
				});
			<?php }
		}
		 ?>
		 function cerrar_popup(){
			 $('#exampleModal').modal('toggle');
		 }
		</script>

</body>
</html>

