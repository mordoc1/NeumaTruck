<?php



const _GetDomain 		= 'https://www.neumatruck.cl/';

const _GetOriginal 		= 'https://www.neumatruck.cl/';



//const _AumentoValor		=  1.20;

//const _AumentoValor		=  0.75;

const _AumentoValor		=  1;

// const _GetDomain 		= 'http://localhost/neumatruck/';

// const _GetOriginal 		= 'https://www.ventasneumachile.cl/';



//DEFINCIONES





function productos_index($tipo, $limite) {

	include('conx.php');

	$productos = array();

	// "SELECT p.id, p.codigo,p.estado, p.nombre, p.stock , m.marca, p.medidas, a.aplicacion, p.media, p.oferta, p.val_oferta, p.v_lista, p.v_publicado
	// 					FROM productos AS p
	// 					INNER JOIN aplicaciones AS a
	// 					ON p.aplicacion = a.id_nex
	// 					INNER JOIN marcas AS m
	// 					ON p.marca = m.id_marcas
	// 					WHERE (p.categoria LIKE '$tipo') AND p.v_publicado != 0 ORDER BY p.priority ASC LIMIT $limite"

	$re = mysql_query("SELECT p.id, p.codigo,p.estado, p.nombre, p.stock , m.marca, p.medidas, a.aplicacion, p.media, p.oferta, p.val_oferta, p.v_lista, p.v_publicado
						FROM productos AS p
						INNER JOIN aplicaciones AS a
						ON p.aplicacion = a.id_nex
						INNER JOIN marcas AS m
						ON p.marca = m.id_marcas
						WHERE (p.categoria LIKE '$tipo') AND p.estado = 1 ORDER BY p.priority ASC LIMIT $limite") or die(mysql_error());
	while($f = mysql_fetch_array($re)){
		array_push($productos, array("id" => $f["id"], "estado" => $f["estado"],"codigo" => $f["codigo"], "nombre" => $f["nombre"], "stock" => $f["stock"], 
									"marca" => $f["marca"],"medidas" => $f["medidas"], "aplicacion" => $f["aplicacion"], "media" => $f["media"], 
									"of" => $f["oferta"], "v_oferta" => $f["val_oferta"], "v_lista" => $f["v_lista"], "v_publicado" => $f["v_publicado"]));
	}

	mysql_close();



	return $productos;



}







function title_web($pagina){return " NeumaTruck - ".$pagina;}





function GetDomain(){

   	return _GetDomain;

}



function GetOriginal(){

	return _GetOriginal;

}





function getBanners(){

	include('conx.php');



	$banmners = array();





	$re = mysql_query("SELECT id, img, url FROM sliders WHERE estado = 1") or die(mysql_error());

	while($f = mysql_fetch_array($re)){

	  array_push($banmners, array('id' => $f['id'], 'img' => $f['img'], 'url' => $f['url']));

	}

	mysql_close();





	return $banmners;



}





function getImgNamePopUp(){

  include('conexion.php');

  $img  = '';

  $return = 0;

	$datos	= $mysqli->query("SELECT resultado FROM configuracion WHERE tipo = 'tipo-pop-up' ");

	$row	= $datos->fetch_assoc();

	$return = $row['resultado'];

  $mysqli->close();



  if ($return == 1) {

    $img = 'pop-up';

  }elseif ($return == 2) {

    $img = 'pop-hot';

  }



  return $img;

}





function estadoespecial(){

  include('conexion.php');

	$return = 0;

	$datos	= $mysqli->query("SELECT resultado FROM configuracion WHERE tipo = 'pop-responsive' ");

	$row	= $datos->fetch_assoc();

	$return = $row['resultado'];

  $mysqli->close();

  return $return;

}



function showOtherOferta(){

	include('conexion.php');

	$return = 0;

	$datos	= $mysqli->query("SELECT resultado FROM configuracion WHERE tipo = 'other_of' ");

	$row	= $datos->fetch_assoc();

	$return = $row['resultado'];

    $mysqli->close();

    return $return;

}



function showHotOferta(){

	include('conexion.php');

	$return = 0;

	$datos	= $mysqli->query("SELECT resultado FROM configuracion WHERE tipo = 'oferta_hot' ");

	$row	= $datos->fetch_assoc();

	$return = $row['resultado'];

    $mysqli->close();

    return $return;

}



function RemoveXSS($val) {

	//PASAR STRING A SANEAR

   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);



   $search = 'abcdefghijklmnopqrstuvwxyz';

   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

   $search .= '1234567890!@#$%^&*()';

   $search .= '~`";:?+/={}[]-_|\'\\';

   for ($i = 0; $i < strlen($search); $i++) {



      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);

      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);

   }



   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');

   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');

   $ra = array_merge($ra1, $ra2);



   $found = true;

   while ($found == true) {

      $val_before = $val;

      for ($i = 0; $i < sizeof($ra); $i++) {

         $pattern = '/';

         for ($j = 0; $j < strlen($ra[$i]); $j++) {

            if ($j > 0) {

               $pattern .= '(';

               $pattern .= '(&#[xX]0{0,8}([9ab]);)';

               $pattern .= '|';

               $pattern .= '|(&#0{0,8}([9|10|13]);)';

               $pattern .= ')*';

            }

            $pattern .= $ra[$i][$j];

         }



         $pattern .= '/i';

         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);

         $val = preg_replace($pattern, $replacement, $val);

         if ($val_before == $val) {

            $found = false;

         }

      }

   }



   return $val;

}





