<header>
	<?php
// verificar nav oferta
include 'conx.php';
$op_oferta = 0;
$re = mysql_query("SELECT * FROM configuracion WHERE tipo = 'ofertas'") or die(mysql_error());
    while($f = mysql_fetch_array($re)){
      $op_oferta = $f["resultado"];
}
$op_oferta_2 = 0;
$re = mysql_query("SELECT * FROM configuracion WHERE tipo = 'of'") or die(mysql_error());
    while($f = mysql_fetch_array($re)){
      $op_oferta_2 = $f["resultado"];
}
$telefonos = array();
$re = mysql_query("SELECT * FROM telefonos ORDER BY orden ASC") or die(mysql_error());
    while($f = mysql_fetch_array($re)){
      array_push($telefonos,array("id" => $f["id"], "id_css" => $f["id_css"],"phone" => $f["phone"]));
}
$title = '';
$title_2 = '';
$re = mysql_query("SELECT title FROM configuracion_title WHERE id = 1") or die(mysql_error());
    while($f = mysql_fetch_array($re)){
      $title = $f['title'];
}
$re = mysql_query("SELECT title FROM configuracion_title WHERE id = 2") or die(mysql_error());
    while($f = mysql_fetch_array($re)){
      $title_2 = $f['title'];
}
mysql_close();
?>
		<!-- TOP HEADER -->
		<div id="top-header">
			<div id="div-interno-header" class="container" style="display:flex;justify-content:center">
				<ul class="header-links pull-left">
					<li><a id="tel-text-fono" class="ul-telefonos" href="#">Fono ventas:</a></li>
					<?php for ($i=0; $i < count($telefonos) ; $i++) { ?>
						<li><a id="<?php echo $telefonos[$i]['id_css'] ?>" class="ul-telefonos" href="<?php echo "tel:".str_replace(' ','',$telefonos[$i]['phone']); ?>"><i class="fa fa-phone"></i><?php echo " ".$telefonos[$i]['phone']; ?></a></li>
					<?php } ?>
				</ul>
			</div>
      <!-- flex -->
      <div id="div-interno-header telefono-fijo" class="container" style="justify-content:center">
        <ul>
          <li><a id="tel-text-fono-fijo" style="color:white;font-size:23px" class="ul-telefonos-fijo" href="<?php echo "tel:".str_replace(' ','',$telefonos[2]['phone']); ?>"><i class="fa fa-phone" style="color:#ffb03d"></i><?php echo " ".$telefonos[2]['phone']; ?></a></li>
        </ul>
      </div>
			<div class="container" style="display:flex;justify-content:center">
				<ul class="header-links pull-left">
					<!-- <li><a id="mail-min" href="contacto.php"><i class="fa fa-envelope-o"></i> contacto@neumatruck.cl</a></li> -->
					<li><a id="mail-min" href="mailto:contacto@neumatruck.cl"><i class="fa fa-envelope-o"></i> contacto@neumatruck.cl</a></li>
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
									<input id="tipo-busqueda" class="input" name="tipo-item" placeholder="Busca tu Medida" required>
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
										$urlProductoc    = _GetDomain.'ficha.php?idProducto='.base64_encode($carrorow['tmp_idproducto']);
										$fotoc           = Imagen($carrorow['tmp_idproducto']);
										$marcaProducto   = MarcaProducto($carrorow['tmp_idproducto']);
										$total_item      = ($carrorow['tmp_valor'] * $carrorow['tmp_cantidad']) * 1.19;
										$total_carro  	 = $total_carro + $total_item;
										$fotoProductoc   = _GetOriginal.'productos/'.$carrorow['tmp_idproducto'].".webp";
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
										<a style="width:100%;" href="<?php echo _GetDomain; ?>carro.php">Ver Carro</a>
										<!-- <a href="checkout.php">Pagar <i class="fa fa-arrow-circle-right"></i></a> -->
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
											<i class="fa fa-shopping-cart" style="font-size:40px;"></i>
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
							<!-- <li><a href="<?php //echo _GetDomain; ?>resultados.php?tipo-item=bateria">Baterias</a></li> -->
							<li><a href="<?php echo _GetDomain; ?>contacto.php">Contacto</a></li>
							<?php
								if($op_oferta == 1){
									?>
										<li><a href="ofertas.php" style="color: #FFB03D;"><?php echo $title; ?></a></li>
									<?php
								}
								if($op_oferta_2 == 1){
									?>
										<li><a href="ofertas_esp.php" ><p class="neon"><?php echo $title_2; ?></p></a></li>
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
                  <?php
  								if($op_oferta == 1){
  									?>
  										<li><a href="ofertas.php" style="color: #FFB03D;"><?php echo $title; ?></a></li>
  									<?php
    								}
									if($op_oferta_2 == 1){
										?>
											<li><a href="ofertas_esp.php" ><p class="neon"><?php echo $title_2; ?></p></a></li>
										<?php
									  }
    							?>
								<?php
									include "conx.php";
									$re = mysql_query("SELECT * FROM categorias") or die(mysql_error());
									while($f = mysql_fetch_array($re)){
										?>
											<li><a href="categoria.php?tipo-item=<?php echo $f["nombre"] ?>"><?php echo $f["nombre"]; ?></a></li><li class="divider-vertical"></li>
										<?php
									}
								?>
								<!-- <li><a href="<?php //echo _GetDomain; ?>resultados.php?tipo-item=bateria">Baterias</a></li> -->
								<li><a href="<?php echo _GetDomain; ?>contacto.php">Contacto</a></li>
				      </ul>
				    </div><!-- /.navbar-collapse -->
				  </div><!-- /.container-fluid -->
				</nav>
				<!-- row -->
			</div>
			<!-- container -->
		</div>
	</header>
