<?php
////////////////////////////////////////////////////////////////////////////////
//   								34933758                                  //
////////////////////////////////////////////////////////////////////////////////
session_start();
include 'vendor/autoload.php';
include 'includes/conx.php';
$dato = $_SESSION["array_cotizacion"];
$fecha_dat = date("d/m/Y");
//toma los productos

// SELECIONAR DATOS DEL CLIENTE

use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\TransbankServiceFactory;
use Freshwork\Transbank\RedirectorHelper;

// $bag = CertificationBagFactory::integrationWebpayNormal();
$bag = CertificationBagFactory::production('cert/597034933758.key', 'cert/597034933758.crt'); // <==== KEY
$webpay = TransbankServiceFactory::normal($bag);
// resultado de la transaccion6
$resutl = $webpay->getTransactionResult();
// => [buyOrder] - [cardNumber] - [responseCode] == 0 => "Aprobada"
$token = $_POST["token_ws"];
// guardar resultado en la db
if($resutl->detailOutput->responseCode == 0){
  // update resultado db (aprobado) guardarlo el token para compararlo al final
  $oc = $resutl->detailOutput->buyOrder;//
  $_SESSION["nCotizacion"] = $resutl->detailOutput->buyOrder;
  $response = $resutl->detailOutput->responseCode; // => $_SESSION["responseCode"]
  $dateTBK = $resutl->transactionDate; // => $_SESSION["fechaTransaccion"]
  $codAutorizacion = $resutl->detailOutput->authorizationCode; // => $_SESSION["codAutorizacion"]
  $tipoPago = $resutl->detailOutput->paymentTypeCode; // => $_SESSION["tipoPago"]
  $cuotas = $resutl->detailOutput->sharesNumber; // => $_SESSION["cuotas"]
  $vCuotas = $resutl->detailOutput->sharesAmount; // => $_SESSION["cuotas"]
  $nTarjeta = $resutl->cardDetail->cardNumber; // => $_SESSION["nTarjeta"]
  // guarda en base de datos
  $insertar = mysql_query("UPDATE transbank SET ws_token = '$token' ,estado = 'aceptada',response = '$response' ,fechatbk = '$dateTBK', cod_aut = '$codAutorizacion', t_tarjeta = '$tipoPago', n_ctas = '$cuotas', c_ctas = '$vCuotas' ,n_tarjeta = '$nTarjeta'  WHERE oc ='$oc' ") or die(mysql_error());
  mysql_query($insertar);
  // TOMA DATOS CLIENTES
  $oc_truck = $_SESSION["nCotizacion"];
  $datos_cliente;
  $re = mysql_query("SELECT * FROM oc_truck WHERE id = '$oc_truck'") or die(mysql_error());
          while($f = mysql_fetch_array($re)){
            $datos_cliente = array("rut" => $f["rut_empresa"], "contacto" => $f["contacto"], "razon_social" => $f["razon_social"],
                                            "email" => $f["email"], "telefono" => $f["fono"], "fecha" => $fecha_dat, "oc" => $oc_truck,
                                            "direccion" => $f["direccion"], "msg" => $f["comentario"]);

  }

  // leer corereos
  $resp_nombre = "";
  $resp_telefono = "";
  $resp_email = "";
  $re = mysql_query("SELECT phone, responsable, emial FROM telefonos WHERE id = 1") or die(mysql_error());
          while($f = mysql_fetch_array($re)){
            $resp_nombre = $f["responsable"];
            $resp_telefono = $f["phone"];
            $resp_email = $f["emial"];
  }
  // TOMA LOS PRODUCTOS COTIZADOS
  $detalleProductos = array();
  $sum_demo = array();
  $re = mysql_query("SELECT * FROM comprados WHERE oc = '$oc_truck'") or die(mysql_error());
          while($f = mysql_fetch_array($re)){
            $c_u = $f["valor"] * 1.19;
            $c_total = $f["total"] * 1.19;
            array_push($detalleProductos,array("id" => $f["id"], "oc" => $f["oc"], "codigo" => $f["codigo"], "nombre" => $f["nombre"],"valor" => $f["valor"] ,"cantidad" => $f["cantidad"], "total" => $f["total"]));
            array_push($sum_demo,$f["total"]);
  }
  mysql_close();

        $neto = array_sum($sum_demo);
        $iva = $neto * 0.19;
        $total = $neto + $iva;

        $_SESSION["array_error_product"] = $detalleProductos;
        $correo_admin = array($datos_cliente["email"]);
          //  // ENVIA EL CORREO ADMIN
        $cliente_asunto = "neumatruck.cl Cotización Nº".$oc_truck;
        ob_start();
        $contacto = $datos_cliente["contacto"];
        $razon_soc = $datos_cliente["razon_social"];
        $rut = $datos_cliente["rut"];
        $email = $datos_cliente["email"];
        $telefono = $datos_cliente["telefono"];
        $fecha = $datos_cliente["fecha"];
        $n_oc = $datos_cliente["oc"];
        $direccion = $datos_cliente["direccion"];
        $msg = $datos_cliente["msg"];
        $neto = $neto;
        $iva = $iva;
        $total = $total;
        $resp_nombre = $resp_nombre;
        $resp_telefono = $resp_telefono;
        include "includes/mail_compra.php";
        $correo_php = ob_get_contents();
        ob_end_clean();

        $desde  = 'MIME-Version: 1.0' . "\r\n";
        $desde .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $desde .= "From:"."	neumatruck.cl <no-reply@neumatruck.cl>";

        mail($email,$cliente_asunto,$correo_php,$desde);

        $admins = array($resp_email,"aolave@neumachile.cl","luis.olave@ingeniopc.cl",'sjara@neumachile.cl','mhernandez@neumachile.cl','imorales@neumachile.cl');
        // $admins = array("aolave@neumachile.cl");
        for ($i=0; $i < count($admins) ; $i++) {
          mail($admins[$i],$cliente_asunto,$correo_php,$desde);
        }


}else{
  $oc = $resutl->detailOutput->buyOrder;
  //update marcar db rechazada
  $response = $resutl->detailOutput->responseCode;
  $insertar = mysql_query("UPDATE transbank SET ws_token = '$token' ,estado = 'rechazada',response = '$response' WHERE oc ='$oc' ") or die(mysql_error());
  mysql_query($insertar); 
  mysql_close();
}

$webpay->acknowledgeTransaction();
echo RedirectorHelper::redirectBackNormal($resutl->urlRedirection);
?>
