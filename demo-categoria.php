<?php
//require('funciones/funciones.php');
// MODIFICADO POR TAO esto lo agreggue ya que la categoria en la exportacion de datos no existia ya que ventasneumachile esta mal optimizada y eso pasaba en neumatrack ya que buscaba categorias sin ser usadas
session_start();
include 'funciones/conexion.php'; 
include 'funciones/funciones.php'; 	


	if(!isset($_SESSION["idunica"])){
		$_SESSION["idunica"]  = GeneraId(15);}
	// if(isset($_GET['tipo-item']) && $_GET['tipo-item'] !=''){
	// $buscar					= $mysqli->real_escape_string(trim(RemoveXSS($_POST['tipo-item'])));
	//-INFO BASICA
	$url				= $_GET['tipo-item']; // => palabra de busqueda => buscar
	$pmenu				= "Portada";
	$palabra = $_GET['tipo-item'];

	
	include 'includes/conx.php';

	$busqueda = $palabra; 
	$productos = array();
	$medidas = array();
	$marcas = array();
	$re = mysql_query("SELECT * FROM productos WHERE estado = 1 AND stock >= 1 AND categoria LIKE '$busqueda'") or die(mysql_error());
	while($f = mysql_fetch_array($re)){
		array_push($productos,array("id" => $f["id"], "codigo" => $f["codigo"], "nombre" => $f["nombre"], "stock" => $f["stock"], "marca" => $f["marca"], "categoria" => $f["categoria"],
									"medidas" => $f["medidas"],"aro" => $f["aro"], "aplicacion" => $f["aplicacion"], "v_lista" => $f["v_lista"], "v_publicado" => $f["v_publicado"], 
									"media" => $f["media"], "of" => $f["oferta"], "v_oferta" => $f["val_oferta"]));
	}
	$re = mysql_query("SELECT DISTINCT marca FROM productos WHERE estado = 1 AND stock >= 1 AND categoria LIKE '$busqueda' ") or die(mysql_error());
	while($f = mysql_fetch_array($re)){
		array_push($marcas, array("marca" => $f["marca"]));
	}
	$re = mysql_query("SELECT DISTINCT medidas FROM productos WHERE estado = 1 AND stock >= 1 AND categoria LIKE '$busqueda' ") or die(mysql_error());
	while($f = mysql_fetch_array($re)){
		array_push($medidas, array("medidas" => $f["medidas"]));
	}
	mysql_close();

	
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
					//Alerta en caso de agregar producto al carro
					if(isset($_SESSION["resultado"]) && $_SESSION["resultado"] !=''){
						echo "<div class=\"col-md-12\"><div class=\" alert alert-success \" id=\"hastaca\"><i class=\"fa fa-thumbs-o-up\"></i> ".$_SESSION["resultado"]." &nbsp;&nbsp;<a href=\"". _GetDomain ."carro.php\" class=\"pull-right\"><strong><i class=\"fa fa-shopping-bag\"></i> Ver carrito</strong></a></div></div> ";
						unset($_SESSION["resultado"]);
					} ?>
					<div class="col-md-12"><h2 class="titulo">Resultados para: <?php echo $palabra; ?></h2><hr class="amarillo"></div>
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
										echo '
											<!-- product -->
											<div class="col-md-4 col-xs-6 resfiltro marca'.sacarEspacions($productos[$i]["marca"]).' medida'.Quitar5($productos[$i]["medidas"]).' ">
												<div class="product">
													<a href=""><div class="product-img">
													<img src="'._GetOriginal.'productos/'.$productos[$i]['media'].'.jpg'.'">
														<div class="product-label-oferta">
														'.$lblOferta.'
														</div>
														<div class="product-label">
															<span class="new">'.$productos[$i]['marca'].'</span>
														</div>
													</div></a>
													<div class="product-body">
														<p class="product-category">'.$productos[$i]['aplicacion'].' &nbsp;</p>
														<h3 class="product-name"><a href="'._GetDomain.'producto/'.Url($productos[$i]['nombre']).'/'.$productos[$i]['id'].'">'.$productos[$i]['nombre'].'</a></h3>
														'.$precio.'
													</div>
													<div class="add-to-cart">
														<button class="add-to-cart-btn agregacarro" rel="'.$productos[$i]['id'].'"><i class="fa fa-shopping-cart"></i>Cotizar</button>
													</div>
												</div>
											</div>
											<!-- /product -->
											';
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
	// } else { header('Location:'._GetDomain); exit();}
?>