<?php

// include_once('../funciones/funciones.php');

// include_once('../funciones/conexion.php');

function card_demooooo($of, $marcas,$img, $apli, $stk, $ids, $std, $nombre, $cod, $voferta, $vpublicado){
  $link = mysql_connect("localhost", "neum45356_neumatruck", "7340458Tao");
  mysql_select_db("neum45356_neumatruck",$link) OR DIE ("Error: No es posible establecer la conexión");
  mysql_set_charset('utf8');

  $title_1 = '';
  $title_2 = '';
  $title_3 = '';

  $re = mysql_query("SELECT title FROM configuracion_title WHERE id = 1 LIMIT 1") or die(mysql_error());
  while($f = mysql_fetch_array($re)){
    $title_1 = strtoupper($f['title']);
  }

  $re = mysql_query("SELECT title FROM configuracion_title WHERE id = 2 LIMIT 1") or die(mysql_error());
  while($f = mysql_fetch_array($re)){
    $title_2 = strtoupper($f['title']);
  }

  $min_stock = 0;
  $re = mysql_query("SELECT resultado FROM configuracion WHERE tipo = 'minimo_stock' ") or die(mysql_error());
  while($f = mysql_fetch_array($re)){
    $min_stock = strtoupper($f['resultado']);
  }

  $sacar_marca  = 'marca'.sacarEspacions($marcas);
  $medidas      = "medida".Quitar5($medidas);
  $media        = _GetOriginal.'productos/'.$img.'.webp';
  $marca        = $marcas;
  $aplicacion   = $apli;
  $stock        = $stk;
  $stado        = $std;
  $url          = 'ficha.php?idProducto='.base64_encode($ids);
  $titulo       = substr($nombre,0,25);
  $codigo       = 'COD: '.$cod;
  $id           = $ids;

  $html = '';
  // $marcas       = $productos[$i]["marca"];

  // $medidas      = $productos[$i]["medidas"];
  if($of == 1){
    $precio = '<h4 class="product-price">$'.MonedaTruckIVA($voferta).' c/iva</h4>';
    $lblOferta = '<span class="new">'.$title_1.'</span>';
  }else if($of == 2){
    $precio = '<h4 class="product-price">$'.MonedaTruckIVA($voferta).' c/iva</h4>';
    $lblOferta = '<span class="new">'.$title_2.'</span>';
  }else if($of == 3){
    $precio = '<h4 class="product-price">$'.MonedaTruckIVA($voferta).' c/iva</h4>';
    $lblOferta = '<img style="width: 80px;margin-left: 0px;margin-top: 0px;" src="img/of.svg">';
  }else {
    $precio = '<h4 class="product-price">$'.MonedaTruckIVA($vpublicado).' c/iva</h4>';
    $lblOferta = '';
  }


  $html .= '<div class="col-md-4 col-xs-6 resfiltro '.$sacar_marca.' '.$medidas.' ">';
  $html .= '<div class="product">';
  $html .= '<a href="'.$url.'"><div class="product-img">';
  $html .= '<img src="'.$media.'">';
  $html .= '<div class="product-label-oferta">';
  $html .= $lblOferta;
  $html .= '</div>';
  $html .= '<div class="product-label">';
  $html .= '<span class="new">'.$marca.'</span>';
  $html .= '</div>';
  $html .= '</div></a>';
  $html .= '<div class="product-body">';
  $html .=  $aplicacion != "" ?  '<span class="new">'.$aplicacion.'</span>':  "<br>";
  $html .= '<div class="product-label">';
  if ($stock == 0 OR $stado == 0 OR $stock <= $min_stock) {
    $html .= '<span class="new" style="color:green;">Consultar Stock</span>';
  }else {
    $html .= '<br>';
  }
  $html .= '</div>';
  $html .= '<h3 class="product-name"><a href="'.$url.'">'.$titulo.'</a></h3>';
  $html .= $precio;
  $html .=  $of !=0 ? '<p style="color:red;margin-top:0px;margin-bottom:0px">Precio Lista <del>260.299.-</del></p>' : '<br>' ;
  $html .= '<p>'.$codigo.'</p>';
  $html .= '</div>';
  $html .= '<div class="add-to-cart">';
  if ($stock == 0 OR $stado == 0 OR $stock <= $min_stock) {
    $html .= '<button onclick="href_envio("'.$id.'")" class="add-to-cart-btn2" rel="href_envio("'.$id.'")">Ver</button>';
  }else{
    $html .= '<button class="add-to-cart-btn agregacarro" rel="'.$id.'"><i class="fa fa-shopping-cart"></i>Agregar Al Carro</button>';
  }
  $html .= '</div>';
  $html .= '</div>';
  $html .= '</div>';
  return $html;

}


