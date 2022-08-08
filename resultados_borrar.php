<?php
	session_start();
	require('funciones/funciones_aux.php');
	if(!isset($_SESSION["idunica"])){
		$_SESSION["idunica"]  = GeneraId2(15);}

	if(isset($_GET['tipo-item']) && $_GET['tipo-item'] !=''){
	// $buscar					= $mysqli->real_escape_string(trim(RemoveXSS($_POST['tipo-item'])));
	//-INFO BASICA
	$url				= $_GET['tipo-item']; // => palabra de busqueda => buscar
	$pmenu				= "Portada";

	require('includes/conx.php');

	$filtro_busqueda = str_replace(" ","",str_replace(str_split("/-.+-"), '', $url));
	$busqueda = "%".$filtro_busqueda."%";

	$marcas = busqueda_nav_marcas($busqueda);
	$medidas = busqueda_nav_medida($busqueda);

	$productos = busqueda_productos($busqueda);
	$limite_stock = limite_busqueda();


    mysql_close();

?>
<!DOCTYPE html>
<?php
	require('funciones/conexion.php');

	require('funciones/funciones.php');
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
							<li><a href="javascript:void(0);">Resultados de Busqueda</a></li>
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
					if(isset($_SESSION["resultado"]) && $_SESSION["resultado"] !=''){
						echo "<div class=\"col-md-12\"><div class=\" alert alert-success \" id=\"hastaca\"><i class=\"fa fa-thumbs-o-up\"></i> ".$_SESSION["resultado"]." &nbsp;&nbsp;<a href=\"". _GetDomain ."carro.php\" class=\"pull-right\"><strong><i class=\"fa fa-shopping-bag\"></i> Ver carrito</strong></a></div></div> ";
						unset($_SESSION["resultado"]);
					} ?>
					<div class="col-md-12"><h2 class="titulo">Resultados para: <?php echo $url; ?></h2><hr class="amarillo"></div>
					<!-- ASIDE -->
					<div id="aside" class="col-md-3">
						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Marcas</h3>
							<div class="checkbox-filter">
							<?php
								for ($i=0; $i < count($marcas) ; $i++) {
									?>
										<div class="input-checkbox">
											<input type="checkbox" name="filtro_marca" value="<?php echo "marca".sacarEspacions($marcas[$i]["marca"]); ?>" class="filtroxmarca">
											<label for="<?php echo $marcas[$i]["marca"] ?>"><?php echo $marcas[$i]["marca"]; ?></label>
										</div>
									<?php
								}
							?>
							</div>
							<h3 class="aside-title">Medidas</h3>
							<div class="checkbox-filter">
							<?php
								for ($i=0; $i < count($medidas) ; $i++) {
									?>
								<div class="input-checkbox">
									<input type="checkbox" name="filtro_marca" value="<?php echo "medida".Quitar5($medidas[$i]["medidas"]); ?>" class="filtroxmarca">
									<label for="<?php echo $medidas[$i]["medidas"] ?>"><?php echo $medidas[$i]["medidas"]; ?></label>
								</div>
									<?php
								}
							?>
							</div>
						</div>
						<!-- /aside Widget -->
					</div>
					<!-- /ASIDE -->
					<!-- STORE -->
					<div id="store" class="col-md-9">
						<!-- store products -->
						<div class="row">
						<!-- INICIO DEL RESPLADP -->
							<?php
								if(count($productos) > 0){
									for ($i=0; $i < count($productos) ; $i++) {
										if($productos[$i]['of']==1){
											$precio = '<h4 class="product-price">$'.MonedaTruckIVA($productos[$i]['v_oferta']).' <del class="product-old-price">$'.MonedaTruckIVA($productos[$i]['v_publicado']).'</del> c/iva</h4>';
											$lblOferta = '<span class="new">'."OFERTA".'</span>';
										} else {
											$precio = '<h4 class="product-price">$'.MonedaTruckIVA($productos[$i]['v_publicado']).' c/iva</h4>';
											$lblOferta = '';
										}
										?>
											<!-- product -->
											<div class="col-md-4 col-xs-6 resfiltro <?php echo 'marca'.sacarEspacions($productos[$i]["marca"]).' '.'medida'.Quitar5($productos[$i]["medidas"]);  ?>">
												<div class="product">
													<a href="<?php echo 'ficha.php?idProducto='.base64_encode($productos[$i]["id"]); ?>"><div class="product-img">
													<img src="<?php echo _GetOriginal.'productos/'.$productos[$i]['media'].'.jpg'; ?>">
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
														<h3 class="product-name"  ><a href="<?php echo 'ficha.php?idProducto='.base64_encode($productos[$i]["id"]); ?>" style="<?php echo strlen($productos[$i]['nombre']) > 22 ? 'font-size:12px':  '' ?>" ><?php echo $productos[$i]['nombre']; ?></a></h3>

														<?php echo $precio; ?>
													</div>
													<div class="add-to-cart">
														<?php
															if($productos[$i]["stock"] <= $limite_stock OR $productos[$i]["estado"] == 0){
																?>
																	<button onclick="href_envio('<?php echo $productos[$i]['id']; ?>')" class="add-to-cart-btn2" rel="<?php echo $productos[$i]['id']; ?>">Ver</button>
																	<!-- onclick="agregar_product('id','stock','estado')"  -->
																<?php
															}else{
																?>
																	<button class="add-to-cart-btn agregacarro " rel="<?php echo $productos[$i]['id']; ?>"><i class="fa fa-shopping-cart"></i>Agregar Al Carro</button>
																<?php
															}
														?>
													</div>
												</div>
											</div>
											<!-- /product -->
										<?php
									}
								}else{

								}
							?>
						<!-- TERMIO DEL RESPLADP -->
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
?>
