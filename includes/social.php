<?php
include_once("funciones/conx.php");


$datos		= $mysqli->query("SELECT data FROM rrss WHERE id = 1 ");
$row		= $datos->fetch_assoc();
$facebook 	= $row['data'];

$datos		= $mysqli->query("SELECT data FROM rrss WHERE id = 2 ");
$row		= $datos->fetch_assoc();
$phone 		= $row['data'];

$datos		= $mysqli->query("SELECT data FROM rrss WHERE id = 3 ");
$row		= $datos->fetch_assoc();
$instagram 	= $row['data'];

$datos		= $mysqli->query("SELECT data FROM rrss WHERE id = 4 ");
$row		= $datos->fetch_assoc();
$whatsapp 	= $row['data'];

$mysqli->close();



?>
<div class="icon-bar text-center">
	<a target="_blank" style="background-color:#3b5998;" href="<?php echo 'https://www.facebook.com/'.$facebook.'/'?>" class="facebook"><i class="fa fa-facebook"></i></a>
	<a target="_blank" style="background-color:blue;" href="<?php echo 'tel:'.$phone; ?>" class="google"><i class="fa fa-phone"></i></a>
	<a target="_blank" style="background:linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);" href=<?php echo 'https://www.facebook.com/'.$instagram.'/'?>" class="youtube"><i class="fa fa-instagram"></i></a>
	<a target="_blank" style="background-color:#4FCE5D;" href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp; ?>&amp;text=Estoy%20interesado%20en%20sus%20productos"class="twitter"><i class="fa fa-whatsapp"></i></a>
	<!-- <a href="mailto:contacto@neumatruck.cl" class="linkedin"><i class="fa fa-envelope-o"></i></a> -->
</div>


