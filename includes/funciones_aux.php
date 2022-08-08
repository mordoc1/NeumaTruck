<?php



// function saleOffer(){

//   include 'conx.php';

//   $productos = array();

//     $re = mysql_query("SELECT p.id, p.codigo, p.estado, p.nombre, p.stock , m.marca, p.medidas, a.aplicacion, p.media, p.oferta, p.val_oferta, p.v_lista, p.v_publicado

// 						FROM productos AS p

//             INNER JOIN aplicaciones as a

//             ON p.aplicacion = a.id_nex

// 						INNER JOIN marcas AS m

// 						ON p.marca = m.id_marcas

// 						WHERE p.oferta = 2 AND  p.v_publicado != 0 ORDER BY p.id ASC ") or die(mysql_error());

//     while($f = mysql_fetch_array($re)){

//       array_push($productos,array("id" => $f["id"], "estado" => $f["estado"],"codigo" => $f["codigo"], "nombre" => $f["nombre"], "stock" => $f["stock"], "marca" => $f["marca"], "categoria" => $f["categoria"],

//                     "medidas" => $f["medidas"],"aro" => $f["aro"], "aplicacion" => $f["aplicacion"], "v_lista" => $f["v_lista"], "v_publicado" => $f["v_publicado"],

//                     "media" => $f["media"], "of" => $f["oferta"], "v_oferta" => $f["val_oferta"]));

//     }

//

//     mysql_close();

//     return $productos;

// }



$Limite_stock = limite_busqueda();



 


function detectar_ofertas(){

  include 'conx.php';

  $estado_oferta = 0;

  $re = mysql_query("SELECT resultado FROM configuracion WHERE tipo = 'ofertas' ") or die(mysql_error());

  while($f = mysql_fetch_array($re)){

    $estado_oferta = $f['resultado'];

  }

  mysql_close();

  return $estado_oferta;

}





function select_regiones(){

  include 'conx.php';

  $regiones = array();



    $re = mysql_query("SELECT DISTINCT (region), id_reg FROM regiones ORDER BY id_reg DESC") or die(mysql_error());

    while($f = mysql_fetch_array($re)){

      array_push($regiones,array("id_reg" => $f["id_reg"], "region" => $f["region"]));

    }

    mysql_close();

    return $regiones;

}





function obtener_stock($id){

  include 'conx.php';

  $limite_stock = 0;



  $re = mysql_query("SELECT stock FROM productos WHERE id = '$id'") or die(mysql_error());

    while($f = mysql_fetch_array($re)){

      $limite_stock = $f["stock"];

  }

    mysql_close();

  return $limite_stock;

}



