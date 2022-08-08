<header>



<?php

// verificar nav oferta

include 'conx.php';

$op_oferta = 0;

$re = mysql_query("SELECT *  FROM configuracion WHERE tipo = 'ofertas'") or die(mysql_error());

    while($f = mysql_fetch_array($re)){

      $op_oferta = $f["resultado"];



}

mysql_close();



?>



		<!-- TOP HEADER -->

		<div id="top-header">

			<div id="div-interno-header" class="container" style="display:flex;justify-content:center">

				<ul class="header-links pull-left">

					<li><a id="tel-text-fono" class="ul-telefonos" href="#">Fono ventas:</a></li>

					<li><a id="tel-max-firts" class="ul-telefonos" href="tel:+56981833333"><i class="fa fa-phone"></i> +56 9 8183 3333</a></li>

					<li><a id="tel-max-second" class="ul-telefonos" href="tel:+56946649909"><i class="fa fa-phone"></i> +56 9 4664 9909</a></li>

          			<li><a id="tel-max-second" class="ul-telefonos" href="tel:+56224846064"><i class="fa fa-phone"></i> +56 2 2484 6064</a></li>

					<li><a id="tel-max-firts" class="ul-telefonos" href="tel:+56224846042"><i class="fa fa-phone"></i> +56 2 2484 6042</a></li>

				</ul>

			</div>

			<div class="container" style="display:flex;justify-content:center">

				<ul class="header-links pull-left">

					<li><a id="mail-min" href="contacto.php"><i class="fa fa-envelope-o"></i> contacto@neumatruck.cl</a></li>

					<li><a id="horario-min" href="javascript:void(0);"><i class="fa fa-clock-o"></i>Lunes a Viernes: 09:00 a 18:00 hrs</a></li>

				</ul>

			</div>

		</div>

		<!-- /TOP HEADER -->

		<!-- MAIN HEADER -->

		<div id="header">

			<!-- container -->

			<div class="container">

				<!-- row -->

				<div class="row">

					<!-- LOGO -->

					<div class="col-md-4">

						<div class="header-logo">

							<a href="<?php echo _GetDomain; ?>" class="logo">

								<img class="img-logo" src="<?php echo _GetDomain; ?>img/logo.png" alt="NeumaTruck" style="width:300px;">

							</a>

						</div>

					</div>

					<!-- /LOGO -->

					<!-- SEARCH BAR -->

					<div class="col-md-7">

						<div class="header-search">

							<form name="buscador-principal" autocomplete="off" action="<?php echo _GetDomain; ?>resultados.php" method="GET" >

								<div class="autocompletar text-center">

									<input id="tipo-busqueda" class="input" name="tipo-item" placeholder="Buscar" required>

									<button class="search-btn" type="submit">Buscar</button>

								</div>

							</form>

						</div>

					</div>

					<!-- /SEARCH BAR -->

					<!-- ACCOUNT -->

					<div class="col-md-1 clearfix">





							<div class="header-ctn cton-carrito">



						<?php

						if(isset($pmenu) && $pmenu !='Checkout'){

						$items_carro 	= carro_item($_SESSION['idunica']);

						$total_carro	= 0;

						?>

							<!-- Cart -->

							<div class="dropdown ">

								<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

									<i class="fa fa-shopping-cart" style="font-size:35px;"></i>

									<div class="qty"><?php echo $items_carro;  ?></div>

								</a>

								<?php if($items_carro >0){ ?>

								<div class="cart-dropdown">

									<div class="cart-list">

									<?php

									$carro			= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' ");

									while($carrorow = $carro->fetch_assoc()){

										$urlProductoc    = _GetDomain.'producto/'.Url($carrorow['tmp_nombre']).'/'.$carrorow['tmp_idproducto'];

										$fotoc           = Imagen($carrorow['tmp_idproducto']);

										$marcaProducto   = MarcaProducto($carrorow['tmp_idproducto']);

										$total_item      = ($carrorow['tmp_valor'] * $carrorow['tmp_cantidad']) * 1.19;

										$total_carro  	 = $total_carro + $total_item;

										$fotoProductoc   = _GetOriginal.'productos/'.$fotoc.".jpg";

									?>

										<div class="product-widget">

											<div class="product-img">

												<img src="<?php echo $fotoProductoc; ?>" alt="<?php echo $carrorow['tmp_nombre']; ?>">

											</div>

											<div class="product-body">

												<h3 class="product-name"><a href="<?php echo $urlProductoc; ?>"><?php echo $carrorow['tmp_nombre']; ?></a></h3>

												<h4 class="product-price"><span class="qty"><?php echo $carrorow['tmp_cantidad']; ?> x </span>$<?php echo number_format($total_item,0,'','.'); ?></h4>

											</div>

											<a href="<?php echo _GetDomain; ?>carrito-accion.php?idpro=<?php echo $carrorow['tmp_idproducto']; ?>&accion=remove" class="delete"><i class="fa fa-close"></i></a>

										</div>

									<?php } ?>

									</div>

									<div class="cart-summary">

										<small><?php echo $items_carro; ?> Item(s) seleccionados</small>

										<h5>TOTAL: $<?php echo Moneda($total_carro); ?> c/iva</h5>

									</div>

									<div class="cart-btns">

										<a href="<?php echo _GetDomain; ?>carro.php">Ver Carro</a>

										<a href="<?php echo _GetDomain; ?>checkout.php">Pagar <i class="fa fa-arrow-circle-right"></i></a>

									</div>

								</div>

								<?php } ?>

							</div>

							<?php } ?>

							<!-- /Cart -->

						</div>

						<?php if(isset($pmenu) && $pmenu !='Checkout'){ ?>



						<!-- <i class="fa fa-shopping-cart"></i> -->



						<?php } ?>

				</div>

				<div class="row">

                    <input type="text">

                    <input type="text">

                    <input type="text">

				</div>

					<!-- /ACCOUNT -->

			</div>