function Quitar($val){

	//PASAR VARIABLE A SANEAR

    $nopermitidos		= array("'",'\\','<','>',"\"",";","$","%","&","/","|","{","}","[","]","+","#","€","º","ª");

    $val		 		= str_replace($nopermitidos, "", $val);



    return trim($val);

}



function Quitar5($val){

	//PASAR VARIABLE A SANEAR

    $nopermitidos		= array("'",'\\','<','>',"\"",";","$","%","&","/","|","{","}","[","]","+","#","€","º","ª"," ","-",".");

    $val		 		= str_replace($nopermitidos, "", $val);



    return trim($val);

}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 2- URL



function Url($url){

	//PASAR STRING A CONVERTIR A URL //->SLUG

	$url 	= strtolower(Latino(Quitar(trim($url))));

	$find 	= array('á', 'é', 'í', 'ó', 'ú', 'ñ');

	$repl 	= array('a', 'e', 'i', 'o', 'u', 'n');

	$url 	= str_replace ($find, $repl, $url);



	$find 	= array(' ', '&', '\r\n', '\n', '+');

	$url 	= str_replace ($find, '-', $url);



	$find	= array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');

	$repl 	= array('', '-', '');

	$url	= preg_replace ($find, $repl, $url);



	return $url;

}





function Capitalizar($nombre){



	$find 		= array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');

	$repl 		= array('á', 'é', 'í', 'ó', 'ú', 'ñ');

	$nombre 	= strtolower(str_replace($find, $repl, $nombre));



	// formatea un strin para que cada palabra tenga mayuscula en su primera letra

    $articulos = array(

	//omite

    '0' => 'a',

    '1' => 'de',

    '2' => 'del',

    '3' => 'la',

    '4' => 'los',

    '5' => 'las',

	'6' => 'para',

	'7' => 'desde',

	'8' => 'S.A',

	'9' => 's.a',

	'10' => 'y'

    );



    $palabras 		= explode(' ', $nombre);

    $nuevoNombre 	= '';



    foreach($palabras as $elemento){

        if(in_array(trim(strtolower($elemento)), $articulos)){

            $nuevoNombre .= strtolower($elemento)." ";

            } else {

            	$nuevoNombre .= ucfirst(strtolower($elemento))." ";

            }

    }



    return trim($nuevoNombre);

}



function Latino($palabra){

	//reemplaza palabras con acento o ñ de un string

	$find 		= array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');

	$repl 		= array('a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N');

	$palabra 	= str_replace ($find, $repl, $palabra);



	return $palabra;

}



