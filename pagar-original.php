<?php

////////////////////////////////////////////////////////////////////////////////
//   34933758    -   597034933758   -597020000540                              //
////////////////////////////////////////////////////////////////////////////////

session_start();
$n_cotizacion = $_SESSION["OC_id"];
$valor_apagar = $_SESSION["total_a_pagar"];
$fecha = date("d/m/Y");
unset($_SESSION["total_a_pagar"]);


// se guarda transaccion
include 'includes/conx.php';
$insertar = mysql_query("INSERT INTO transbank (oc,total,estado,fecha ) VALUES ('$n_cotizacion','$valor_apagar','pendiente','$fecha')") or die(mysql_error());
mysql_query($insertar);
mysql_close();

include 'vendor/autoload.php';

use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\TransbankServiceFactory;
use Freshwork\Transbank\RedirectorHelper;

// aqui deberia tomar la llave de los arhivos
$bag = CertificationBagFactory::integrationWebpayNormal();
///////////
$webpay = TransbankServiceFactory::normal($bag);
//////////
$webpay->addTransactionDetail($valor_apagar,$n_cotizacion );
$response = $webpay->initTransaction('https://www.neumabaterias.cl/webpayretorno.php', 'https://www.neumabaterias.cl/webpayfinal.php');

// retorna el formulari con el token
$token = $response->token;
// print_r($token);

echo \Freshwork\Transbank\RedirectorHelper::redirectHTML($response->url, $response->token);
// muestro el token
// print_r($token);

?>
