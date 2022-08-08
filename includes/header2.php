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
		<div id="top-header" style="background-image: url(data:image/jpeg;base64,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); background-size:cover;background-repeat:no-repeat;background-position: center center;">
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