function Mayusculas($palabra){

	//reemplaza palabras con acento o ñ de un string



	$find 		= array('á', 'é', 'í', 'ó', 'ú', 'ñ');

	$repl 		= array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');

	$palabra 	= str_replace ($find, $repl, $palabra);



	$palabra	= strtoupper($palabra);



	return $palabra;

}



function Resumen($texto,$largo){

	//crea un resumen de un texto con una longitud dada

	$texto		= strip_tags(Latino($texto));

	$resumen 	= substr($texto,0,$largo);

	$editado 	= $resumen.' ...';



	return $editado;

}



function Corto($texto){

	//crea un resumen de un texto con una longitud dada

	$resumen 	= substr($texto,0,'45');



	return $resumen;

}





function Moneda($valor){



	$valor = number_format($valor,0,'','.');



	return $valor;

}



function MonedaTruck($valor){



	$valor	= $valor * _AumentoValor;



	$valor = number_format($valor,0,'','.');



	return $valor;

}



function MonedaTruckIVA($valor){

	$valor	= ($valor * _AumentoValor) * 1.19;

	$valor = number_format($valor,0,'','.');

	return $valor;

}



function MonedaDescuento($valor,$valor2){



	$formato	= '0.'.$valor2;

	$descuento	= $valor * $formato;



	$final		= $valor - $descuento;



	$valor = number_format($final,0,'','.');



	return $valor;

}



function MonedaDescuento2($valor,$valor2){

	$formato	= '0.'.$valor2;

	$descuento	= $valor * $formato;



	$final		= $valor - $descuento;



	return $final;

}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 6- HASH DE DATOS Y ENCRIPTACION



function GeneraId($longitud,$tipo="alfanumerico"){

	//genera un tokem unico alfanumerico

    if ($tipo=="alfanumerico"){

        $exp_reg="[^A-Z0-9]";

    } elseif ($tipo=="numerico"){

        $exp_reg="[^0-9]";

    }



    return substr(preg_replace($exp_reg, "", md5(rand())) .

       preg_replace($exp_reg, "", md5(rand())) .

       preg_replace($exp_reg, "", md5(rand())),

       0, $longitud);

}







function Stock($val){



	if($val == 1){ return "Disponible";	} else if($val == 0){ return "No Disponible";} else { return "undefined";}



}





function CatDependencia($val){

	//muestro nombre de la categoría a que corresponde producto

	include('conexion.php');



	$val	= $mysqli->real_escape_string(trim($val));

	$datos	= $mysqli->query("SELECT id,nombre FROM categorias WHERE id='$val'");



	if(isset($datos)){

		$row	= $datos->fetch_assoc();

        $mysqli->close();

		return $row['nombre'];

	} else {

		return 'undefined';

	}

}



function CatDependenciap($val){

	//muestro nombre de la categoría padre de la categoría que corresponde al producro

	include('conexion.php');

	//leo al hijo

	$val	= $mysqli->real_escape_string(trim($val));

	$datos	= $mysqli->query("SELECT id,dependencia FROM categorias WHERE id='$val'");



	if(isset($datos)){



		$row	= $datos->fetch_assoc();

		$id		= $row['dependencia'];

		//leo al padre

		if($id != 0){



			$datos	= $mysqli->query("SELECT id,dependencia,nombre FROM categorias WHERE id='$id'");

			$row	= $datos->fetch_assoc();

            $mysqli->close();

			return $row['nombre'];



		} else { return '';}



	} else {

		return 'undefined';

	}

}



function CatDependenciape($val){

	//muestro nombre de la categoría padre de la categoría que corresponde al producro

	include('conexion.php');

	//leo al hijo

	$val	= $mysqli->real_escape_string(trim($val));

	$datos	= $mysqli->query("SELECT id,dependencia,nombre FROM categorias WHERE id='$val'");



	if(isset($datos)){



		$row	= $datos->fetch_assoc();

		$id		= $row['dependencia'];

		//leo al padre

		if($id != 0){



			$datos	= $mysqli->query("SELECT id,dependencia,nombre FROM categorias WHERE id='$id'");

			$row	= $datos->fetch_assoc();

            $mysqli->close();

			return $row['nombre'];



		} else { return $row['nombre'];}



	} else {

		return 'undefined';

	}

}



