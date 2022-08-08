<?php
    $mysql_hostname = "localhost";
    $mysql_user = "neum45356_neumatruck";
    $mysql_password = "7340458Tao";
    $mysql_database = "neum45356_neumatruck";
    $mysql_database = "neum45356_neumatruck";



$base = new PDO('mysql:host='.$mysql_hostname.'; dbname='.$mysql_database, $mysql_user, $mysql_password);

$base->exec("SET CHARACTER SET utf8");


    require_once 'modulos/PHPExcel/Classes/PHPExcel.php';
    $archivo = "neumatruck.xlsx";
    $inputFileType = PHPExcel_IOFactory::identify($archivo);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($archivo);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    $uno = array();     //      => codigo
    $dos = array();     //      => estado
    $tres = array();    //     => stock
    $cuatro = array();  //   => v_publicado
    $cinco = array();   //  => v_lista
    // $v_oferta = array();
    for ($row = 1; $row <= $highestRow; $row++){
            array_push($uno,$sheet->getCell("A".$row)->getValue());     // CODIGO
            array_push($dos,$sheet->getCell("B".$row)->getValue());     // ESTADO

    }

    for ($i=0; $i < count($uno) ; $i++) {
      $id = $uno[$i];
      $key = $dos[$i];
      $stmt = $base->prepare("UPDATE productos SET busqueda = '$key' WHERE id = '$id'");
      $stmt->execute();

    }

    $base = null;
    $result->closeCursor();






    echo "termino";



?>