function productos_oferta(){

  include 'conx.php';

  $productos = array();

    $re = mysql_query("SELECT p.id, p.codigo, p.estado, p.nombre, p.stock , m.marca, p.medidas, a.aplicacion, p.media, p.oferta, p.val_oferta, p.v_lista, p.v_publicado

						FROM productos AS p

            INNER JOIN aplicaciones as a

            ON p.aplicacion = a.id_nex

						INNER JOIN marcas AS m

						ON p.marca = m.id_marcas

						WHERE p.oferta = 1 AND  p.v_publicado != 0 ORDER BY p.id ASC ") or die(mysql_error());

    while($f = mysql_fetch_array($re)){

      array_push($productos,array("id" => $f["id"], "estado" => $f["estado"],"codigo" => $f["codigo"], "nombre" => $f["nombre"], "stock" => $f["stock"], "marca" => $f["marca"], "categoria" => $f["categoria"],

                    "medidas" => $f["medidas"],"aro" => $f["aro"], "aplicacion" => $f["aplicacion"], "v_lista" => $f["v_lista"], "v_publicado" => $f["v_publicado"],

                    "media" => $f["media"], "of" => $f["oferta"], "v_oferta" => $f["val_oferta"]));

    }



    mysql_close();



    return $productos;

}



function busqueda_nav_marcas_categoria($categoria){

    include 'conx.php';

    $marcas = array();

    $re = mysql_query("SELECT DISTINCT m.marca

						FROM productos AS p

						INNER JOIN marcas AS m

						ON p.marca = m.id_marcas

						WHERE p.categoria LIKE '$categoria' AND p.v_publicado != 0 AND p.estado = 1 AND p.stock >= '$Limite_stock' ORDER BY m.prioridad DESC") or die(mysql_error());

	  while($f = mysql_fetch_array($re)){

		  array_push($marcas, array("marca" => $f["marca"]));

    }

    mysql_close();

    return $marcas;

}



function busqueda_nav_medidas_categoria($categoria){

  include 'conx.php';

  $medidas = array();

	$re = mysql_query("SELECT DISTINCT medidas FROM productos WHERE categoria LIKE '$categoria' AND v_publicado !=0 AND stock > '$L' AND estado = 1 ") or die(mysql_error());

    while($f = mysql_fetch_array($re)){

		array_push($medidas, array("medidas" => $f["medidas"]));

	}

  mysql_close();

  return $medidas;

}



function busqueda_nav_marcas($busqueda){

    include 'conx.php';

    $marcas = array();

    $re = mysql_query("SELECT DISTINCT m.marca

						FROM productos AS p

						INNER JOIN marcas AS m

						ON p.marca = m.id_marcas

						WHERE p.busqueda LIKE '$busqueda' AND p.v_publicado != 0 AND p.estado = 1 ORDER BY m.prioridad DESC") or die(mysql_error());

	  while($f = mysql_fetch_array($re)){

		  array_push($marcas, array("marca" => $f["marca"]));

    }

    mysql_close();

    return $marcas;

}





function busqueda_nav_medida($busqueda){

    include 'conx.php';



    $medidas = array();



	$re = mysql_query("SELECT DISTINCT medidas FROM productos WHERE busqueda LIKE '$busqueda' AND v_publicado !=0 AND estado = 1 ") or die(mysql_error());

    while($f = mysql_fetch_array($re)){

		array_push($medidas, array("medidas" => $f["medidas"]));

	}

    mysql_close();



    return $medidas;

}





function limite_busqueda(){

    include 'conx.php';

    $limite = 0;

    $re = mysql_query("SELECT * FROM configuracion WHERE tipo = 'minimo_stock'") or die(mysql_error());

    while($f = mysql_fetch_array($re)){

		$limite = $f['resultado'];

    }

    return $limite;

}



function GeneraId2($longitud,$tipo="alfanumerico"){

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



function limpiarBusqueda($dato){

  $resul = str_replace("/","",$dato);

  $resul2 = str_replace("-","",$resul);

  $resul3 = str_replace(".","",$resul2);

  $resul4 = str_replace("+","",$resul3);

  $resul5 = str_replace("-","",$resul4);

  $resul6 = str_replace(" ","",$resul5);

  return $resul6;

}



function busquda_producto_categoria($categoria){
  include 'conx.php';
  $productos = array();

  $re = mysql_query("SELECT p.id, p.estado, p.codigo , p.nombre, p.stock , m.marca, p.medidas, a.aplicacion, p.media, p.oferta, p.val_oferta, p.v_lista, p.v_publicado
						FROM productos AS p
						INNER JOIN aplicaciones AS a
						ON p.aplicacion = a.id_nex
						INNER JOIN marcas AS m
						ON p.marca = m.id_marcas
						WHERE p.categoria LIKE '$categoria' AND p.v_publicado != 0 AND p.stock >= '$Limite_stock' ORDER BY p.priority ASC ") or die(mysql_error());
  while($f = mysql_fetch_array($re)){
    array_push($productos,array("id" => $f["id"], "estado" => $f["estado"],"codigo" => $f["codigo"], "nombre" => $f["nombre"], "stock" => $f["stock"], "marca" => $f["marca"],
                                  "medidas" => $f["medidas"], "aplicacion" => $f["aplicacion"], "media" => $f["media"], "of" => $f["oferta"], "v_oferta" => $f["val_oferta"],
                                  "v_lista" => $f["v_lista"], "v_publicado" => $f["v_publicado"]));

  }



  mysql_close();

  return $productos;



}



function busqueda_productos($busqueda){

    include 'conx.php';

    $productos = array();



    $re = mysql_query("SELECT p.id, p.estado, p.codigo, p.nombre, p.stock , m.marca, p.medidas, a.aplicacion, p.media, p.oferta, p.val_oferta, p.v_lista, p.v_publicado

                      FROM productos AS p

                      INNER JOIN marcas AS m

                      ON p.marca = m.id_marcas

                      INNER JOIN aplicaciones AS a

                      ON p.aplicacion = a.id_nex

                      WHERE p.busqueda LIKE '$busqueda' AND p.v_publicado != 0 AND p.stock >= '$Limite_stock'  ORDER BY p.priority ASC ") or die(mysql_error());

      while($f = mysql_fetch_array($re)){

      array_push($productos,array("id" => $f["id"], "estado" => $f["estado"],"codigo" => $f["codigo"], "nombre" => $f["nombre"], "stock" => $f["stock"], "marca" => $f["marca"],

                                  "medidas" => $f["medidas"], "aplicacion" => $f["aplicacion"], "media" => $f["media"], "of" => $f["oferta"], "v_oferta" => $f["val_oferta"],

                                  "v_lista" => $f["v_lista"], "v_publicado" => $f["v_publicado"]));

    }

    mysql_close();

    return $productos;

}



function buscar_marca($busqueda){

    include 'conx.php';

    $productos = array();

    $re = mysql_query("SELECT p.id, p.estado, p.codigo, p.nombre, p.stock , m.marca, p.medidas, a.aplicacion, p.media, p.oferta, p.val_oferta, p.v_lista, p.v_publicado

                      FROM productos AS p

                      INNER JOIN marcas AS m

                      ON p.marca = m.id_marcas

                      INNER JOIN aplicaciones AS a

                      ON p.aplicacion = a.id_nex

                      WHERE m.id_marcas = '$busqueda' AND p.v_publicado != 0 ") or die(mysql_error());

    while($f = mysql_fetch_array($re)){

		array_push($productos,array("id" => $f["id"], "codigo" => $f["codigo"], "estado" => $f["estado"],"nombre" => $f["nombre"], "stock" => $f["stock"], "marca" => $f["marca"], "categoria" => $f["categoria"],

									 "medidas" => $f["medidas"],"aro" => $f["aro"], "aplicacion" => $f["aplicacion"], "v_lista" => $f["v_lista"], "v_publicado" => $f["v_publicado"],

									 "media" => $f["media"], "of" => $f["oferta"], "v_oferta" => $f["val_oferta"]));

    }





    return $productos;

}





?>

