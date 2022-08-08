<?php
    include '../includes/conx.php';


    require_once 'modulos/PHPExcel/Classes/PHPExcel.php';
    $archivo = "db.xlsx";
    $inputFileType = PHPExcel_IOFactory::identify($archivo);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($archivo);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    $uno        = array();    //        => codigo
    $dos        = array();    //        => estado
    $tres       = array();    //        => stock
    $cuatro     = array();    //        => v_pulicado
    $cinco      = array();    //        => base
    // $v_oferta = array();
    for ($row = 1; $row <= $highestRow; $row++){
            array_push($uno,$sheet->getCell("A".$row)->getValue());     // codigo 
            array_push($dos,$sheet->getCell("B".$row)->getValue());     // estado
            array_push($tres,$sheet->getCell("C".$row)->getValue());     // stock
            array_push($cuatro,$sheet->getCell("D".$row)->getValue());     // v_pulicado
            array_push($cinco,$sheet->getCell("E".$row)->getValue());     // base
    }

    // for ($i=0; $i < count($uno) ; $i++) {

    //     echo $uno[$i]." => ".$dos[$i]." => ".$tres[$i]." => ".$cuatro[$i]."<br>";

    // }

    // el valor V_PUBLICADO es el valor sin IVa EN EL CUAL SE VE EN LA WEB
    for ($i=0; $i < count($uno) ; $i++) {
        $codigo         = $uno[$i];             // => codigo
        $estado         = $dos[$i];             // => estado
        $stock          = $tres[$i];            // => stock
        $v_publicado    = $cuatro[$i];          // => v_pulicado
        $v_base         = $cinco[$i];           // => base

        $insertar = mysql_query("UPDATE productos SET stock = '$stock', v_lista = '$v_base', v_publicado = '$v_publicado'   WHERE codigo = '$codigo' AND oferta = 0") or die(mysql_error());
        mysql_query($insertar);

        $insertar = mysql_query("UPDATE productos SET stock = '$stock'  WHERE codigo = '$codigo'") or die(mysql_error());
        mysql_query($insertar);

    }







    echo "termino_producto_base";



?>

