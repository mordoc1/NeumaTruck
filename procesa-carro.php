<?php
session_set_cookie_params(30);
header("Content-Type: text/html;charset=utf-8");
session_start();
require('funciones/conexion.php');
require('funciones/funciones.php');


$sqlCarro		= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' ");
$total_carro	= $sqlCarro->num_rows;

if($total_carro > 0){
	if(isset($_POST['email']) && isset($_POST['rut_empresa'])){

		//DATOS BASICOS
		$OC_rut_empresa		= $mysqli->real_escape_string(trim($_POST['rut_empresa'])); // rut empresa
		$OC_razon_social	= $mysqli->real_escape_string(trim(utf8_decode($_POST['razon_social']))); // nompre empresa
		$OC_email			= $mysqli->real_escape_string(trim($_POST['email'])); // email contacto
		$OC_fono			= $mysqli->real_escape_string(trim($_POST['fono'])); // fono contacto
		$OC_contacto		= $mysqli->real_escape_string(trim(utf8_decode($_POST['contacto']))); // nombre persona que solicita
		$OC_comentario		= $mysqli->real_escape_string(trim(utf8_decode($_POST['mensaje'])));

		//CARRO
		$OC_item			= trim(carro_item($_SESSION["idunica"]));
		$OC_iva				= trim(carro_iva($_SESSION["idunica"])); //valor de iva
		$OC_subtotal_carro	= trim(carro_valor2($_SESSION["idunica"]));; //valor de carro total
		$OC_total_carro		= trim(carro_valor2iva($_SESSION["idunica"])); //valor de carro + iva
		$OC_despacho		= 0;
		$OC_direccion 		= utf8_decode($_POST["direccion"]);

		//NUEVO TOTAL FINAL ------------------------------------------------------------

		$_SESSION["total_a_pagar"] = $OC_total_carro;
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
														comentario,
														direccion) VALUES ('$OC_rut_empresa',
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
																			'$OC_comentario',
																			'$OC_direccion')");

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
				$valor_temporal2 = $valor_temporal;
				$valor_temporal		= Moneda($valor_temporal);//formateo de numero
				$DetalleProductos	.= '<tr><td align="left">'.$OCD_codigo.' '.$OCD_nombre.' X '.$OCD_cantidad.'</td><td align="right">$ '.$valor_temporal.'</td></tr>';//creo red de tablas para email

				$sqlOCdetalle	= $mysqli->query("INSERT INTO oc_detalle_truck (id_oc,id_producto,codigo,valor,nombre,cantidad,fecha) VALUES('$OC_id','$OCD_id','$OCD_codigo','$OCD_valor','$OCD_nombre','$OCD_cantidad','$OC_fecha')");
				// GUARDO EL DATOS EN MI DB
				$link = mysql_connect("localhost", "neum45356_neumatruck", "7340458Tao");
mysql_select_db("neum45356_neumatruck",$link) OR DIE ("Error: No es posible establecer la conexión");
mysql_set_charset('utf8');
				$insertar = mysql_query("INSERT INTO comprados (oc, codigo, nombre, valor,cantidad,total ) VALUES ('$OC_id','$OCD_codigo','$OCD_nombre','$OCD_valor','$OCD_cantidad','$valor_temporal2')") or die(mysql_error());
				mysql_query($insertar);
				mysql_close();

			}//-while
			$datos_array = array("rut" => $OC_rut_empresa,"rs" => $OC_razon_social, "email" => $OC_email, "fono" => $OC_fono,
								"contacto" => $OC_contacto, "fecha" => $OC_fecha, "msj" => $OC_comentario, "oc" => $OC_id,
								"detalleProductos" => $DetalleProductos,"subtotal" => $OC_subtotal_carro, "iva" => $OC_iva,
								"total" => $OC_total_carro, "direccion" => $OC_direccion);

			$_SESSION["array_cotizacion"] = $datos_array;


			if(isset($sqlCarro)){


				header('location:'. _GetDomain .'pagar.php'); 
				exit();

			} else {
				header('location:'. _GetDomain .'checkout.php?error=error');
			}	// if email
		} else {
			header('location:'. _GetDomain .'checkout.php?error=error');
		}	//- if oc
	} else {
		header('location:'. _GetDomain .'checkout.php?error=datos');
	} // if datos
} else {
	header('location:'._GetDomain.'?error');
	}//- carro vacio

?>
