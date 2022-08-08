<?php



require('funciones/conexion.php');

require('funciones/funciones.php');

require('funciones/funciones_aux.php');



$st_of2 = 0;
		$st_of1 = 0;
	
		$re = mysql_query("SELECT resultado FROM configuracion WHERE tipo = 'ofertas'") or die(mysql_error());
		while($f = mysql_fetch_array($re)){
		  $st_of1 = $f['resultado'];
		}
	
	
		$re = mysql_query("SELECT resultado FROM configuracion WHERE tipo = 'of'") or die(mysql_error());
		  while($f = mysql_fetch_array($re)){
			$st_of2 = $f['resultado'];
		}

session_start();






  //echo '<pre>'.var_dump($_SESSION).'</pre>';

  //echo '<pre>'.var_dump($_GET).'</pre>';

  //echo '<pre>'.var_dump($_SERVER["HTTP_REFERER"]).'</pre>';

  //exit();



if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !='' ){



	if(isset($_GET['idpro']) && $_GET['idpro'] !=''){

		if(isset($_GET['accion']) && $_GET['accion']!=''){

		if(is_numeric($_GET['idpro'])){

			if(isset($_SESSION["idunica"]) && $_SESSION["idunica"] !=''){





		$idPro     = $mysqli->real_escape_string(RemoveXSS($_GET['idpro']));



		// consulto datos del producto

		$sqlValida	= $mysqli->query("SELECT id, codigo, nombre, v_publicado, oferta, val_oferta FROM productos WHERE id='$idPro' LIMIT 1");

		$sqlValidaT	= $sqlValida->num_rows;



		if(isset($sqlValidaT) && $sqlValidaT !='0'){



			$rowValida	= $sqlValida->fetch_assoc();



			//Busco Oferta

			if ( $st_of1 == 1 AND $rowValida["oferta"] == 1 OR $st_of2 == 1 AND $rowValida["oferta"] == 2 ) {

				$precio = $rowValida['val_oferta'] * _AumentoValor;

			} else {

				$precio = $rowValida['v_publicado'] * _AumentoValor;

			}





				if($_GET['accion'] == 'add'){



					$sql	= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' AND tmp_idproducto='".$rowValida['id']."' ");

					$total	= $sql->num_rows;



					if($total == 0){

						$sql = "INSERT INTO tmp_carro_truck (tmp_idunica, tmp_idproducto, tmp_codigo, tmp_nombre, tmp_cantidad, tmp_valor) VALUES ('".$_SESSION["idunica"]."','".$rowValida['id']."','".$rowValida['codigo']."', '".$rowValida['nombre']."', '1', '".$precio."') ";



						$sqlAdd	= $mysqli->query($sql) or die("MYSQL ERROR ACCION ".mysql_error());

						$_SESSION["resultado"]	= "Producto agregado con éxito.";

						header('location:'.$_SERVER["HTTP_REFERER"]);

						exit();



					} else {



						$sql = "UPDATE tmp_carro_truck SET tmp_cantidad=tmp_cantidad+1 WHERE tmp_idunica='".$_SESSION["idunica"]."'  AND tmp_idproducto='".$rowValida['id']."' ";

						$sqlAddS	= $mysqli->query($sql) or die ("MYSQL ERROR UPDATE".mysql_error());

						$_SESSION["resultado"]	= "Carro de compras actualizado con éxito.";

						header('location:'.$_SERVER["HTTP_REFERER"]);

						exit();



					}



				}//-add







				if($_GET['accion'] == 'sum'){



					$sql_sum = "SELECT * FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' AND tmp_idproducto='".$rowValida['id']."' ";

					$sql	= $mysqli->query($sql_sum) or die ("ERROR MYSQL SUM ".mysql_error());

					$total	= $sql->num_rows;



					if($total == 0){



						$sql_total0 = "INSERT INTO tmp_carro_truck (tmp_idunica, tmp_idproducto, tmp_codigo, tmp_nombre, tmp_cantidad, tmp_valor) VALUES ('".$_SESSION["idunica"]."','".$rowValida['id']."', '".$rowValida['codigo']."', '".$rowValida['nombre']."', '1', '".$precio."') ";



						$sqlAdd	= $mysqli->query($sql_total0) or die("ERROR MYSQL TOTAL".mysql_error());



						$_SESSION["resultado"]	= "Producto agregado con éxito.";

						header('location:'.$_SERVER["HTTP_REFERER"]);

						exit();



					} else {





						$sqlad = "UPDATE tmp_carro_truck SET tmp_cantidad=tmp_cantidad+1 WHERE tmp_idunica='".$_SESSION["idunica"]."' AND tmp_idproducto='".$rowValida['id']."' ";

						$sqlAddS	= $mysqli->query($sqlad) or die ("ERROR MYSQL ADDS".mysql_error());

						$_SESSION["resultado"]	= "Carro de compras actualizado con éxito.";

						header('location:'.$_SERVER["HTTP_REFERER"]);



						}



				}//-sum





				if($_GET['accion'] == 'sub'){



				$sql	= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' AND tmp_idproducto='".$rowValida['id']."' ");

				$total	= $sql->num_rows;



					if($total == 0){

						header('location:'.$_SERVER["HTTP_REFERER"]);

					} else {



					$row_carro	= $sql->fetch_assoc();

					$cantidad	= $row_carro['tmp_cantidad'];



						if($cantidad == 1){



							$sqlSubS = $mysqli->query("DELETE FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' AND tmp_idproducto='".$rowValida['id']."'");

							$_SESSION["resultado"]	= "Producto eliminado con éxito.";

							header('location:'.$_SERVER["HTTP_REFERER"]);

							exit();



						} else {



							$sqlSubS	= $mysqli->query("UPDATE tmp_carro_truck SET tmp_cantidad=tmp_cantidad-1 WHERE tmp_idunica='".$_SESSION["idunica"]."'  AND tmp_idproducto='".$rowValida['id']."' ");

							$_SESSION["resultado"]	= "Carro de compras actualizado con éxito.";

							header('location:'.$_SERVER["HTTP_REFERER"]);

							exit();

							}



					}



				}//-sub





				if($_GET['accion'] == 'remove'){

					$mysqli->query("DELETE FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' AND tmp_idproducto='".$rowValida['id']."' ");

					$_SESSION["resultado"]	= "Producto eliminado de su carro de compras.";

					header('location:'.$_SERVER["HTTP_REFERER"]);

					exit();

				}//-remove



				if($_GET['accion'] == 'sumform'){

					$cantidad	= $mysqli->real_escape_string(trim($_GET['cantidad']));



					$sql	= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='".$_SESSION["idunica"]."' AND tmp_idproducto='".$rowValida['id']."' ");

					$total	= $sql->num_rows;





					if($total == 0){



						$sqlAdd	= $mysqli->query("INSERT INTO tmp_carro_truck (tmp_idunica, tmp_idproducto, tmp_codigo,  tmp_nombre, tmp_cantidad, tmp_valor) VALUES ('".$_SESSION["idunica"]."','".$rowValida['id']."', '".$rowValida['codigo']."', '".$rowValida['nombre']."', '$cantidad', '".$precio."' ) ") or die(mysql_error());

						// echo "==HGOLA 5=== ".$total;

						$_SESSION["resultado"]	= "Producto agregado con éxito.";

						header('location:'.$_SERVER["HTTP_REFERER"]);

						exit();



					} else {

						$sqlAddS	= $mysqli->query("UPDATE tmp_carro_truck SET tmp_cantidad='$cantidad' WHERE tmp_idunica='".$_SESSION["idunica"]."' AND tmp_idproducto='".$rowValida['id']."' ");

						$_SESSION["resultado"]	= "Carro de compras actualizado con éxito.";

						header('location:'.$_SERVER["HTTP_REFERER"]);

						exit();



					}





				}//-sumform



				header('location:'.$_SERVER["HTTP_REFERER"]);//TRUE/FALSE



			} else { header('location:'.$_SERVER["HTTP_REFERER"]);}

		} else { header('location:'.$_SERVER["HTTP_REFERER"]);}

	} else { header('location:'.$_SERVER["HTTP_REFERER"]);}

	} else { header('location:'.$_SERVER["HTTP_REFERER"]);}

} else { header('location:'.$_SERVER["HTTP_REFERER"]); }



}

?>

