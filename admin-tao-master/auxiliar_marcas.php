<?php
    include '../includes/conx.php';


    require_once 'modulos/PHPExcel/Classes/PHPExcel.php';
    $archivo = "marcas_auxliares.xlsx";
    $inputFileType = PHPExcel_IOFactory::identify($archivo);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($archivo);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    $uno        = array();    //        => codigo
    $dos        = array();    //        => estado
    // $v_oferta = array();
    for ($row = 1; $row <= $highestRow; $row++){
            array_push($uno,$sheet->getCell("A".$row)->getValue());     // codigo 
            array_push($dos,$sheet->getCell("B".$row)->getValue());     // marca
    }

    // for ($i=0; $i < count($uno) ; $i++) {

    //     echo $uno[$i]." => ".$dos[$i]." => ".$tres[$i]." => ".$cuatro[$i]."<br>";

    // }



    // el valor V_PUBLICADO es el valor sin IVa EN EL CUAL SE VE EN LA WEB
    for ($i=0; $i < count($uno) ; $i++) {
        $codigo         = $uno[$i];             // => codigo
        $marca         = $dos[$i];             // => estado

        $insertar = mysql_query("UPDATE productos SET marca = '$marca' WHERE codigo = '$codigo'") or die(mysql_error());
        mysql_query($insertar);

        // $insertar = mysql_query("UPDATE productos SET stock = '$stock'  WHERE codigo = '$codigo'") or die(mysql_error());
        // mysql_query($insertar);

    }

    echo 'termino_de_la_actualizacion';


?>

