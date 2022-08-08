<?php
session_start();
$token = $_POST["token_ws"];
//print_r($_POST);
// obetner la transaccion que tenga el token asociado
// $transaction = Transaction::getByToken($token);
//-INFO BASICA
$oc = $_SESSION["nCotizacion"];
// $oc = "92";
include 'includes/conx.php';
$datos_transbank = array();
$re = mysql_query("SELECT * FROM transbank WHERE oc = '$oc'") or die(mysql_error());
while($f = mysql_fetch_array($re)){
  $datos_transbank = array("oc" => $f["oc"], "total" => $f["total"], "estado" => $f["estado"], "response" => $f["response"] ,"fecha" => $f["fecha"], "cod_autorizacion" => $f["cod_aut"],
                                    "t_tarjeta" => $f["t_tarjeta"], "n_cuotas" => $f["n_ctas"], "valor_cuotas" => $f["c_tas"], "n_tarjeta" => $f["n_tarjeta"] );
}
$productos = array();
$oc2 = $_SESSION["idunica"];
$re = mysql_query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica = '$oc2'") or die(mysql_error());
while($f = mysql_fetch_array($re)){
   $total = $f["tmp_valor"] * 1.19;
   array_push($productos,array("codigo" => $f["tmp_codigo"], "nombre" => $f["tmp_nombre"], "cantidad" => $f["tmp_cantidad"], "valor" => $total));
}
mysql_close();
require('funciones/conexion.php');
require('funciones/funciones.php');
#borra segun creador
unset($_SESSION["array_cotizacion"]);
session_destroy();
$url = "Gracias";
$pmenu = "Gracias";
$pagina = title_web($url);
  ?>
  <!DOCTYPE html>
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
                <li><a href="<?echo _GetDomain; ?>">Portada</a></li>
                <li><a href="javascript:void(0);"><?php echo $url; ?></a></li>
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
          <div class="col-md-7">
            <?php
              if($datos_transbank["response"] == "0"){
                ?>
                <div class="row">
                  <h3>Gracias por su Compra</h3>
                  <p>Uno de nuestros ejecutivos se contactara con usted para continuar el proceso.</p>
                  <p>Gracias por su preferencia.</p>
                  <p><strong>Nº Pedido: </strong><?php echo $datos_transbank["oc"]; ?><br></p>
                  <p><strong>Nº Cotización: </strong><?php echo $datos_transbank["oc"]; ?><br></p>
                  <!-- <p><strong>Neumachile</strong><br></p> -->
                  <p><strong>Cod Autorizacion: </strong><?php echo $datos_transbank["cod_autorizacion"]; ?><br></p>
                  <p><strong>Fecha Transacción: </strong><?php echo $datos_transbank["fecha"]; ?><br></p>
                  <p><strong>Tipo de Tarjeta: </strong>
                    <?php
                      $tipoTarjeta = $datos_transbank["t_tarjeta"];
                      if($tipoTarjeta == "VD"){
                        echo "Tarjeta Debito";
                      }else{
                        echo "Tarjeta Credito";
                      }
                    ?>
                    <br></p>
                    <?php
                      if($tipoTarjeta == "VD" OR $tipoTarjeta == "VN"){
                      }else{
                        echo "<p><strong>Tipo de Cuotas: </strong>"."En Cuotas"."<br></p>";
                      }
                    ?>
                    <?php
                      if($tipoTarjeta == "VD" OR $tipoTarjeta == "VN"){
                      }else{
                        ?>
                        <p><strong>Cant. de Cuotas: </strong><?php echo $datos_transbank["n_cuotas"]; ?><br></p>
                        <?php
                      }
                     ?>
                  <p><strong>Nº Tarjeta (ult 4 dig): </strong><?php echo $datos_transbank["n_tarjeta"]; ?><br><br><br></p>
                  <a href="<?php echo _GetDomain; ?>" class="primary-btn order-submit"> Volver a la portada </a><br>
                </div>
                <div class="row">
                  <div class="section-title text-center">
      							<h3 class="title">Detalle</h3>
      						</div>
                  <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Codigo</th>
                      <th scope="col">Nombre</th>
                      <th scope="col">Valor</th>
                      <th scope="col">Cant</th>
                      <th scope="col">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $cont = 1;
                      for ($i=0; $i < count($productos) ; $i++) {
                        $total = $productos[$i]["valor"] * $productos[$i]["cantidad"];
                        ?>
                          <tr>
                            <th scope="row"><?php echo $cont; ?></th>
                            <td><?php echo $productos[$i]["codigo"]; ?></td>
                            <td><?php echo $productos[$i]["nombre"]; ?></td>
                            <td><?php echo $productos[$i]["valor"]; ?></td>
                            <td><?php echo $productos[$i]["cantidad"]; ?></td>
                            <td><?php echo number_format($total,0,'','.'); ?></td>
                          </tr>
                        <?php
                        $cont ++;
                      }
                     ?>
                  </tbody>
                  </table>
                  <div class="order-summary">
                    <div class="order-col">
      								<div style="padding: 0 15px;"><strong>SUBTOTAL NETO</strong></div>
      								<div style="padding: 0 30px;"><strong>$ <?php echo carro_valor($_SESSION["idunica"]); ?></strong></div>
      							</div>
      							<div class="order-col">
      								<div style="padding: 0 15px;"><strong>IVA (19%)</strong></div>
      								<div style="padding: 0 30px;"><strong>$ <?php echo carro_iva2($_SESSION["idunica"]); ?></strong></div>
      							</div>
      							<div class="order-col">
      								<div style="padding: 0 15px;"><strong>TOTAL</strong></div>
      								<div style="padding: 0 30px;"><strong class="order-total"> $ <?php echo carro_valoriva($_SESSION["idunica"]); ?></strong> c/iva</div>
      							</div>
                 </div>
                </div>
                <?php
              }else{
                ?>
                  <h3>Ocurrió un error</h3>
                  <p>Las posibles causas de este rechazo son:</p>
                  <p>* Error en el ingreso de los datos de su tarjeta de Crédito o Débito (fecha y/o código de seguridad).</p>
                  <p>* Su tarjeta de Crédito o Débito no cuenta con saldo suficiente.</p>
                  <p>* Tarjeta aún no habilitada en el sistema financiero.</p>
                  <p>* Tu dispostivo de verificación no tiene internet</p>
                  <p>* Cancelo el proceso de pago.</p>
                <?php
              }
             ?>
          </div>
          <!-- Order Details -->
          <div class="col-md-5">
            <div class="section-title text-center">
              <img src="img/img_contacto.jpg" class="img-responsive">
            </div>
          </div>
          <!-- /Order Details -->
        </div>
        <!-- /row -->
      </div>
      <!-- /container -->
    </div>
    <!-- /SECTION -->
    <?php include('includes/footer.php'); ?>
  </body>
  </html>
