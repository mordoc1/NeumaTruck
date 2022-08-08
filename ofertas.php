<?php
// AUDITADO
session_start();
include 'funciones/conexion.php';
include 'funciones/funciones.php';
include 'funciones/funciones_aux.php';
include 'includes/conx.php';
include 'includes/card.php';

$title = '';
$re = mysql_query("SELECT title FROM configuracion_title WHERE id = 1") or die(mysql_error());
    while($f = mysql_fetch_array($re)){
      $title = $f['title'];
}
$pagina = 'Neumatruck - '.strtoupper($title);
mysql_close();

$estado_oferta = detectar_ofertas();

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
	$productos = productos_oferta();
?>
<!DOCTYPE html>
<?php

?>
<html lang="es">
	<head>
		<?php include_once("includes/head.inc.php"); ?>
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
							<li><a href="javascript:void(0);"><?php echo $title; ?></a></li>
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
					<div class="col-md-12"><h2 class="titulo"><?php echo $title; ?></h2><hr class="amarillo"></div>
					<?php for ($i=0; $i < count($productos) ; $i++) { ?>
                        <?php echo show_card($productos[$i]['of'], $productos[$i]["marca"],$productos[$i]["media"], $productos[$i]["aplicacion"], $productos[$i]["stock"], $productos[$i]["id"], $productos[$i]["estado"], $productos[$i]["nombre"], $productos[$i]["codigo"], $productos[$i]['v_oferta'],$productos[$i]['v_publicado'], $productos[$i]['v_lista']); ?>
                    <?php } ?>
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
