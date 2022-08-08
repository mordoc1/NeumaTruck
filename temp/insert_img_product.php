
<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$name   = $_GET['img'];
$lbl    = $_GET["name"];

$file = $name.'.jpg';

$image=  imagecreatefromjpeg($file);
ob_start();
imagejpeg($image,NULL,40);
$cont=  ob_get_contents();
ob_end_clean();
imagedestroy($image);
$content =  imagecreatefromstring($cont);
imagewebp($content,$lbl.'.webp');
imagedestroy($content);

$full_name = $lbl.'.webp';


copy($full_name,'../productos/'.$full_name);
unlink($full_name);

echo $full_name;





?>

