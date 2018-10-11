<?php
include_once 'inc/db.php';
include_once 'inc/func.php';

$id = int($_GET[id]);
$sql = $vht->query("SELECT * FROM `pers_img`WHERE `id` = '$id'")->fetch_assoc();	
if(empty($sql['img']))header("Location: /");

$title = 'Изображение';
include_once 'inc/head.php';

echo '<div class="text"><img style="max-width: 250px; border-radius: 5px;" src="'.$sql['img'].'"/></div>';

include_once 'inc/foot.php';
?>