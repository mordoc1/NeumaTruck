<!-- NEWSLETTER -->
<div id="newsletter" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="newsletter">
                    <p>Si deseas ser parte de nuestro circulo y recibir nuestro <strong>NEWSLETTER</strong></p>
                    <form action="<?php echo _GetDomain; ?>procesa-newsletter.php" method="POST" enctype="application/x-www-form-urlencoded">
                        <input class="input" type="email" name="email_newsletter" placeholder="Dirección de Email" required>
                        <button class="newsletter-btn" type="submit"><i class="fa fa-envelope"></i> Suscribete</button>
                    </form>
                    <ul class="newsletter-follow">
                        <li><a href="https://www.facebook.com/neumatruck.cl/"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://web.whatsapp.com/send?phone=56954104080&amp;text=Estoy%20interesado%20en%20sus%20productos"><i class="fa fa-whatsapp"></i></a></li>
                        <li><a href="https://www.instagram.com/neumatruck.cl/"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="mailto:contacto@neumatruck.cl"><i class="fa fa-envelope-o"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /NEWSLETTER -->
<footer id="footer">
    <!-- top footer -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-5 col-xs-12">
                    <div class="footer">
                        <h3 class="footer-title">Nosotros</h3>
                        <p class="text-justify">
                        NeumaTruck.cl es una de las principales comercializadoras de marcas líderes de neumáticos para camión y buses. Importamos solo marcas  innovadoras con productos de alta tecnología en la industria. 
                        </p>

                    </div>
                </div>
                <div class="col-md-1 col-xs-12"></div>

                <div class="clearfix visible-xs"></div>

                <div class="col-md-2 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">Marcas</h3>
                        <ul class="footer-links">
                            <li><a href="<?php echo _GetDomain; ?>resultados-marcas.php?idMarca=57">Pirelli</a></li>
                            <li><a href="<?php echo _GetDomain; ?>resultados-marcas.php?idMarca=172">Dunlop</a></li>
                            <li><a href="<?php echo _GetDomain; ?>resultados-marcas.php?idMarca=131">Fesite</a></li>
                            <li><a href="<?php echo _GetDomain; ?>resultados-marcas.php?idMarca=41">Windforce</a></li>
                            <li><a href="<?php echo _GetDomain; ?>marcas.php">Ver todas -></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 col-xs-6">
                <div class="footer">
                    <h3 class="footer-title">Contacto</h3>
                    <ul class="footer-links">
                        <ul class="footer-links">
                            <li><a href="<?php echo _GetDomain; ?>contacto.php"><i class="fa fa-map-marker"></i>Santa Margarita 0448 - Santiago</a></li>
                            <li><a href="tel:+56940757152"><i class="fa fa-phone"></i>+56 9 4075 7152</a></li>
                            <li><a href="tel:+56224846064"><i class="fa fa-phone"></i>+56 2 2484 6070</a></li>
                            <li><a href="mailto:contacto@neumatruck.cl"><i class="fa fa-envelope-o"></i>contacto@neumatruck.cl</a></li>
                        </ul>
                    </ul>
                </div>
            </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /top footer -->

    <!-- bottom footer -->
    <div id="bottom-footer" class="section">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <ul class="footer-payments">
                        <!-- LOGO -->
                        <div class="col-md-3">
                            <div class="header-logo">
                                <a href="<?php echo _GetDomain; ?>" class="logo">
                                    <img src="<?php echo _GetDomain; ?>img/logo.png" alt="Neumatruck">
                                </a>
                                <br class="visible-xs"><br class="visible-xs"><br class="visible-xs">
                            </div>
                        </div>
                        <!-- /LOGO -->
                    </ul>

                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bottom footer -->
</footer>
<!-- /FOOTER -->

<!-- jQuery Plugins -->
<script src="<?php echo _GetDomain; ?>js/jquery.min.js"></script>
<script src="<?php echo _GetDomain; ?>js/bootstrap.min.js"></script>
<script src="<?php echo _GetDomain; ?>js/slick.min.js"></script>
<script src="<?php echo _GetDomain; ?>js/nouislider.min.js"></script>
<script src="<?php echo _GetDomain; ?>js/jquery.zoom.min.js"></script>
<script src="<?php echo _GetDomain; ?>js/main.js"></script>

<script type="text/javascript">
    
    $('.agregacarro').click(function(){
        
        var referencia		= $(this).attr('rel'); //id del elemento
        var bla             = '1' //cantidad seleccionada
        var url             = "<?php echo _GetDomain; ?>carrito-accion.php?idpro="+referencia+"&accion=sumform&cantidad=" + bla;
        window.location.href= url;
        
	});


    $(document).ready(function() {

        $('input[type="checkbox"]').click(function() {

            var $checked = $('input[type="checkbox"]:checked');
            var $productsDiv = $('.resfiltro');

            if ($checked.length > 0) {

                $productsDiv.hide();

                $checked.each(function() {
                    var actual  = $(this).val();
                    $('.' + actual ).fadeIn();

                    $('html, body').animate({
                        scrollTop: $('#breadcrumb').offset().top - 150 
                    }, 1000, 'swing');

                });

            } else {
                $productsDiv.fadeIn();
            }
        });

    });


    if ( $("#hastaca").length > 0 ) {
        $('html, body').animate({
            scrollTop: $('#hastaca').offset().top - 150 
        }, 1000, 'swing');
    }

</script>


<script src="<?php echo _GetDomain; ?>js/typeahead.bundle.js" type="text/javascript"></script>       
<script>
$(document).ready(function() {
    var numbers = new Bloodhound({
        datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.num); },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: [
<?php 			
$autoc	= $mysqli->query("
SELECT nombre,codigo,medida FROM productos 
WHERE productos.categoria = '7' 
AND activo='1' 
AND stock='1' 
");

while($autorow	= $autoc->fetch_assoc()){
echo "{num:'".Quitar($autorow['nombre'])."'},";
echo "{num:'".$autorow['codigo']."'},";
if($autorow['medida']!=''){echo "{num:'".$autorow['medida']."'},";}
}?>
        ]
    });
        
    numbers.initialize();
        
    $('.autocompletar').typeahead(null, {
        displayKey: 'num',
        source: numbers.ttAdapter()
    });


});
</script>
