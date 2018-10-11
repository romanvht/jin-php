<?php 
session_start();
$captha = mt_rand(00001,99999);
$_SESSION['code'] = $captha;
$img = imagecreatetruecolor(70, 35);
imagefill($img, 0, 0, imagecolorallocate($img, 255, 255, 255));
imagettftext($img, 14, 0, 10, 20, imagecolorallocate($img, 0, 0, 0),'text.ttf', $_SESSION['code']);
header('Content-type: image/jpeg');
imagejpeg($img, null, mt_rand(10,70));
?>