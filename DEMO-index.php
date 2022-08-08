<?php
	session_start();
	require('funciones/conexion.php');
	require('funciones/funciones.php');
	if(!isset($_SESSION["idunica"])){
		$_SESSION["idunica"]  = GeneraId(15);
	}
	//echo '<pre>'.var_dump($_SESSION).'</pre>';
	//echo '<pre>'.var_dump($_GET).'</pre>';
	//exit();
	//-INFO BASICA
	$url				= "Portada";
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
	<!-- Smartsupp Live Chat script -->
	<script type="text/javascript">
		var _smartsupp = _smartsupp || {};
		_smartsupp.key = '1282424d565fce81924ea423549a605314e60f03';
		window.smartsupp||(function(d) {
		var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
		s=d.getElementsByTagName('script')[0];c=d.createElement('script');
		c.type='text/javascript';c.charset='utf-8';c.async=true;
		c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
		})(document);


	</script>
</head>
<body>
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
			<div class='container'>
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<a href="ofertas.php"><img src="img/pop-up.jpg" alt=""></a> 
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
	<!-- <img class="nature" src="img/2.0/banner/banner_1.jpg" width="100%">0 -->
	<img class="nature" src="img/2.0/banner/banner_2.jpg" width="100%">
	<img class="nature" src="img/2.0/banner/banner_3.jpg" width="100%">
	<img class="nature" src="img/2.0/banner/banner_4.jpg" width="100%">
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
								include 'includes/conx.php';
								$re = mysql_query("SELECT * FROM marcas WHERE activo = 1") or die(mysql_error());
								while($f = mysql_fetch_array($re)){
									?>
										<div class="slide"><a href="marcas.php?marca=<?php echo $f["nombre"]; ?>" class="primary-btn"><?php echo $f["nombre"]; ?></a></div>
									<?php
								}
								mysql_close();
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
	<div class="section">
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
									<?php
									$consultacamiones	= $mysqli->query("SELECT * FROM productos WHERE estado = 1 AND categoria = 'Camion y Bus' ORDER BY RAND() LIMIT 8" );
									while($consulta = $consultacamiones->fetch_assoc()){
										if($consulta['oferta']==1){
											$precio = '<h4 class="product-price">$'.MonedaTruckIVA($consulta['val_oferta']).' <del class="product-old-price">$'.MonedaTruckIVA($consulta['v_publicado']).'</del> c/iva</h4>';
											$lblOferta = '<span class="new">'."OFERTA".'</span>';
										} else {
											$precio = '<h4 class="product-price">$'.MonedaTruckIVA($consulta['v_publicado']).' c/iva</h4>';
											$lblOferta = '';
										}
										echo '
										<!-- product -->
										<div class="product">
											<div class="product-img">
											<a href="ficha.php?idProducto='.base64_encode($consulta["id"]).'"><img src="'._GetDomain.'productos/'.$consulta['media'].'.jpg'.'">
												<div class="product-label-oferta">
														'.$lblOferta.'
														</div>
												<div class="product-label">
													<span class="new">'.$consulta['marca'].'</span>
												</div>
											</div></a>
											<div class="product-body">
												<p class="product-category">'.$consulta['aplicacion'].' &nbsp;</p>
												<h3 class="product-name"><a href="ficha.php?idProducto='.base64_encode($consulta["id"]).'">'.$consulta['nombre'].'</a></h3>
												'.$precio.'
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn agregacarro" rel="'.$consulta['id'].'"><i class="fa fa-shopping-cart"></i>Agregar al Carro</button>
											</div>
										</div>

										<!-- /product -->
										';
									}
									?>
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
									<?php
										$consultacamiones	= $mysqli->query("SELECT * FROM productos WHERE estado = 1 AND categoria = 'Industrial' ORDER BY RAND() LIMIT 8" );
										while($consulta = $consultacamiones->fetch_assoc()){
											if($consulta['oferta']==1){
												$precio = '<h4 class="product-price">$'.MonedaTruckIVA($consulta['val_oferta']).' <del class="product-old-price">$'.MonedaTruckIVA($consulta['v_publicado']).'</del> c/iva</h4>';
												$lblOferta = '<span class="new">'."OFERTA".'</span>';
											} else {
												$precio = '<h4 class="product-price">$'.MonedaTruckIVA($consulta['v_publicado']).' c/iva</h4>';
												$lblOferta = '';
											}
											echo '
											<!-- product -->
											<div class="product">
												<div class="product-img">
													<a href="ficha.php?idProducto='.base64_encode($consulta["id"]).'"><img src="'._GetDomain.'productos/'.$consulta['media'].'.jpg'.'">
													<div class="product-label-oferta">
														'.$lblOferta.'
													</div>
													<div class="product-label">
														<span class="new">'.$consulta['marca'].'</span>
													</div>
												</div></a>
												<div class="product-body">
													<p class="product-category">'.$consulta['aplicacion'].' &nbsp;</p>
													<h3 class="product-name"><a href="ficha.php?idProducto='.base64_encode($consulta["id"]).'">'.$consulta['nombre'].'</a></h3>
													'.$precio.'
												</div>
												<div class="add-to-cart">
													<button class="add-to-cart-btn agregacarro" rel="'.$consulta['id'].'"><i class="fa fa-shopping-cart"></i>Agregar al Carro</button>
												</div>
											</div>
											<!-- /product -->
											';
										}
										?>
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
									<?php
										$consultacamiones	= $mysqli->query("SELECT * FROM productos WHERE estado = 1 AND categoria = 'Agricola' ORDER BY RAND() LIMIT 8" );
										while($consulta = $consultacamiones->fetch_assoc()){
											if($consulta['oferta']==1){
												$precio = '<h4 class="product-price">$'.MonedaTruckIVA($consulta['val_oferta']).' <del class="product-old-price">$'.MonedaTruckIVA($consulta['v_publicado']).'</del> c/iva</h4>';
												$lblOferta = '<span class="new">'."OFERTA".'</span>';
											} else {
												$precio = '<h4 class="product-price">$'.MonedaTruckIVA($consulta['v_publicado']).' c/iva</h4>';
												$lblOferta = '';
											}
											echo '
											<!-- product -->
											<div class="product">
												<div class="product-img">
													<a href="ficha.php?idProducto='.base64_encode($consulta["id"]).'"><img src="'._GetDomain.'productos/'.$consulta['media'].'.jpg'.'">
													<div class="product-label-oferta">
														'.$lblOferta.'
													</div>
													<div class="product-label">
														<span class="new">'.$consulta['marca'].'</span>
													</div></a>
												</div>
												<div class="product-body">
													<p class="product-category">'.$consulta['aplicacion'].' &nbsp;</p>
													<h3 class="product-name"><a href="ficha.php?idProducto='.base64_encode($consulta["id"]).'">'.$consulta['nombre'].'</a></h3>
													'.$precio.'
												</div>
												<div class="add-to-cart">
													<button class="add-to-cart-btn agregacarro" rel="'.$consulta['id'].'"><i class="fa fa-shopping-cart"></i>Agregar al Carro</button>
												</div>
											</div>
											<!-- /product -->
											';
										}
										?>
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

		$( document ).ready(function() {
			$('#exampleModal').modal('toggle')
		});

		</script>
</body>
</html>
