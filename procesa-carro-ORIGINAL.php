<?php
session_start(); 
require('funciones/conexion.php');
require('funciones/funciones.php');


$sqlCarro		= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' ");
$total_carro	= $sqlCarro->num_rows;

if($total_carro > 0){
	if(isset($_POST['email']) && isset($_POST['rut_empresa'])){

		//DATOS BASICOS
		$OC_rut_empresa		= $mysqli->real_escape_string(trim($_POST['rut_empresa'])); // rut empresa
		$OC_razon_social	= $mysqli->real_escape_string(trim($_POST['razon_social'])); // nompre empresa
		$OC_email			= $mysqli->real_escape_string(trim($_POST['email'])); // email contacto
		$OC_fono			= $mysqli->real_escape_string(trim($_POST['fono'])); // fono contacto
		$OC_contacto		= $mysqli->real_escape_string(trim($_POST['contacto'])); // nombre persona que solicita
		$OC_comentario		= $mysqli->real_escape_string(trim($_POST['mensaje']));

		//CARRO
		$OC_item			= trim(carro_item($_SESSION["idunica"]));
		$OC_iva				= trim(carro_iva($_SESSION["idunica"])); //valor de iva
		$OC_subtotal_carro	= trim(carro_valor2($_SESSION["idunica"]));; //valor de carro total
		$OC_total_carro		= trim(carro_valor2iva($_SESSION["idunica"])); //valor de carro + iva
		$OC_despacho		= 0;
		//NUEVO TOTAL FINAL ------------------------------------------------------------


		$OC_fecha			= date('d-m-Y H:i:s');

		//GUARDO LOS DATOS DE LA OC
		$sqlOC	= $mysqli->query("INSERT INTO oc_truck (rut_empresa,
														razon_social,
														email,
														fono,
														contacto,
														item,
														iva,
														subtotal,
														total,
														fecha,
														estado,
														visto,
														comentario) VALUES ('$OC_rut_empresa',
																			'$OC_razon_social',
																			'$OC_email',
																			'$OC_fono',
																			'$OC_contacto',
																			'$OC_item',
																			'$OC_iva',
																			'$OC_subtotal_carro',
																			'$OC_total_carro',
																			'$OC_fecha',
																			'1',
																			'0',
																			'$OC_comentario')");

		//echo $mysqli->error;
		//exit();

		$OC_id				= $mysqli->insert_id;
		$_SESSION["OC_id"]	= $OC_id;

		if(isset($sqlOC)){

			$DetalleProductos	= '';//seteo variable para anidar datos posteriormente
			$valor_temporal		= 0; //puesta a 0 para

			$sqlCarro		= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' ");

			while($row_carro	= $sqlCarro->fetch_assoc()){

				$OCD_id				= $mysqli->real_escape_string(trim($row_carro['tmp_idproducto']));
				$OCD_valor			= $mysqli->real_escape_string(trim($row_carro['tmp_valor']));
				$OCD_nombre			= $mysqli->real_escape_string(trim($row_carro['tmp_nombre']));
				$OCD_cantidad		= $mysqli->real_escape_string(trim($row_carro['tmp_cantidad']));
				$OCD_codigo			= $mysqli->real_escape_string(trim($row_carro['tmp_codigo']));

				$valor_temporal		= 0; //puesta a 0 para  cada itinerancia

				$valor_temporal 	= $OCD_valor * $OCD_cantidad;//total producto
				$valor_temporal		= Moneda($valor_temporal);//formateo de numero
				$DetalleProductos	.= '<tr><td align="left">'.$OCD_codigo.' '.$OCD_nombre.' X '.$OCD_cantidad.'</td><td align="right">$ '.$valor_temporal.'</td></tr>';//creo red de tablas para email

				$sqlOCdetalle	= $mysqli->query("INSERT INTO oc_detalle_truck (id_oc,id_producto,codigo,valor,nombre,cantidad,fecha) VALUES('$OC_id','$OCD_id','$OCD_codigo','$OCD_valor','$OCD_nombre','$OCD_cantidad','$OC_fecha')");
				//echo $mysqli->error;
				//exit();
			}//-while

			if(isset($sqlCarro)){

				require 'includes/phpmailer/PHPMailerAutoload.php';

				// Details
				$system_name 	= 'Neumatruck';
				$system_email 	= "contacto@neumatruck.cl"; //email que envia mensajes desde el servidor

				// Send Email to Client
				$message = file_get_contents('includes/template-formulario-compra.php');

				$message = str_replace('[cliente_razon]', $OC_razon_social, $message);
				$message = str_replace('[cliente_rut]', $OC_rut_empresa, $message);
				$message = str_replace('[cliente_email]',$OC_email, $message);
				$message = str_replace('[cliente_telefono]', $OC_fono, $message);
				$message = str_replace('[cliente_contacto]', $OC_contacto, $message);

				$message = str_replace('[oc_fecha]', $OC_fecha, $message);
				$message = str_replace('[oc_numero]', $OC_id, $message);
				$message = str_replace('[oc_mensaje]', nl2br($OC_comentario), $message);

				//crear anidado de las compras realizadas en html -> table
				$message = str_replace('[detalle_productos]', $DetalleProductos, $message);

				$message = str_replace('[oc_subtotal]', Moneda($OC_subtotal_carro), $message);
				$message = str_replace('[oc_iva]', Moneda($OC_iva), $message);
				$message = str_replace('[oc_cdespacho]','[por confirmar]', $message);
				$message = str_replace('[oc_totaldespacho]', Moneda($OC_total_carro), $message);


				$mail = new PHPMailer;
				$mail->CharSet = "UTF-8";
				$mail->setFrom($system_email, $system_name); //quien envia
				$mail->addAddress($OC_email, $OC_contacto); //donde envia
				$mail->Subject = 'Cotización en '.$system_name.' - OC Nº '.$OC_id; //asunto
				$mail->MsgHTML($message);
				$mail->IsHTML(true);
				$mail->send();

				// EMAIL A ADMINISTRADORES
				$mail = new PHPMailer;
				$mail->CharSet = "UTF-8";
				$mail->setFrom($system_email, $system_name);
				$mail->SMTPDebug 	= 4;
				//$mail->addAddress($system_email, $system_name);//sistema
				$mail->AddReplyTo($OC_email, $OC_contacto);
				$mail->addAddress("taoista.games@gmail.com", $system_name);
				//$mail->addAddress('jmedina@neumachile.cl', 'jmedina');//a quien va email
				//$mail->addAddress('aveliz@neumachile.cl', 'aveliz');//a quien va email
				//$mail->addAddress('jortiz@neumachile.cl', 'jortiz');//a quien va email
				//$mail->addAddress('cnunez@neumachile.cl', 'cnunez');//a quien va email
				//$mail->addAddress('vmiranda@neumachile.cl', 'vmiranda');//a quien va email
				//$mail->addAddress('imorales@neumachile.cl', 'imorales');//a quien va email
				//$mail->addAddress('mguzman@neumachile.cl', 'mguzman');//a quien va email


				$mail->Subject = 'Cotizacion en '.$system_name.' - Nº '.$OC_id; //asunto
				$mail->MsgHTML($message);
				$mail->IsHTML(true);
				$mail->send();

				header('location:'. _GetDomain .'gracias.php');
				exit();


			} else { header('location:'. _GetDomain .'checkout.php?error=error');}	// if email

		} else { header('location:'. _GetDomain .'checkout.php?error=error');}	//- if oc

	} else { header('location:'. _GetDomain .'checkout.php?error=datos');} // if datos
} else { header('location:'._GetDomain.'?error'); }//- carro vacio

?>
