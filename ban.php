<?php
include_once 'inc/db.php';
include_once 'inc/func.php';
$title = 'Бан';
include_once 'inc/head.php';

$sql = $vht->query("SELECT * FROM `ban` WHERE `ip`='".$myip."' OR `hash`='".$myhash."' ORDER BY `id` DESC LIMIT 1")->fetch_assoc();

echo '<div class="text">IP: '.$sql['ip'].' | HASH: '.$sql['hash'].'<br/>Забанен по причине: <b>'.$sql['pri'].'</b></div>';  

include_once 'inc/foot.php';