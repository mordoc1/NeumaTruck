<?php
session_start();
include 'funciones/conexion.php';
include 'funciones/funciones.php';
include 'funciones/funciones_aux.php';
include('includes/card.php');

	if(!isset($_SESSION["idunica"])){
		$_SESSION["idunica"]  = GeneraId(15);}

	$url				= $_GET['tipo-item']; // => palabra de busqueda => buscar
	$pmenu				= "Portada";
	$palabra = $_GET['tipo-item'];


	include 'includes/conx.php';

	$busqueda = $palabra;
	$productos = busquda_producto_categoria($palabra);
	$medidas = busqueda_nav_medidas_categoria($palabra);
	$marcas = busqueda_nav_marcas_categoria($palabra);

	$showHot			= showHotOferta();
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

        <div class="section section-marcas-nuevas">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <section class="customer-logos slider">
                            <?php
                                include 'includes/conx.php';
                                $re = mysql_query("SELECT * FROM marcas WHERE nav = 1") or die(mysql_error());
                                while($f = mysql_fetch_array($re)){
                                    ?>
                                        <!-- <div class="slide"><a href="marcas.php?marca=<?php echo $f["marca"].'&idm='.$f["id_marcas"]; ?>" class="primary-btn"><?php echo $f["marca"]; ?></a></div> -->
                                        <div class="slide"><a href="marcas.php?marca=<?php echo $f["marca"].'&idm='.$f["id_marcas"]; ?>" class=""> <img style="width:200px;height:auto;" src="img/<?php echo $f["id_marcas"]; ?>.svg" alt=""> </a></div>
                                    <?php
                                }
                                mysql_close();
                            ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>

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
							<?php for ($i=0; $i < count($medidas) ; $i++) { ?>
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
							<?php if(count($productos) > 0){
							    for ($i=0; $i < count($productos) ; $i++) { ?>
                                    <?php echo show_card($productos[$i]['of'], $productos[$i]["marca"],$productos[$i]["media"], $productos[$i]["aplicacion"], $productos[$i]["stock"], $productos[$i]["id"], $productos[$i]["estado"], $productos[$i]["nombre"], $productos[$i]["codigo"], $productos[$i]['v_oferta'],$productos[$i]['v_publicado']); ?>	
								<?php }
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
        </script>
</body>
</html>
<?php
	// } else { header('Location:'._GetDomain); exit();}
?>