function CatDependenciapp($val){

	//muestro id del la categoría-padre a la categoría que corresponde al producto

	include('conexion.php');



	$val	= $mysqli->real_escape_string(trim($val));

	$datos	= $mysqli->query("SELECT id,dependencia FROM categorias WHERE id='$val'");



	if(isset($datos)){

		$row	= $datos->fetch_assoc();

        $mysqli->close();

		return $row['dependencia'];

	} else {

		return '';

	}

}



function Marcas($val){



	include('conexion.php');



	$val	= $mysqli->real_escape_string(trim($val));

	$datos	= $mysqli->query("SELECT nombre FROM marcas2 WHERE id='$val' LIMIT 1");



	if(isset($datos)){

		$row	= $datos->fetch_assoc();

        $mysqli->close();

		return $row['nombre'];

	} else {

		return 'SIN DEFINIR';

	}

}



function Prioridad($valor){



if($valor == '1'){ return 'Normal';} //usado

else if($valor == '2'){ return 'Oferta';} //usado

else if($valor == '3'){ return 'Novedad';} //NO USADO NEUMACHILE

else if($valor == '4'){ return 'Stock Bajo';}//NO USADO NEUMACHILE

else {return 'undefined';}



}



function Imagen($valor){

	include('conexion.php');



		$val	= $mysqli->real_escape_string(trim($valor));

		$datos	= $mysqli->query("SELECT media FROM productos WHERE id='$val' LIMIT 1");



		if(isset($datos)){

			$row	= $datos->fetch_assoc();

			$mysqli->close();

			return $row['media'];

		} else {

			return 'undefined';

		}

	}



function carro_item($valor){

    include('conexion.php');

    $total 	= 0;

    $valor	= $mysqli->real_escape_string(trim($valor));

    $carro	= $mysqli->query("SELECT SUM(tmp_cantidad) AS total FROM tmp_carro_truck WHERE tmp_idunica='$valor' ");

    $item	= $carro->fetch_assoc();



	if($item['total'] >0){

		$total= $item['total'];

	}

    $mysqli->close();

    return $total;

}







function carro_valor($valor){

include('conexion.php');



	$total 		= 0;

	$valor		= $mysqli->real_escape_string(trim($valor));

	$consulta 	= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='$valor' ");

	echo $mysqli->error;



	while($row_consulta = $consulta->fetch_assoc()){



	  //sacamos subtotal

	  $carroSubtotal = $row_consulta['tmp_cantidad'] * $row_consulta['tmp_valor'];



	  //sacamos total

	   $total = $total + $carroSubtotal;

	}



	return number_format($total,0,'','.');



}



function carro_valoriva($valor){

include('conexion.php');



$iva		= 0.19;

$total 		= 0;

$valor		= $mysqli->real_escape_string(trim($valor));

$consulta 	= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='$valor' ");



	while($row_consulta = $consulta->fetch_assoc()){



	  //sacamos subtotal

	  $carroSubtotal = $row_consulta['tmp_cantidad'] * $row_consulta['tmp_valor'];



	  //sacamos total

	   $total = $total + $carroSubtotal;

	}

	$mysqli->close();

	$subiva 	= round($total * $iva);

	$total 		= $total + $subiva;



	return number_format($total,0,'','.');



}



function carro_valor2($valor){

include('conexion.php');



$total 		= 0;

$valor		= $mysqli->real_escape_string(trim($valor));

$consulta 	= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='$valor' ");



	while($row_consulta = $consulta->fetch_assoc()){



	  //sacamos subtotal

	  $carroSubtotal = $row_consulta['tmp_cantidad'] * $row_consulta['tmp_valor'];



	  //sacamos total

	   $total = $total + $carroSubtotal;

	}

    $mysqli->close();

	return $total;



}



