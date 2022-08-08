<?php
include_once("./cron/conx.php");
require_once('./modulos/PHPExcel/Classes/PHPExcel.php');

echo "<strong>Inicio exportacion db(demos)</strong><br>";

$lbl = date("d-m-Y")."_".rand(1, 10).rand(1, 10).rand(1, 10).rand(1, 10).rand(1, 10).rand(1, 10);


if($_POST["file"] == "") {
    $productos = array();

    $sql = "SELECT p.id, p.codigo, p.estado, p.nombre, m.marca, p.v_publicado AS precio, 
                    p.val_oferta AS p_oferta, stock
            FROM productos AS p
            INNER JOIN marcas AS m
            ON p.marca = m.id_marcas
            WHERE p.estado = 1";

    $result = $base->prepare($sql);
    $result->execute();

    while($f = $result->fetch(PDO::FETCH_OBJ)){
        array_push($productos, array("id" => $f->id, "codigo" => $f->codigo, "estado" => $f->estado, 
                                    "descripcion" => $f->nombre,"marca" => $f->marca, "precio" => $f->precio, 
                                    "val_oferta" => $f->p_oferta, "stock" => $f->stock));
    }

    $base = null;
    $result->closeCursor();
    ////
    /// crear el excel

    $obj = new PHPExcel();

    $objReader = PHPExcel_IOFactory::createrEADER("Excel2007");

    $obj = $objReader->load("template_google.xlsx");

    $obj->setActiveSheetIndex(0);

    $xlsfile = 2;

    $url = "https://www.neumatruck.cl/ficha.php?idProducto=";
    $url_img = "https://www.neumatruck.cl/productos/";
    $iva = 1.19;

    for ($i=0; $i <count($productos);$i++) { 
        $stock = $productos[$i]["stock"] > 10 ? 'in_stock':'out_of_stock';
        $val_oferta =  $productos[$i]["val_oferta"] == 0 ? '' : strval($productos[$i]["val_oferta"] * $iva). ' CLP';
        $precio = strval($productos[$i]["precio"] * $iva)." CLP";

        $obj->getActiveSheet()->SetCellValue('A'.$xlsfile, $productos[$i]["codigo"]);// codigo
        $obj->getActiveSheet()->SetCellValue('B'.$xlsfile, strtolower('Neumático '.$productos[$i]["descripcion"]));// ttiulo
        $obj->getActiveSheet()->SetCellValue('C'.$xlsfile, strtolower('Neumático '.$productos[$i]["descripcion"]));// descripcion
        $obj->getActiveSheet()->SetCellValue('D'.$xlsfile, $url.base64_encode($productos[$i]["id"]));// enlace al producto
        $obj->getActiveSheet()->SetCellValue('E'.$xlsfile, 'New');// nuevo 1= true 2 =false
        $obj->getActiveSheet()->SetCellValue('F'.$xlsfile, $precio);//precio
        $obj->getActiveSheet()->SetCellValue('G'.$xlsfile, $val_oferta);//precio oferta
        $obj->getActiveSheet()->SetCellValue('H'.$xlsfile, $stock);//disponibilidad
        $obj->getActiveSheet()->SetCellValue('I'.$xlsfile, $url_img.$productos[$i]["codigo"].'.webp');//enlace imagen
        $obj->getActiveSheet()->SetCellValue('J'.$xlsfile, '');//enlace imagen
        $obj->getActiveSheet()->SetCellValue('K'.$xlsfile, '');//enlace imagen
        $obj->getActiveSheet()->SetCellValue('L'.$xlsfile, strtolower($productos[$i]["marca"]));//marca
        $obj->getActiveSheet()->SetCellValue('M'.$xlsfile, 911);//marca

        $xlsfile ++;
    }


    $objW = PHPExcel_IOFactory::createWriter($obj, "Excel2007");
    $objW->save($lbl.".xlsx");
}else{
    echo "Creado";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="POST">
        <input type="hidden" name="file" value="<?php echo $lbl; ?>">
        <?php
            if($_POST["file"] == ""):
                ?><button type="submit">Generar</button> <?php
            endif;
        ?>
    </form>
    <?php
        if($_POST["file"]):
        ?><a href="<?php echo $_POST["file"].".xlsx"; ?>" type="button">Descargar</a><?php
        endif;
    ?>
</body>
</html>
