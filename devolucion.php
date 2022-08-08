<?php
    // AUDITADO
	session_start();

	require('funciones/conexion.php');

	require('funciones/funciones.php');

	if(!isset($_SESSION["idunica"])){

		$_SESSION["idunica"]  = GeneraId(15);

	}



	$url				= "Politicas";

	$pmenu				= "Politicas";

	$pagina 			= title_web($url);

?>

<!DOCTYPE html>

<html lang="en">



<head>
    <?php include_once("includes/head.inc.php"); ?>
</head>



<body>
<?php include 'includes/body.inc.php'; ?>
    <header>

        <?php include('includes/header.php'); ?>

        <!-- HEADER -->

        <?php include('includes/social.php'); ?>

    </header>

    <!-- /HEADER -->





	<script src="https://www.w3schools.com/lib/w3.js"></script>

	<img class="nature" src="img/2.0/banner/devolucion.webp" width="100%">





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

            </div>

            <div class="row">

                <!-- Product main img -->



                <!-- BREADCRUMB -->

                <div id="breadcrumb" class="section">

                    <!-- container -->

                    <div class="container">

                        <!-- row -->

                        <div class="col-md-12">



                            <h3 class="title">GARANTÍAS DE DEVOLUCIONES</h3>



                        </div>

                        <!-- /row -->



                    </div>

                    <!-- /container -->

                </div>

                <!-- /BREADCRUMB -->

                <p> El cliente podrá devolver un producto adquirido en Neumatruck.cl dentro del plazo de 5 días contados desde su recepción, sin necesidad de invocar ninguna causa y siempre y cuando el producto se encuentre en las mismas condiciones despachadas y recibido conforme por el cliente, sin que presente ningún deterioro por un hecho imputable al cliente o presente condiciones de haber sido instalado/montado y/o usado, lo que elimina la opción de devolución del producto.
                    Para ejercer este derecho el cliente deberá presentar el producto en horario hábil en tienda ubicada en Santa Margarita 0448, San Bernardo y en caso de regiones deberá despacharse a la tienda previo aviso, adjuntando la factura correspondiente dentro del plazo de 5 días de recibido. Asimismo, deberá acompañar la factura original o cualquier documento que acredite la compra y restituir en buen estado los elementos originales del embalaje, como las etiquetas, certificados de garantía, manuales de uso, cajas, elementos de protección y sus accesorios o pagar su respectivo valor, previamente informado.
                    Garantía Legal
                    En caso de que un producto adquirido en Neumatruck.cl en opinión del cliente, presentare fallas o defectos o no tuviere las características técnicas informadas, el cliente tendrá derecho a optar, dentro de los 3 meses siguientes a su recepción, por alguna de las siguientes alternativas:
                    Reposición o cambio del producto previa restitución del mismo; o
                    Devolución de la cantidad pagada previa restitución del producto.
                    Para ejercer este derecho, el cliente deberá presentar el producto, junto con su factura, en la sucursal de Neumatruck en horario hábil, completando un instructivo de reclamo y en caso de regiones, enviar a Casa Matriz previo aviso del despacho, con una descripción detallada de las causas de su no conformidad.
                    Para determinar la validez de la falla o defecto, el producto se recepcionará y se generará un informe técnico el cual será enviado al cliente en un plazo máximo de 10 días desde la fecha de recepción.
                    Casos NO cubiertos por la garantía:
                    Están excluidas de la presente garantía las averías de origen accidental o aquellas causadas por el uso indebido del producto o del vehículo:
                    Averías de origen accidental: Aquellas causadas por golpes en obstáculos de la carretera, caídas en baches, cortes o rasgaduras por elementos cortantes por acción de terceros, señales de roce en el flanco.
                    Averías producidas por el mal uso del neumático contrario a las indicaciones del fabricante e indicadas por Neumatruck: Desgaste irregular por montaje y alineación defectuosa, deformaciones y/o ampollas por insuficiencia de presión o sobrecarga, señales de separación de sus compuestos en las uniones banda rodamiento/flanco, flanco/talones o revestimiento interno también ocasionado por insuficiencia de presión o sobrecarga, desprendimiento de elementos de la banda de rodamiento por uso en superficies o condiciones no previstas para ello, marcas de deslizamiento o características de bloqueo de freno.
                    No coincide la identificación del neumático con lo indicado en la factura.
                    Averías de origen técnico, causado por uso indebido del producto o del vehículo.
                    Neumático con desgaste debido a problemas de origen mecánico o factores relacionados con el uso.
                </p>





                <!-- /Product main img -->

                <!-- Product tab -->

             

                <!-- /product tab -->

            </div>

            <!-- /row -->

        </div>

        <!-- /container -->

    </div>

    <!-- /SECTION -->



    <!-- Section -->

    <div class="section">

        <!-- container -->

        <div class="container">

            <!-- row -->

            <div class="row">



                <div class="col-md-12">

                    <div class="section-title text-center">

                        <h3 class="title">PRODUCTOS DESTACADOS</h3>

                    </div>

                </div>



                <!-- product -->



                <?php

                include 'includes/conx.php';

				$consultacamiones	= $mysqli->query("SELECT p.id, p.codigo ,p.estado, p.nombre, p.categoria,p.stock , m.marca, p.medidas, a.aplicacion, p.media, p.oferta, p.val_oferta, p.v_lista, p.v_publicado
														FROM productos AS p
														INNER JOIN aplicaciones AS a
														ON p.aplicacion = a.id_nex
														INNER JOIN marcas AS m
														ON p.marca = m.id_marcas
														WHERE p.v_publicado != 0 ORDER BY RAND() LIMIT 4");
				while($consulta = $consultacamiones->fetch_assoc()){
					if($consulta['prioridad_truck']==2){
						$precio = '<h4 class="product-price">$'.MonedaTruckIVA($consulta['val_oferta']).' <del class="product-old-price">$'.MonedaTruckIVA($consulta['v_publicado']).'</del> c/iva</h4>';
					} else {
						$precio = '<h4 class="product-price">$'.MonedaTruckIVA($consulta['v_publicado']).' c/iva</h4>';
					}
					?>
                    <div class="col-md-3 col-xs-6">
						<div class="product">
							<a href="<?php echo 'ficha.php?idProducto='.base64_encode($consulta["id"]); ?>">
							<div class="product-img">
								<img src="<?php echo _GetOriginal.'productos/'.$consulta['media'].'.webp'; ?>">
								<div class="product-label">
									<span class="new"><?php echo $consulta['marca']; ?></span>
								</div>
							</div>
							</a>
							<div class="product-body">
								<p class="product-category"><?php echo $consulta['aplicacion'] ?></p>
								<h3 class="product-name"><a href="<?php echo 'ficha.php?idProducto='.base64_encode($consulta["id"]); ?>"><?php echo $consulta['nombre']; ?></a></h3>
								<?php echo $precio; ?>
							</div>
							<div class="add-to-cart">

								<button class="add-to-cart-btn agregacarro" rel="<?php echo $consulta['id']; ?>"><i class="fa fa-shopping-cart"></i>Agregar al Carro</button>

							</div>

						</div>

					</div>





                    <?php

				}

			?>



            </div>

            <!-- /row -->

        </div>

        <!-- /container -->

    </div>

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



		$( document ).ready(function() {

			$('#exampleModal').modal('toggle')

		});



	</script>



</body>

</html>

