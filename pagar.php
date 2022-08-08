<?php
////////////////////////////////////////////////////////////////////////////////
//   34933758    -   597034933758                                             //
////////////////////////////////////////////////////////////////////////////////
session_start();

$n_cotizacion = $_SESSION["OC_id"];
$valor_apagar = $_SESSION["total_a_pagar"];
$_SESSION["array_cotizacion"] = $_SESSION["array_cotizacion"];

$fecha = date("d/m/Y");
unset($_SESSION["total_a_pagar"]);
// se guarda transaccion

// include 'includes/conx.php';
$link = mysql_connect("localhost", "neum45356_neumatruck", "7340458Tao");
mysql_select_db("neum45356_neumatruck",$link) OR DIE ("Error: No es posible establecer la conexión");
mysql_set_charset('utf8');
$insertar = mysql_query("INSERT INTO transbank (oc,total,estado,fecha ) VALUES ('$n_cotizacion','$valor_apagar','pendiente','$fecha')") or die(mysql_error());

mysql_query($insertar);

mysql_close();

require_once './vendor/autoload.php';

use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\TransbankServiceFactory;
use Freshwork\Transbank\RedirectorHelper;

// Genera las key para testeo
// $bag = CertificationBagFactory::integrationWebpayNormal();
// Genera Keys para la "Produccion"
$bag = CertificationBagFactory::production('cert/597034933758.key', 'cert/597034933758.crt'); //<==== KEY

///////////
$webpay = TransbankServiceFactory::normal($bag);
//////////
$webpay->addTransactionDetail($valor_apagar,$n_cotizacion );
$response = $webpay->initTransaction('https://www.neumatruck.cl/webpayretorno.php', 'https://www.neumatruck.cl/webpayfinal.php'); 

// retorna el formulari con el token
$token = $response->token;
// print_r($token);
// guardar datos ya que no se genera correctamente


echo \Freshwork\Transbank\RedirectorHelper::redirectHTML($response->url, $response->token);
?>