function show_card($of, $marcas,$img, $apli, $stk, $ids, $std, $nombre, $cod, $voferta, $vpublicado){
    $link = mysql_connect("localhost", "neum45356_neumatruck", "7340458Tao");
    mysql_select_db("neum45356_neumatruck",$link) OR DIE ("Error: No es posible establecer la conexión");
    mysql_set_charset('utf8');

    $title_1 = '';
    $title_2 = '';
    $title_3 = '';

    $re = mysql_query("SELECT title FROM configuracion_title WHERE id = 1 LIMIT 1") or die(mysql_error());
    while($f = mysql_fetch_array($re)){
      $title_1 = strtoupper($f['title']);
    }

    $re = mysql_query("SELECT title FROM configuracion_title WHERE id = 2 LIMIT 1") or die(mysql_error());
    while($f = mysql_fetch_array($re)){
      $title_2 = strtoupper($f['title']);
    }

    $min_stock = 0;
    $re = mysql_query("SELECT resultado FROM configuracion WHERE tipo = 'minimo_stock' ") or die(mysql_error());
    while($f = mysql_fetch_array($re)){
      $min_stock = strtoupper($f['resultado']);
    }

    $sacar_marca  = 'marca'.sacarEspacions($marcas);
    $medidas      = "medida".Quitar5($medidas);
    $media        = _GetOriginal.'productos/'.$img.'.webp';
    $marca        = $marcas;
    $aplicacion   = $apli;
    $stock        = $stk;
    $stado        = $std;
    $url          = 'ficha.php?idProducto='.base64_encode($ids);
    $titulo       = substr($nombre,0,25);
    $codigo       = 'COD: '.$cod;
    $id           = $ids;

    $html = '';
    // $marcas       = $productos[$i]["marca"];

    // $medidas      = $productos[$i]["medidas"];
    if($of == 1){
      $precio = '<h4 class="product-price">$'.MonedaTruckIVA($voferta).' <del class="product-old-price">$'.MonedaTruckIVA($vpublicado).'</del> c/iva</h4>';
      $lblOferta = '<span class="new">'.$title_1.'</span>';
    }else if($of == 2){
      $precio = '<h4 class="product-price">$'.MonedaTruckIVA($voferta).' <del class="product-old-price">$'.MonedaTruckIVA($vpublicado).'</del> c/iva</h4>';
      $lblOferta = '<span class="new">'.$title_2.'</span>';
    }else if($of == 3){
      $precio = '<h4 class="product-price">$'.MonedaTruckIVA($voferta).' <del class="product-old-price">$'.MonedaTruckIVA($vpublicado).'</del> c/iva</h4>';
      $lblOferta = '<img style="width: 80px;margin-left: 0px;margin-top: 0px;" src="img/of.svg">';
    }else {
      $precio = '<h4 class="product-price">$'.MonedaTruckIVA($vpublicado).' c/iva</h4>';
      $lblOferta = '';
    }


    $html .= '<div class="col-md-4 col-xs-6 resfiltro '.$sacar_marca.' '.$medidas.' ">';
    $html .= '<div class="product">';
    $html .= '<a href="'.$url.'"><div class="product-img">';
    $html .= '<img src="'.$media.'">';
    $html .= '<div class="product-label-oferta">';
    $html .= $lblOferta;
    $html .= '</div>';
    $html .= '<div class="product-label">';
    $html .= '<span class="new">'.$marca.'</span>';
    $html .= '</div>';
    $html .= '</div></a>';
    $html .= '<div class="product-body">';
    $html .=  $aplicacion != "" ?  '<span class="new">'.$aplicacion.'</span>':  "<br>";
    $html .= '<div class="product-label">';
    if ($stock == 0 OR $stado == 0 OR $stock <= $min_stock) {
      $html .= '<span class="new" style="color:green;">Consultar Stock</span>';
    }else {
      $html .= '<br>';
    }
    $html .= '</div>';
    $html .= '<h3 class="product-name"><a href="'.$url.'">'.$titulo.'</a></h3>';
    $html .= $precio;
    $html .= '<span>'.$codigo.'</span>';
    $html .= '</div>';
    $html .= '<div class="add-to-cart">';
    if ($stock == 0 OR $stado == 0 OR $stock <= $min_stock) {
      $html .= '<button onclick="href_envio("'.$id.'")" class="add-to-cart-btn2" rel="href_envio("'.$id.'")">Ver</button>';
    }else{
      $html .= '<button class="add-to-cart-btn agregacarro" rel="'.$id.'"><i class="fa fa-shopping-cart"></i>Agregar Al Carro</button>';
    }
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
  return $html;
}