function carro_valor2iva($valor){

include('conexion.php');



$iva		= 0.19;

$total 		= 0;

$valor		= $mysqli->real_escape_string(trim($valor));

$consulta 	= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='$valor' ");



	while($row_consulta = $consulta->fetch_assoc()){

	  //sacamos subtotal

	  $carroSubtotal = $row_consulta['tmp_cantidad'] * $row_consulta['tmp_valor'];

	  //sacamos total

	   $total = $total + $carroSubtotal;

	}

    $mysqli->close();

	$subiva 	= round($total * $iva);

	$total 		= $total + $subiva;



	return $total;



}







function carro_iva($valor){

include('conexion.php');



$iva		= 0.19;

$total 		= 0;

$valor		= $mysqli->real_escape_string(trim($valor));

$consulta 	= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='$valor' ");



	while($row_consulta = $consulta->fetch_assoc()){

	  //sacamos subtotal

	  $carroSubtotal = $row_consulta['tmp_cantidad'] * $row_consulta['tmp_valor'];

	  //sacamos total

	   $total = $total + $carroSubtotal;

	}

    $mysqli->close();

	$subiva 	= round($total * $iva);



	return $subiva;



}



function carro_iva2($valor){

include('conexion.php');



$iva		= 0.19;

$total 		= 0;

$valor		= $mysqli->real_escape_string(trim($valor));

$consulta 	= $mysqli->query("SELECT * FROM tmp_carro_truck WHERE tmp_idunica='$valor' ");



	while($row_consulta = $consulta->fetch_assoc()){

	  //sacamos subtotal

	  $carroSubtotal = $row_consulta['tmp_cantidad'] * $row_consulta['tmp_valor'];

	  //sacamos total

	   $total = $total + $carroSubtotal;

	}

    $mysqli->close();

	$subiva 	= round($total * $iva);



	return number_format($subiva,0,'','.');



}



function Productosxmarca($valor){

include('conexion.php');



	$val	= $mysqli->real_escape_string(trim($valor));



	$total 		= $mysqli->query("SELECT count(*) AS valor FROM productos WHERE activo='1' AND marca='$val' ");

	$row		= $total->fetch_assoc();

	$mysqli->close();

	return $row['valor'];



}



function Marca($valor){

include('conexion.php');



	$val		= $mysqli->real_escape_string(trim($valor));



	$total 		= $mysqli->query("SELECT nombre FROM marcas WHERE id='$val' LIMIT 1 ");

	$row		= $total->fetch_assoc();



    $mysqli->close();

	return $row['nombre'];



}



function MarcaProducto($valor){

	include('conexion.php');



		$val		= $mysqli->real_escape_string($valor); //=> se modifico



		$total 		= $mysqli->query("SELECT marca FROM productos WHERE id='$val' LIMIT 1 ");

		$row		= $total->fetch_assoc();



		$mysqli->close();

		return $row['marca']; //=> se modifico llamaba a Marca();



	}



function CodigoProducto($valor){

include('conexion.php');



	$val		= $mysqli->real_escape_string(trim($valor));



	$total 		= $mysqli->query("SELECT codigo,id FROM productos WHERE id='$val' LIMIT 1 ");

	$row		= $total->fetch_assoc();

	$mysqli->close();

	return $row['codigo'];



}



function SeparaCodigos($val){



	$valor	= Quitar(strtolower(trim($val)));



	$find 	= array(',');

	$repl 	= array('<br>');

	$url 	= str_replace ($find, $repl, $valor);



	return $url;



}





function Quitar2($val){

	//PASAR VARIABLE A SANEAR

    $nopermitidos		= array("'",'\\','<','>',"\"",";","$","%","&","/","|","{","}","[","]","+","#","€","º","ª",".");

    $val		 		= str_replace($nopermitidos, " ", $val);



    return trim($val);

}



// FUNCIONES CREADAS OPOR TAO



function sacarEspacions($val){

	$dato = str_replace(' ', '', $val);

	return $dato;

}



?>