<style>

	#header {

		padding-bottom: 0px;

	}

	.navbar {

		border-radius: 0px;

	}

	.navbar-default .container-fluid {

		padding-left: 0px;

	}

	.navbar-default .navbar-nav {

		padding-left: 0px;

	}

	.navbar-collapse {

		padding-left: 0px;

	}

	.nav>li>a {

		/*padding-left: 0px;

		padding-right: 0px;*/

	}

	.navbar-default .navbar-nav>li>a {

		color:#e5e5e5;

		text-transform: uppercase;

	}

	.navbar-default .navbar-nav>li>a:hover {

		color:#fff;

	}

	.navbar-default .navbar-nav>li>a:active {

		color:#fff;

	}

	.navbar-nav>li {

      float: none;

	}

	@media (min-width: 768px){

.nav-justified>li {

    display: table-cell;

	width: 1%;

	}

}

</style>

<!-- NAVEGADOR TOBLE -->



<div class="col-md-3 clearfix">

						<!-- <div id="carrito-responsive" class="visible-xs">

							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

								<i class="fa fa-shopping-cart" style="font-size:30px;"></i>

								<div class="qty"></div>

							</a>

						</div> -->

						<div class="header-ctn">

						<?php

							if(isset($pmenu) && $pmenu !='Checkout'){

								?>

								<div class="dropdown carrito-togle" style="position:absolute;left:5px">

										<a href="carro.php" onclick="continuarCarritoResponsive()" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

											<i class="fa fa-shopping-cart" style="font-size:30px;"></i>

											<div id="contenido-cantidad" class="qty"><?php echo $items_carro;  ?></div>

										</a>

								</div>

								<?php

							}else{}

						 ?>

							<!-- Menu Toogle -->

							<div class="menu-toggle">

								<a href="#" onclick="mostrarTogle()">

									<i class="fa fa-bars"></i>

									<span>Menu</span>

								</a>

							</div>

							<!-- /Menu Toogle -->

						</div>

					</div>



		<nav>

			<!-- container -->

			<div class="container">

				<!-- responsive-nav -->

				<div class="container">

					<!-- responsive-nav -->

					<div id="responsive-nav">

						<!-- NAV -->

						<ul class="main-nav nav navbar-nav">

							<li class="active"><a href="index.php">Inicio</a></li>

							<?php

								include "conx.php";

								$re = mysql_query("SELECT * FROM categorias") or die(mysql_error());

								while($f = mysql_fetch_array($re)){

									?>

										<li><a href="categoria.php?tipo-item=<?php echo $f["nombre"] ?>"><?php echo $f["nombre"]; ?></a></li><li class="divider-vertical"></li>

									<?php

								}

							?>

							<hr>

							<li><a href="<?php echo _GetDomain; ?>contacto.php">Contacto</a></li>

							<?php

								if($op_oferta == 1){

									?>

										<li><a href="ofertas.php" style="color: #FFB03D;">Ofertas</a></li>

									<?php

								}

							?>

							<?php

								if(isset($pmenu) && $pmenu !='Checkout'){

								?>

									<li><a href="carro.php">Carrito</a></li>

								<?php

								}else{}

							?>

						</ul>

						<!-- /NAV -->

					</div>

					<!-- /responsive-nav -->

				</div>

				<!-- /responsive-nav -->

			</div>

			<!-- /container -->

		</nav>



<nav class="navbar navbar-default" style="border-color: transparent; background-color:transparent; border-top: 1px solid #fff; ">

  <div class="container-fluid">



	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">

	        <span class="icon-bar"></span>

	        <span class="icon-bar"></span>

	        <span class="icon-bar"></span>

	      </button>

					    <!-- Collect the nav links, forms, and other content for toggling -->

					    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

					      <ul class="nav nav-justified navbar-nav">

									<li><a href="<?php echo _GetDomain; ?>">Portada</a></li>

										<?php

											include "conx.php";

											$re = mysql_query("SELECT * FROM categorias") or die(mysql_error());

											while($f = mysql_fetch_array($re)){

												?>

													<li><a href="categoria.php?tipo-item=<?php echo $f["nombre"] ?>"><?php echo $f["nombre"]; ?></a></li><li class="divider-vertical"></li>

												<?php

											}



										?>

								<li><a href="<?php echo _GetDomain; ?>contacto.php">Contacto</a></li>

								<?php

								if($op_oferta == 1){

									?>

										<li><a href="ofertas.php" style="color: #FFB03D;">Ofertas</a></li>

									<?php

								}

							?>

				      </ul>

				    </div><!-- /.navbar-collapse -->

				  </div><!-- /.container-fluid -->

				</nav>

				<!-- row -->

			</div>

			<!-- container -->

		</div>

		<!-- /MAIN HEADER -->

	</header>