function card_index($of, $marcas,$img, $apli, $stk, $ids, $std, $nombre, $cod, $voferta, $vpublicado){
  include('comx.php');
  $title_1 = '';
  $title_2 = '';
  $title_3 = '';

  $re = mysql_query("SELECT title FROM configuracion_title WHERE id = 1 LIMIT 1") or die(mysql_error());
  while($f = mysql_fetch_array($re)){
    $title_1 = strtoupper($f['title']);
  }

  $re = mysql_query("SELECT title FROM configuracion_title WHERE id = 2 LIMIT 1") or die(mysql_error());
  while($f = mysql_fetch_array($re)){
    $title_2 = strtoupper($f['title']);
  }
  $min_stock = 0;
  $re = mysql_query("SELECT resultado FROM configuracion WHERE tipo = 'minimo_stock' ") or die(mysql_error());
  while($f = mysql_fetch_array($re)){
    $min_stock = strtoupper($f['resultado']);
  }

  $sacar_marca  = 'marca'.sacarEspacions($marcas);
  $medidas      = "medida".Quitar5($medidas);
  $media        = _GetOriginal.'productos/'.$img.'.webp';
  $marca        = $marcas;
  $aplicacion   = $apli;
  $stock        = $stk;
  $stado        = $std;
  $url          = 'ficha.php?idProducto='.base64_encode($ids);
  $titulo       = substr($nombre,0,25);
  $codigo       = 'COD: '.$cod;
  $id           = $ids;

  $html = '';
  if($of == 1){
    $precio = '<h4 class="product-price">$'.MonedaTruckIVA($voferta).' <del class="product-old-price">$'.MonedaTruckIVA($vpublicado).'</del> c/iva</h4>';
    $lblOferta = '<span class="new">'.$title_1.'</span>';
  }else if($of == 2){
    $precio = '<h4 class="product-price">$'.MonedaTruckIVA($voferta).' <del class="product-old-price">$'.MonedaTruckIVA($vpublicado).'</del> c/iva</h4>';
    $lblOferta = '<span class="new">'.$title_2.'</span>';
  }else if($of == 3){
    $precio = '<h4 class="product-price">$'.MonedaTruckIVA($voferta).' <del class="product-old-price">$'.MonedaTruckIVA($vpublicado).'</del> c/iva</h4>';
    $lblOferta = '<img style="width: 80px;margin-left: 0px;margin-top: 0px;" src="img/of.svg">';
  }else {
    $precio = '<h4 class="product-price">$'.MonedaTruckIVA($vpublicado).' c/iva</h4>';
    $lblOferta = '';
  }

  $html .= '<div class="product">';
  $html .= '<div class="product-img">';
  $html .= '<a href="'.$url.'"><img src="'.$media.'">';
  $html .= '<div class="product-label-oferta">';
  $html .= $lblOferta;
  $html .= '</div>';
  $html .= '<div class="product-label"><span class="new">'.$marca.'</span></div>';
  $html .= '<div class="product-label">';
  $html .= '</div>';
  $html .= '</div></a>';
  $html .= '<div class="product-body">';
  $html .=  $aplicacion != "" ?  '<span class="new">'.$aplicacion.'</span>':  "<br>";
  $html .= '<h3 class="product-name"><a href="'.$url.'">'.$titulo.'</a></h3>';
  $html .= '<div class="product-label">';
  if ($stock == 0 OR $stado == 0 OR $stock <= $min_stock) {
    $html .= '<span class="new" style="color:green;">Consultar Stock</span>';
  }else {
    $html .= '<br>';
  }
  $html .= '</div>';
	$html .= $precio;
  $html .= '<span>'.$codigo.'</span>';
  $html .= '</div>';
  $html .= '<div class="add-to-cart">';
  if ($stock == 0 OR $stado == 0 OR $stock <= $min_stock) {
    $html .= '<button onclick="href_envio("'.$id.'")" class="add-to-cart-btn2" rel="href_envio("'.$id.'")">Ver</button>';
  }else{
    $html .= '<button class="add-to-cart-btn agregacarro" rel="'.$id.'"><i class="fa fa-shopping-cart"></i>Agregar Al Carro</button>';
  }
  $html .= '</div>';
  $html .= '</div>';

  return $html;
}



 ?>

