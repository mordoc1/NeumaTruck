<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$name   = $_GET['img'];


$file=$name.'.jpg';
$image=  imagecreatefromjpeg($file);
ob_start();
imagejpeg($image,NULL,40);
$cont=  ob_get_contents();
ob_end_clean();
imagedestroy($image);
$content =  imagecreatefromstring($cont);
imagewebp($content,$name.'.webp');
imagedestroy($content);

$full_name = $name.'.webp';


copy($full_name,'../img/2.0/banner/'.$full_name);
unlink($full_name);

echo $full_name;





?>