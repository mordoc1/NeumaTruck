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

	<img class="nature" src="img/2.0/banner/despacho.webp" width="100%">





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



                            <h3 class="title">Despacho y Entrega de Productos</h3>



                        </div>

                        <!-- /row -->



                    </div>

                    <!-- /container -->

                </div>

                <!-- /BREADCRUMB -->

                <p> El despacho y la entrega de los productos adquiridos en <strong style="font-size: 15px;"> www.neumatruck.cl </strong> podrán

                    ser efectuados a través de alguna de

                    las siguientes modalidades, de acuerdo con la disponibilidad de stock informada para cada producto:

                </p>





                <!-- /Product main img -->

                <!-- Product tab -->

                <div class="col-md-12">

                    <div id="product-tab">

                        <!-- product tab nav -->

                        <ul class="tab-nav">

                            <li class="active"><a data-toggle="tab" href="#tab1">Despacho Gratis de La Serena a Los Ángeles</a></li>

                            <li><a data-toggle="tab" href="#tab2">Despacho Otras Regiones y Provincias por Pagar</a></li>

                        </ul>

                        <!-- /product tab nav -->



                        <!-- product tab content -->

                        <div class="tab-content">



                            <div id="tab1" class="tab-pane fade in active">

                                <div class="row">

                                    <div class="col-md-12">

                                        <p> ● Bajo esta modalidad y sin un mínimo de compra el despacho de los productos será realizado en el domicilio que el cliente indique al momento del envío de su orden de compra. Cabe destacar que el domicilio debe estar dentro de las localidades informadas dentro de las regiones de La Serena a Los Ángeles. (Incluye ciudades principales, capitales regionales, no incluye ramales).</p>

                                        <br>

                                        <p> ● La tienda está ubicada en: Santa Margarita 0448, San Bernardo.

                                            Adicionalmente, el cliente, podrá autorizar a un tercero

                                            para efectuar el retiro del producto, debiendo indicar los datos de dicha

                                            persona (nombre completo, Rut, número de teléfono y correo electrónico) al

                                            ejecutivo de ventas. </p>

                                        <br>

                                        <p> ● Será responsabilidad del cliente la exactitud de los datos entregados en <strong style="font-size: 15px;"> Neumatruck </strong> para una correcta y oportuna entrega de los productos en el domicilio indicado o en el lugar de despacho elegido.</p>

                                        <br>

                                        <p> ● El despacho de los productos será realizado a través de servicios de Courier nacional, en el lugar que el cliente hubiere elegido, en un plazo de 1 a 5 días hábiles una vez validada la orden de compra y el pago. Tanto si es <strong style="font-size: 15px;"> Neumatruck </strong> o courier nacional, el despacho de productos se realiza de lunes a viernes, entre 9:30 y 18:30 horas. Una vez realizada la compra, se formalizará la fecha de despacho a través de correo electrónico, o llamada del ejecutivo de Ventas. El rango de hora será siempre entre las 9:30 y 19:30 hrs inclusive. </p>

                                        <br>

                                        <p> ● Los despachos gratuitos dentro de la Región Metropolitana, IV, V y VI Región serán efectuados por transporte propio de <strong style="font-size: 15px;"> Neumatruck </strong> que incluye las siguientes localidades:</p>

                                        <br>



                                        <table class="table">

                                            <thead class="thead-dark">

                                                <tr>

                                                    <th scope="col">RM </th>

                                                    <th scope="col">IV REGIÓN </th>

                                                    <th scope="col">V-CENTRO</th>

                                                    <th scope="col">V-NORTE</th>

                                                    <th scope="col">V-SUR </th>

                                                    <th scope="col">VI REGIÓN </th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                <tr>

                                                    <td>TODAS</td>

                                                    <td>LOS VILOS</td>

                                                    <td>CASA BLANCA</td>

                                                    <td>CABILDO</td>

                                                    <td>ALGARROBO</td>

                                                    <td>CHEPICA</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>COQUIMBO</td>

                                                    <td>CON-CON</td>

                                                    <td>HIJUELAS</td>

                                                    <td>CARTAGENA</td>

                                                    <td>CHIMBARONGO</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>LA SERENA </td>

                                                    <td>CURACAVI</td>

                                                    <td>LA CALERA</td>

                                                    <td>EL MONTE</td>

                                                    <td>COINCO</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>OVALLE</td>

                                                    <td>LIMACHE</td>

                                                    <td>LA LIGUA</td>

                                                    <td>EL QUISCO</td>

                                                    <td>COLTAUCO</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>OLMUE</td>

                                                    <td>PUCHUNCAV</td>

                                                    <td>ISLA DE MAIPO</td>

                                                    <td>DOÑIHUE</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>QUILPUE</td>

                                                    <td>QUILLOTA</td>

                                                    <td>LLO-LLEO</td>

                                                    <td>GRANEROS </td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>VALPARAISO</td>

                                                    <td>SAN FELIPE</td>

                                                    <td>MELIPILLA</td>

                                                    <td>LAS CABRAS</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>VILLA ALEMANA</td>

                                                    <td>LOS ANDES</td>

                                                    <td>PEÑAFLOR</td>

                                                    <td>LITUECHE </td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>VIÑA DEL MAR</td>

                                                    <td>LLAY-LLAY</td>

                                                    <td>MALLOCO</td>

                                                    <td>LOLOL</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>QUINTERO</td>

                                                    <td>CATEMU</td>

                                                    <td>SAN ANTONIO</td>

                                                    <td>MACHALI</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>PLACILLA</td>

                                                    <td>PANQUEHUE</td>

                                                    <td>TALAGANTE</td>

                                                    <td>MALLOA</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>PETORCA</td>

                                                    <td>TABO</td>

                                                    <td>MARCHIHUE</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>MARIA PINTO</td>

                                                    <td>MOSTAZAL</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>NANCAGUA</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>OLIVAR</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>PALMILLA</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>PAREDONES</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>PERALILLO </td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>PEUMO</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>PICHIDEGUA</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>SANTA CRUZ </td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>SAN FERNANDO</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>SAN VICENTE DE TAGUA</td>

                                                </tr>

                                                <tr>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>-</td>

                                                    <td>PICHILEMU</td>

                                                </tr>

                                            </tbody>

                                        </table>

                                        <hr>

                                        <br>

                                        <br>

                                        <P>

                                            ● Para la VII y VIII Región el despacho gratuito será realizado por la empresa de transportes Pacarí en un plazo de 48 a 96 horas hábiles. Incluyendo los siguientes ramales:<br>

                                            SEPTIMA REGION -

                                            LOCALIDAD -

                                            TALCA -

                                            CURICO -

                                            SAN RAFAEL -

                                            LINARES -

                                            CONSTITUCION -

                                            CAUQUENES -

                                            SAN JAVIER -

                                            PARRAL -

                                            HUALAÑE -

                                            MAULE -

                                            VILLA ALEGRE -

                                            LICANTEN -

                                            EMPEDRADO -

                                            TENO -

                                            MOLINA -

                                            LONGAVI -

                                            YERBAS BUENAS -

                                            SAN CLEMENTE -

                                            SAGRADA FAMILIA -

                                            CHANCO -

                                            CUREPTO -

                                            ROMERAL -

                                            RETIRO -

                                            RIO CLARO -

                                            REMULCAO -

                                            PUTU -

                                            CUMPEO -

                                            OCTAVA REGION -

                                            LOCALIDAD -

                                            LOS ANGELES -

                                            CHILLAN -

                                            CONCEPCION -

                                            CORONEL -

                                            SAN CARLOS -

                                            CABRERO -

                                            CAÑETE -

                                            HUALPEN -

                                            SAN NICOLAS -

                                            TIRUA -

                                            TALCAHUANO -

                                            LEBU -

                                            LOTA ALTO -

                                            COLLIPULLI -

                                            QUIRIHUE -

                                            QUILLON -

                                            LAJA -

                                            HUEPIL -

                                            HUALQUI -

                                            NACIMIENTO -

                                            CHILLAN VIEJO -

                                            PENCO -

                                            TOME -

                                            CURANILAHUE -

                                            PATA GALLINA -

                                            BULNES -

                                            STA JUANA -

                                            TUCAPEL -

                                            COIHUECO -

                                            SAN IGNACIO -

                                            YUNGAY -

                                            NEGRETE -

                                            MINICO -

                                            ARAUCO -

                                            QUILLECO. <br>

                                            La recepción del producto debe realizarse por una persona mayor de edad, quien deberá firmar y escribir su nombre y Rut para acreditar la recepción del producto.

                                            En caso de que el producto sea recibido por un tercero distinto del titular de la orden de compra (familiares, asesora del hogar, conserjes, mayordomo, etc.), este tercero deberá firmar

                                        </P>

                                        <p>

                                            ● y escribir su nombre y Rut en la guía de despacho para acreditar la recepción del producto.

                                            En caso de que el cliente no esté conforme con el producto recibido, deberá informar en un plazo de 24 horas la no conformidad enviando un correo a <strong style="font-size: 15px;"> contacto@neumatruck.cl </strong> exponiendo las razones de la no conformidad además de los datos de la orden de compra. En un plazo de 24 horas hábiles, <strong style="font-size: 15px;">Neumatruck </strong> se contactará para establecer las opciones de acuerdo a Garantía Legal o Derecho de Retracto.

                                        </p>



                                    </div>

                                </div>

                            </div>



                            <!-- /tab2  -->



                            <!-- tab3  -->

                            <div id="tab2" class="tab-pane fade in">

                                <div class="row">

                                    <!-- Rating -->

                                    <br>

                                    <p>Una vez realizado todo el proceso de compra indicando el lugar de despacho, el ejecutivo de ventas se pondrá en contacto con el cliente para consultar la empresa de transportes escogida por la cual quiere enviar la mercadería. Neumatruck entregará dicha mercadería en un plazo de 24 a 48 horas hábiles a la empresa de transporte para hacer el envío por pagar. Luego el cliente debe sumar el plazo de entrega de la empresa de envío.<br>

                                    </p>

                                    <br>

                                    <p>Una vez constatados los procedimientos de seguridad para la verificación de la compra (el medio de pago utilizado y la confirmación de los datos personales suministrados por el cliente) el cliente recibirá un correo que le indicará el número de seguimiento de su despacho. En este caso y dado la naturaleza del despacho y disponibilidad del transporte escogido por el cliente, el envío podrá exceder del plazo establecido.<br>

                                    </p>

                                    <p>● Desde Temuco a Puerto Montt sugerimos la empresa de transportes el Arriero que hace entrega de los productos dentro de 48 a 72 horas hábiles.</p>

                                    <p>● Para los despachos de la IV Región no incluidos en el transporte gratuito sugerimos realizarlos por transportes Huara quien hace entrega en un plazo de 48 a 96 horas hábiles. (Despacho gratis en Los Vilos, Coquimbo, La Serena, Ovalle).</p>

                                    <p>

                                        ● También para los despachos de la III a la II Región se sugiere realizarlos por transportes Huara quien hace entrega en un plazo de 48 a 96 horas hábiles.

                                    </p>

                                </div>

                            </div>

                            <!-- /tab3  -->

                        </div>

                        <!-- /product tab content  -->

                    </div>

                </div>

                <!-- /product tab -->

            </div>

            <!-- /row -->

        </div>

        <!-- /container -->

    </div>

    <!-- /SECTION -->



    <!-- Section -->

  

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

