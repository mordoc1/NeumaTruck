<?php
session_start();
include 'funciones/conexion.php';
include 'funciones/funciones.php';
include 'funciones/funciones_aux.php';
include 'includes/conx.php';
include 'includes/card.php';
$title_2 = '';
$re = mysql_query("SELECT title FROM configuracion_title WHERE id = 2 LIMIT 1") or die(mysql_error());
    while($f = mysql_fetch_array($re)){
      $title_2 = strtoupper($f['title']);
}



$estado_oferta = 0;

$re = mysql_query("SELECT resultado FROM configuracion WHERE tipo = 'of'") or die(mysql_error());
    while($f = mysql_fetch_array($re)){
      $estado_oferta = $f['resultado'];
}
mysql_close();

if($estado_oferta != 1){
	header("Location: https://www.neumatruck.cl");
	exit;
}

	if(!isset($_SESSION["idunica"])){
		$_SESSION["idunica"]  = GeneraId(15);}
	// if(isset($_GET['tipo-item']) && $_GET['tipo-item'] !=''){
	// $buscar					= $mysqli->real_escape_string(trim(RemoveXSS($_POST['tipo-item'])));
	//-INFO BASICA
	$url				= $_GET['tipo-item']; // => palabra de busqueda => buscar
	$pmenu				= "Portada";

	include 'includes/conx.php';


	$productos = productos_oferta_especial(); 

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
							<li><a href="javascript:void(0);"><?php echo $title_2; ?></a></li>
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
					<div class="col-md-12"><h2 class="titulo"><?php echo $title_2; ?></h2><hr class="amarillo"></div>
					<?php 
						for ($i=0; $i < count($productos) ; $i++) {
							?>
							<?php echo show_card($productos[$i]['of'], $productos[$i]["marca"],$productos[$i]["media"], $productos[$i]["aplicacion"], $productos[$i]["stock"], $productos[$i]["id"], $productos[$i]["estado"], $productos[$i]["nombre"], $productos[$i]["codigo"], $productos[$i]['v_oferta'],$productos[$i]['v_publicado'], $productos[$i]['v_lista']); ?>
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
