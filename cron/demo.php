<?php
// echo "esdart software BY taoista 2"."<br>";


?>

<?php require_once('mailreader.php'); ?>
<!doctype html>
<html>
<head>
	<title></title>
	<meta charset="utf-8" />
</head>
<body>
	<?php
         $email = new EmailReader();
         $inbox = $email->getInbox();
    // echo "total de registros => ".count($inbox);


    // $index = $inbox[0]["index"];
    // $algo = json_decode(json_encode($inbox[0]["header"]), true);
    // echo $algo["date"].'<br>';
    // echo $algo["subject"].'<br>';
    // echo $algo["Subject"].'<br>';
    // echo $algo["fromaddress"].'<br>';
    // $array_from = json_decode(json_encode($algo["from"]), true);
    // echo $array_from[0]["personal"].'<br>';
    // echo $array_from[0]["mailbox"]."@".$array_from[0]["host"].'<br>';
    // $sender = json_decode(json_encode($algo["sender"]), true);
    // echo $sender[0]["personal"].'<br>';

    $valor = $inbox[1]["body"];

    $data = strpos($valor, "\n");

    // echo $algo["body"].'<br>';
    $demo =  explode("\n", $valor);

    // echo $inbox[1]["index"].'<br>';


    // for ($i=0; $i < count($inbox) ; $i++) { 
    //     echo $inbox[$i].'<br>';
    // }

	?>
</body>
</html>

<!-- <?php echo "temrino" ?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        echo $data.'<br>';
        echo $valor[1];
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo $valor[45];
        echo "<br>";
        echo "<br>";
        // echo $valor;
        echo "<br>";
        echo "<br>";
        echo "<br>";

    //    for ($i=0; $i <count($demo) ; $i++) { 
    //        echo $demo[$i].'<br>';
    //    }

    echo 'saltar--------->'.$demo[6].'<br>';
    echo $demo[7].'<br>';
    echo $demo[8].'<br>';
    echo $demo[9].'<br>';
    echo $demo[10].'<br>';
    echo $demo[11].'<br>';
    echo $demo[12].'<br>';
    echo $demo[13].'<br>';
    echo $demo[14].'<br>';
    echo $demo[15].'<br>';
    echo $demo[16].'<br>';
    echo $demo[17].'<br>';
    echo $demo[18].'<br>';
    echo $demo[19].'<br>';
    echo $demo[20].'<br>';
    echo $demo[21].'<br>';
    echo $demo[22].'<br>';
    echo $demo[23].'<br>';
    echo $demo[24].'<br>';


    ?>
</body>
</html>