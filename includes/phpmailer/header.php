<header>
		<!-- TOP HEADER -->
		<div id="top-header">
			<div class="container">
				<ul class="header-links pull-left">
					<li><a href="tel:+56940757152"><i class="fa fa-phone"></i> +56 9 4075 7152</a></li>
					<li><a href="tel:+56224846070"><i class="fa fa-phone"></i> +56 2 2484 6070</a></li>
					<li><a href="mailto:contacto@neumatruck.cl"><i class="fa fa-envelope-o"></i> contacto@neumatruck.cl</a></li>
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
								<img src="<?php echo _GetDomain; ?>img/logo.png" alt="NeumaTruck">
							</a>
						</div>
					</div>
					<!-- /LOGO -->

					<!-- SEARCH BAR -->
					<div class="col-md-6">
						<div class="header-search">
							<form name="buscador-principal" action="<?php echo _GetDomain; ?>resultados.php?q=s" method="post" enctype="application/x-www-form-urlencoded">
								<input class="input autocompletar" name="buscar" placeholder="Buscar" required>
								<button class="search-btn" type="submit">Buscar</button>
							</form>
						</div>
					</div>
					<!-- /SEARCH BAR -->


					<!-- ACCOUNT -->
					<div class="col-md-2 clearfix">
						<div class="header-ctn hidden-xs">
						<?php
						if(isset($pmenu) && $pmenu !='Checkout'){
						$items_carro 	= carro_item($_SESSION['idunica']);
						$total_carro	= 0;
						?>

							<!-- Cart -->
							<div class="dropdown ">
								<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
									<i class="fa fa-shopping-cart" style="font-size:30px;"></i>
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
										
										$fotoProductoc   = _GetOriginal.$fotoc;

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
										<a href="<?php echo _GetDomain; ?>checkout.php">Solicitar <i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
								<?php } ?>

							</div>
							<?php } ?>
							<!-- /Cart -->

						</div>
						<?php if(isset($pmenu) && $pmenu !='Checkout'){ ?>
						<a href="<?php echo _GetDomain; ?>carro.php" class="btn btn-default btn-block visible-xs"><i class="fa fa-shopping-cart"></i> Carro de Cotización (<?php echo $items_carro; ?>)</a>
						<?php } ?>

					</div>
					<!-- /ACCOUNT -->

				</div>
				<!-- row -->
			</div>
			<!-- container -->
		</div>
		<!-- /MAIN HEADER -->
	</header>